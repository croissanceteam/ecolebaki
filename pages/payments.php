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

        <title>Voir les paiements</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

        <!-- include the core styles -->
        <link rel="stylesheet" href="vendor/alertify/themes/alertify.core.css" />
        <!-- include a theme, can be included into the core instead of 2 separate files -->
        <link rel="stylesheet" href="vendor/alertify/themes/alertify.default.css" />
        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="dist/css/custom.css" rel="stylesheet" type="text/css">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="dist/css/bootstrap-datepicker.standalone.min.css" rel="stylesheet" type="text/css">
        <link href="dist/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">
            #loader{
                width: 100%;
                text-align: center;
                margin: 0 auto;
            }
            .required:after {
                color: #d00;
                /* content: "*"; */
                margin-left: 8px;
                top:7px;

                font-family: 'FontAwesome';
                font-weight: normal;
                font-size: 10px;
                content: "\f069";
            }
        </style>
    </head>

    <body ng-app='app' ng-controller="PaymentsCtrl">

        <div id="wrapper">

            <?php
            require_once 'partials/menu-bar.php';
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="page-header" style="width: 100%;font-size: 16px;">
                            <i class="fa fa-users"></i> Tableau des données | paiements

                            <span style='float:right;font-size: 16px;' id='lbl_year'>
                                <?php echo $_SESSION['anasco'] ?>
                            </span>
                        </label>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="loader" id="loader">
                    <img src="dist/images/loader/spinner.gif">
                </div>
                <!-- /.row -->
                <div class="row" style="display: none;" id="tableView">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Liste des élèves
                                <a style="float:right;margin:-.5em 0 0 1em" href="invoice" class="btn btn-primary hidden" id = "invoice">Dernier paiement <i class="fa fa-table"></i></a>
                                <a style="float:right;margin-top:-.5em" href="subscrit" class="btn btn-primary hidden">Liste des paiements <i class="fa fa-table"></i></a>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                <ul class="nav nav-tabs" >
                                    <li class="active"><a href="#{{activeTab.year}}" data-toggle="tab">{{activeTab.year}}</a>
                                    </li>
                                    <li ng-repeat="data in list_years"><a ng-click="get_list_pupils(data.year, $index)" href="#year{{$index}}" data-toggle="tab">{{data.year}}</a>
                                    </li>
                                </ul>
                                <hr/>
                                <!-- Tab panes -->
                                <div class="tab-content" >
                                    <div class="tab-pane fade in active" id="{{activeTab.year}}">

                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Matricule</th>
                                                    <th>Nom de l'élève</th>
                                                    <th>Genre</th>
                                                    <th>Classe</th>
                                                    <th>Section</th>
                                                </tr>
                                            </thead>
                                            <tbody style="cursor:pointer">


                                            </tbody>
                                        </table>
                                    </div>
                                    <div ng-repeat="data in list_years" class="tab-pane fade" id="year{{$index}}">

                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables{{$index}}">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Matricule</th>
                                                    <th>Nom de l'élève</th>
                                                    <th>Genre</th>
                                                    <th>Classe</th>
                                                    <th>Section</th>
                                                </tr>
                                            </thead>
                                            <tbody style="cursor:pointer">


                                            </tbody>
                                        </table>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <button style="display:none;" id="toggle-payments-modal" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#pupilPaymentsModal">
                        Launch Date after
                    </button>
                    <a href="invoice" target="_blank"><button style="display:none;" id="invoice_link">Show invoice</button></a>


                    <div class="modal fade" id="pupilPaymentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title pupil-name">{{namePupil}}</h4>
                                    <span style="display:none" id="balancePay">{{balance}}</span>
                                </div>
                                <div class="modal-body">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Enregistrer un paiement

                                        </div>
                                        <form method="post" id="add_payment_form">
                                            <div class="panel-body">
                                                <div class="row">
                                                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">

                                                        <label for="term">Type de frais</label>
                                                        <select class="form-control" ng-change="newPayPrerequis()" ng-model="termCode" id="term" name="term" required>
                                                            <option></option>
                                                            <option value="1TRIM">1er Trimestre</option>
                                                            <option value="2TRIM">2eme Trimestre</option>
                                                            <option value="3TRIM">3eme Trimestre</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
                                                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"  for="amount">Montant à payer</label>
                                                        <input type="number" class="form-control" id="amount" name="amount" min="1" required>
                                                    </div>
                                                  </div>
                                                  <!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
                                                </div>
                                                <!-- /.row -->
                                                <p style="color:red;font-style:italic" id="error_msg"></p>
                                                <input type="hidden" class="form-control" id="mat_pupil" name="mat_pupil" >
                                                <input type="hidden" class="form-control" id="name_pupil" name="name_pupil" >
                                                <input type="hidden" class="form-control" id="level" name="level" >
                                                <input type="hidden" class="form-control" id="section" name="section" >
                                                <input type="hidden" class="form-control" id="anasco" name="anasco" >
                                            </div>
                                            <!-- /.panel-body -->
                                            <div class="panel-footer">
                                                <button type="reset" class="btn btn-default" >Annuler</button>
                                                <button type="submit" ng-click="submitPayment()" class="btn btn-primary pull-right">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.panel -->

                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-paiement">
                                                <thead>
                                                    <tr>

                                                        <th>Code paie</th>
                                                        <th>Trimestre</th>
                                                        <th>Type de frais</th>
                                                        <th>Montant</th>
                                                        <th>Date de paiement</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="cursor:pointer">


                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade" id="updatePaymentsModal" tabindex="-1" role="dialog" aria-labelledby="updatePaymentsModal" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title">Modification du paiement <span class="code-pay" style="font-style:italic"></span><span class="pull-right"></span></h4>
                              </div>
                              <!-- /.modal-header -->

                              <form id="update_payment_form" method="post">
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label required">Montant</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control" name="new_amount" id="new_amount" min="1" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label required">Raison</label>
                                        <div class="col-sm-10">
                                          <input type="text" list="reasons_list" class="form-control" name="update_reason" id="update_reason" required>
                                          <datalist id="reasons_list">
                                            <option value="Erreur de saisie">Erreur de saisie</option>
                                            <option value="Billet avec déchirure">Billet avec déchirure</option>
                                          </datalist>
                                        </div>
                                    </div>
                                    <p style="color:red;font-style:italic" id="error_msg2"></p>
                                    <input type="hidden" id="codeterm" name="codeterm">
                                    <input type="hidden" id="former_amount" name="former_amount">
                                    <input type="hidden" id="code_pay" name="code_pay">
                                    <input type="hidden" id="pupil_matr" name="pupil_matr" >
                                    <input type="hidden" id="pupil_name" name="pupil_name" >
                                    <input type="hidden" id="level2" name="level2" >
                                    <input type="hidden" id="section2" name="section2" >
                                    <input type="hidden" id="anasco2" name="anasco2" >
                                </div>
                                <!-- /.modal-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                                    <button type="reset" class="btn btn-default" >Annuler</button>
                                    <button type="submit" ng-click="updatePayment()" class="btn btn-primary">Appliquer</button>
                                </div>
                                <!-- /.modal-footer -->
                              </form>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->


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

            <!-- also works in the <head> -->
            <script src="vendor/alertify/lib/alertify.min.js"></script>

            <!-- Custom Theme JavaScript -->
            <script src="dist/js/sb-admin-2.js"></script>
            <script src="dist/js/angular.min.js"></script>
            <script src="dist/js/init.js"></script>
            <script src="dist/js/paymentController.js"></script>
            <script src="dist/js/bootstrap-datepicker.min.js"></script>
            <script src="dist/js/app.js"></script>
            <script>
                                                function changedSection() {
                                                    var cboSection = document.querySelector('#cboSection');
                                                    var cboLevel = document.querySelector('#cboLevel');
                                                    if (cboSection.value == "MATERNELLE") {
                                                        for (var index = 1; index <= 3; index++) {
                                                            var option = document.createElement('option');
                                                            option.text = index;
                                                            cboLevel.add(option, index);


                                                        }
                                                    } else {
                                                        for (var index = 1; index <= 6; index++) {
                                                            var option = document.createElement('option');
                                                            option.text = index;
                                                            cboLevel.add(option, index);


                                                        }
                                                    }
                                                }
                                                var img = document.querySelector('#img');
                                                img.onmouseover = function () {
                                                    img.style.opacity = '0.30'
                                                    img.style = "z-index:0;width:200px;height:200px;cursor:pointer;"
                                                    document.querySelector('#btnImg').style.opacity = '1';
                                                    document.querySelector('#btnCam').style.opacity = '1';

                                                }
                                                var inputF = document.createElement('input');
                                                var fReader = new FileReader();
                                                inputF.type = 'file';
                                                document.querySelector('#btnImg').onclick = function () {
                                                    inputF.click();
                                                }
                                                inputF.onchange = function () {
                                                    fReader.readAsDataURL(inputF.files[0]);
                                                }
                                                fReader.onloadend = function () {
                                                    document.querySelector('#img').src = fReader.result;
                                                    document.querySelector('#picture').value = fReader.result;
                                                }
                                                $('.dp').datepicker({
                                                    format: "dd/mm/yyyy"
                                                });
            </script>

    </body>

</html>
