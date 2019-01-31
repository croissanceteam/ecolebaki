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

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

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
</style>
</head>

<body ng-app='app' ng-controller="ViewPupilsCtrl">

    <div id="wrapper">

    <?php
         require_once 'partials/menu-bar.php';
       ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div style="display: none;" class="alert alert-success" role="alert" id="success_alert"></div>
                <div style="display: none;" class="alert alert-danger" role="alert" id="danger_alert"></div>
                    <label class="page-header" style="width: 100%;font-size: 16px;">
                        <i class="fa fa-users"></i> Tableau des données | paiements

                        <span style='float:right;font-size: 16px;' id='lbl_year'>
                            <?php echo $_SESSION['anasco']?>
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
                        <li ng-repeat="data in list_years"><a ng-click="get_list_pupils(data.year,$index)" href="#year{{$index}}" data-toggle="tab">{{data.year}}</a>
                        </li>
                        </ul>
                            <hr/>
                            <!-- Tab panes -->
                            <div class="tab-content" >
                                <div class="tab-pane fade in active" id="{{activeTab.year}}">

                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
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
            <button style="display:none;" id="btn_date_after" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                Launch Date after
                            </button>
            <a href="invoice" target="_blank"><button style="display:none;" id="invoice_link">Show invoice</button></a>


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="LabelName">{{namePupil}}</h4>
                                        </div>
                                        <div class="modal-body">
                                        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enregistrer un paiement

                        </div>
                        <div class="panel-body">

                            <div class="row">

                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6" style="width:100%">
                                    <form method="post" id="add_payment_form">
                                        <p style="color:red" id="error_msg"></p>
                                        <input type="hidden" class="form-control" id="mat_pupil" name="mat_pupil" >
                                        <input type="hidden" class="form-control" id="name_pupil" name="name_pupil" >
                                        <input type="hidden" class="form-control" id="level" name="level" >
                                        <input type="hidden" class="form-control" id="section" name="section" >
                                            
                                        <div class="form-group">
                                            
                                            <label for="slice">Type de frais</label>
                                            <select class="form-control" id="slice" name="slice" >
                                                <option value="">-----</option>

                                            </select>

                                            <div class="form-group">
                                                <label class="control-label"  for="amount">Montant à payer</label>
                                                <input type="number" class="form-control" id="amount" name="amount">
                                            </div>



                                        </div>
                                        <!-- /.col-lg-6 (nested) -->


                                    </form>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-paiement">
                                        <thead>
                                            <tr>

                                                <th>Id ticket</th>
                                                <th>Tranche</th>
                                                <th>Type de Frais</th>
                                                <th>Montant</th>
                                                <th>Date de paiement</th>
                                            </tr>
                                        </thead>
                                        <tbody style="cursor:pointer">


                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                            <button type="button" id="submitPayment" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
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

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script src="dist/js/angular.min.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="dist/js/paymentController.js"></script>
    <script src="dist/js/bootstrap-datepicker.min.js"></script>
    <script>
    function changedSection(){
        var cboSection=document.querySelector('#cboSection');
        var cboLevel=document.querySelector('#cboLevel');
        if (cboSection.value=="MATERNELLE") {
            for (var index =1 ;index <=3; index++) {
                    var option=document.createElement('option');
                    option.text=index;
                    cboLevel.add(option,index);


            }
        }else{
            for (var index =1 ;index <=6; index++) {
                    var option=document.createElement('option');
                    option.text=index;
                    cboLevel.add(option,index);


            }
        }
    }
        var img=document.querySelector('#img');
        img.onmouseover=function(){
            img.style.opacity='0.30'
            img.style="z-index:0;width:200px;height:200px;cursor:pointer;"
            document.querySelector('#btnImg').style.opacity='1';
            document.querySelector('#btnCam').style.opacity='1';

    }
    var inputF=document.createElement('input');
    var fReader=new FileReader();
    inputF.type='file';
    document.querySelector('#btnImg').onclick=function(){
        inputF.click();
    }
    inputF.onchange=function(){
        fReader.readAsDataURL(inputF.files[0]);
    }
    fReader.onloadend=function(){
        document.querySelector('#img').src=fReader.result;
        document.querySelector('#picture').value=fReader.result;
    }
    $('.dp').datepicker({
           format:"dd/mm/yyyy"
    });
    </script>

</body>

</html>
