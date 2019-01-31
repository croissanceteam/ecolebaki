<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location:login');
}
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Reporting payments</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="dist/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet" type="text/css">
        <link href="dist/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

        <link href="dist/css/custom.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css" media="screen">
          table td{
              /* border: 1px solid #CFD1D2; */
              padding:1mm;
          }
          td.value{
              font-family: Arial, Helvetica, sans-serif;
              width:450px;
          }
          td.label{
              font-weight:bold;
              width:200px;
          }
        </style>

    </head>

    <body ng-app='app' ng-controller="CtrlStudent">

        <div id="wrapper">
            <?php require_once 'partials/menu-bar.php'; ?>
            <div id="page-wrapper">
                <div class="row">
                <div style="display: none;" class="alert alert-info" role="alert" id="info_alert">Message</div>
                    <div class="loader" id="loader">
                        <img src="dist/images/loader/spinner.gif">
                    </div>
                    <div class="col-lg-12" id="header" ng-show="!isLoading" style="display:none">
                        <h4>
                            <?php echo "DIRECTION : CS BAKI / " . $_SESSION['direction']; ?>
                        </h4>
                        <label id="lbldepartement" style="display:none;"><?php echo $_SESSION['direction']; ?></label>
                    </div>
                </div>
                <div class="row" id="headerReport" ng-show="headerReport" style="display:none">
                    <div class="col-lg-12" style="padding: 0mm 8mm;">
                        <div>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: left;width: 67%;"><h3 style="margin-bottom:22px;"> ECOLE BAKI / <?= $_SESSION['direction'] ?></h3>Nº12, Av. EZO <br>Q/YOLO-NORD<br>C/KALAMU.<br>Site web: http://www.ecolebaki.com </td>
                                    <td style="text-align: right; width: 33%"><img src="dist/images/logo-reverse.png" width="150" alt="Logo"> </td>
                                </tr>

                            </table>
                        </div>
                        <div style="text-align: center; margin-bottom: 30px; padding-bottom:10px; border-top:2px solid grey; border-bottom:2px solid grey;">
                            <h2>REPORTING DES PAIEMENTS</h2>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row" id="ctrl1" ng-show="!isVisibeCtrl" style="display:none">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="height:3.3em">
                                Critères de recherche
                                <button type="button" class="btn btn-success" ng-click="sendRequestTab()" style="float:right;margin-top:-0.3em">
                                    Rechercher <i class="fa fa-search"></i>
                                </button>
                                <button id="preview" ng-click="PrinteTabPay()" ng-show="isVisibilityPay" style="float:right;margin-top:-0.3em;margin-right:0.56em;" type="button" class="btn btn-success">
                                    voir impression <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <!--/.panel-heading-->
                            <div class="panel-body">
                                <div style="text-align:center;padding-left:4em;" ng-show="!isVisibeCtrl">
                                    <div class="form-group" style="float:left;padding-right:1em;">
                                        <label for="year">ANNEES SCOLAIRES</label>

                                        <select id="year" ng-model="cbo_year" ng-change="criteriaChanged()" class="chzn-select" style="width:100%">

                                            <option>2017-2018</option>
                                            <option>2018-2019</option>

                                        </select>
                                    </div>
                                    <div class="form-group" style="float:left;padding-right:1em;">
                                        <label for="promotion">LES PROMOTIONS</label>
                                        <select id="promotion" ng-model="cbo_promotion" ng-change="criteriaChanged()" class="chzn-select" style="width:100%">

                                            <optgroup label="--MATERNELLE--"></optgroup>
                                            <option>1ère MATERNELLE</option>
                                            <option>2eme MATERNELLE</option>
                                            <option>3eme MATERNELLE</option>

                                            <optgroup label="--PRIMAIRE--"></optgroup>
                                            <option>1ere PRIMAIRE</option>
                                            <option>2eme PRIMAIRE</option>
                                            <option>3eme PRIMAIRE</option>
                                            <option>4eme PRIMAIRE</option>
                                            <option>5eme PRIMAIRE</option>
                                            <option>6eme PRIMAIRE</option>

                                        </select>
                                    </div>
                                    <div class="form-group" style="float:left;padding-right:1em;">
                                        <label for="frais">LES FRAIS</label>
                                        <select id="frais" class="chzn-select" ng-model="cbo_frais" ng-change="criteriaChanged()" style="width:100%">

                                            <!-- <optgroup label="--FRAIS INSCRIPTIONS--"></optgroup>
                                            <option value="SUB">INSCRIPTION</option>
                                            <option value="RESUB">RE-INSCRIPTION</option> -->

                                            <optgroup label="--FRAIS SCOLAIRES--"></optgroup>
                                            <option value="all">TOUTES</option>
                                            <option value="1TRF">1ere TRANCHE</option>
                                            <option value="2TRF">2eme TRANCHE</option>
                                            <option value="3TRF">3eme TRANCHE</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/.panel-body-->

                        </div>
                        <!--/.panel-->
                    </div>
                </div>
                <!-- /.row -->

                <div class="row" id="blockPaie" ng-show="!isVisibeCtrl" style="display:none">
                    <!-- block -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="height:3.7em">
                                Table des données
                                <div class="controls" style="float:right;width:50%;">
                                    <input ng-model="req" ng-change="queryTab()" class="form-control" placeholder="Rechercher un élève"  type="text" style="width:100%;" value="">
                                </div>
                            </div>
                            <div class="panel-body">
                                <table  ng-show="isVisibilityPay" style="font-weight:bold;">
                                <tr class="primary">
                                        <td class="label-text">
                                            Année scolaire
                                        </td>
                                        <td>
                                            : {{cbo_year}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Promotion
                                        </td>
                                        <td>
                                            : {{cbo_promotion}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Type de frais
                                        </td>
                                        <td>
                                            : <span class="txt_feesType"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td>
                                            DIRECTION
                                        </td>
                                        <td>
                                            : <?php //echo $_SESSION['direction']; ?>
                                        </td>
                                    </tr> -->
                                </table>
                                <hr/>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>MATRICULE</th>
                                            <th>NOM ELEVE</th>
                                            <th id="tr_sexe">SEXE</th>
                                            <th>IDPAY</th>
                                            <th>DATEPAIE</th>
                                            <th>HEUREPAIE</th>
                                            <th>PERCEPTEUR</th>
                                            <th>MONTANT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="success" ng-repeat="row in tablePay| filter:req">
                                            <td>{{row._MAT}}</td>
                                            <td>{{row._NAME}}</td>
                                            <td>{{row._SEX}}</td>
                                            <td>{{row._IDPAY}}</td>
                                            <td>{{row._DATEPAY}}</td>
                                            <td>{{row._TIMEPAY}}</td>
                                            <td>{{row._AGENT}}</td>
                                            <td>{{row._AMOUNT}}</td>
                                        </tr>


                                    </tbody>
                                </table>
                                <div style="width:95%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                                    <label for="" style="width:auto;float:left;font-weight:bold;">TOTAL A PAYER</label>
                                    <label for="" style="float:right;width:auto;font-weight:bold">
                                        {{totalGlobal}} $
                                    </label>
                                </div>
                                <div style="width:95%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                                    <label for="" style="width:auto;float:left;font-weight:bold;">TOTAL PAYE</label>
                                    <label for="" style="float:right;width:auto;font-weight:bold">
                                        {{totalTabpay}} $
                                    </label>
                                </div>
                                <div style="width:95%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                                    <label for="" style="width:auto;float:left;font-weight:bold;">RESTE A PAYER</label>
                                    <label for="" style="float:right;width:auto;font-weight:bold">
                                        {{resteTabpay}} $
                                    </label>
                                </div>

                            </div>
                            <!--/.panel-body-->
                        </div>
                         <!--/.panel -->
                    </div>

                </div>
                <!-- /block paie -->
                <?php
                $SlicePayment = $_SESSION['slices'];
// echo var_dump($SlicePayment);
                $totalFRSCO = 0;

                foreach ($SlicePayment as $key => $value) {
                    $totalFRSCO += trim($value->_AMOUNT);
                    switch ($value->_CODESLICE) {
                        case '1TRF':
                            $_SESSION['1TRF'] = trim($value->_AMOUNT);
                            break;
                        case '2TRF':
                            $_SESSION['2TRF'] = trim($value->_AMOUNT);
                            break;
                        case '3TRF':
                            $_SESSION['3TRF'] = trim($value->_AMOUNT);
                            break;
                        default:
                            $_SESSION["nothing"] = "Zero";
                            break;
                    }
                }

                ?>
                <label for="" id="lbl1TRF" style="display:none;">

                    <?php
                    echo $_SESSION['1TRF'];
                    ?>
                </label>
                <label for="" id="lbl2TRF" style="display:none;">
                    <?php
                    echo $_SESSION['2TRF'];
                    ?>
                </label>
                <label for="" id="lbl3TRF" style="display:none;">
                    <?php
                    echo $_SESSION['3TRF'];
                    ?>
                </label>
                <label for="" id="lblFRSCO" style="display:none;">
                    <?php
                    echo $totalFRSCO;
                    ?>
                </label>

                <div class="row block-printer" id="blockPrinter" ng-show="isVisibeCtrl" style="display:none;">
                    <!-- panel -->
                    <div class="inner-block">
                        <table style="font-weight:bold">
                            <tr class="primary">
                                <td class="label-text">
                                    Année scolaire
                                </td>
                                <td>
                                    : {{cbo_year}}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Promotion
                                </td>
                                <td>
                                    : {{cbo_promotion}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Type de frais
                                </td>
                                <td>
                                    : <span id="txt_feesTypeR"></span>
                                </td>
                            </tr>

                        </table>
                        <hr/>
                        <table class="table" style="text-align:left;width:100%;">
                            <thead>
                                <tr>
                                    <th>MATRICULE</th>
                                    <th>NOM ELEVE</th>
                                    <th>GENRE</th>
                                    <th>DATE</th>
                                    <th>HEURE</th>
                                    <th>MONTANT</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="success" ng-repeat="row in tablePayFormat">
                                    <td>{{row.mat}}</td>
                                    <td>{{row.namePupil}}</td>
                                    <td>{{row.sexPupil}}</td>
                                    <td>{{row.datePay}}</td>
                                    <td>{{row.timePay}}</td>
                                    <td>{{row.amount}}</td>
                                </tr>


                            </tbody>
                        </table>
                        <br>
                        <div style="width:100%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                            <label for="" style="width:auto;float:left;font-weight:bold;">Total à payer</label>
                            <label for="" style="float:right;width:auto;font-weight:bold">
                                {{totalGlobal}} $
                            </label>
                        </div>
                        <div style="width:100%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                            <label for="" style="width:auto;float:left;font-weight:bold;">Total payé</label>
                            <label for="" style="float:right;width:auto;font-weight:bold">
                                {{totalPayPrint}} $
                            </label>
                        </div>
                        <div style="width:100%;border-top:1px solid silver;display:inline-block;" ng-show="isVisibilityPay">
                            <label for="" style="width:auto;float:left;font-weight:bold;">Reste à payer</label>
                            <label for="" style="float:right;width:auto;font-weight:bold">
                                {{totalrestePay}} $
                            </label>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.block-printer -->
                <div ng-show="!isLoading" id="buttonsPrint" style="display:none">
                    <button ng-show="isVisibeCtrl" id="btnprint" type="button" ng-click="print()" class="btn btn-success print">
                        <i class="fa fa-print"></i> Imprimer la liste
                    </button>
                    <button type="button" ng-click="quitprint()" id="btnqprint" ng-show="isVisibeCtrl" class="btn btn-success print">
                        <i class="fa fa-print"></i> Quitter impression
                    </button>
                </div>



            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <!-- UI dialog -->
        <div style="display:none">
        <div id="alert-message" title="Alerte" class="ui-state-error">
            <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
            <span id="alert-text"></span>
            </p>
        </div>
        <div id="info-message" title="Information" class="ui-state-highlight">
            <p>
            <span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
            <span id="info-text"></span>
            </p>
        </div>
        <div id="dialog-confirm" title="Confirmation de l'opération">
            <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            <span id="confirm-text"></span>
            </p>
        </div>
        </div>
        <!-- /UI dialog -->
        <script>

        </script>
        <!-- jQuery -->
        <script src="vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="vendor/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>
        <script src="dist/js/angular.min.js"></script>
        <script src="dist/js/init.js"></script>
        <script src="dist/js/services.js"></script>
        <script src="dist/js/reportController.js"></script>
        <script src="dist/js/bootstrap-datepicker.min.js"></script>


    </body>

</html>
