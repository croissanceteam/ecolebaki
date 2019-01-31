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

        <title>Réinscription</title>

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

        <!-- Switchery -->
        <link href="vendor/switchery/dist/switchery.min.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body ng-app='app' ng-controller="ViewPupilsCtrl">



        <?php
        require_once 'partials/menu-bar.php';
        ?>
        <div id="page-wrapper">
            <div class="row">
            <div style="display: none;" class="alert alert-success" role="alert" id="success_alert">Message</div>
            <div style="display: none;" class="alert alert-danger" role="alert" id="danger_alert"></div>
                <div class="col-lg-12">
                    <label class="page-header" style="width: 100%;font-size: 16px;">
                        <i class="fa fa-users"></i> Réinscriptions

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
                            Liste des élèves à réinscrire
                            <a style="float:right;margin:-.5em 0 0 1em" href="invoice" class="btn btn-primary hidden" id = "invoice">Dernier paiement <i class="fa fa-table"></i></a>
                            <a style="float:right;margin-top:-.5em" href="subscrit" class="btn btn-primary hidden">Liste des paiements <i class="fa fa-table"></i></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <ul class="nav nav-tabs" >
                                <li class="active"><a href="#{{college_year}}" data-toggle="tab">{{college_year}}</a>
                                </li>
                            </ul>
                            <hr/>
                            <!-- Tab panes -->
                            <div class="tab-content" >
                                <div class="tab-pane fade in active" id="{{college_year}}">

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
                                <h4 class="modal-title" id="LabelName"></h4>
                            </div>
                            <form id="reinscription_form">
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Réinscrire cet élève

                                            </div>
                                            <div class="panel-body">

                                                <div class="row">

                                                    <!-- col-lg-6 (nested) -->
                                                    <div class="col-lg-12">

                                                            <p style="color:red" id="error_msg"></p>
                                                            <input type="hidden" class="form-control" id="mat_pupil" name="mat_pupil" >
                                                            <input type="hidden" class="form-control" id="name_pupil" name="name_pupil" >
                                                            <input type="hidden" class="form-control" name="reenrol" value="yes">
                                                            <!-- <input type="hidden" class="form-control" id="level" name="level" >
                                                            <input type="hidden" class="form-control" id="section" name="section" > -->

                                                            <div class="row">
                                                              <div class="col-md-5 col-md-offset-7" style="margin-bottom:5px;">
                                                                  <div class="form-group" style="margin-bottom:2px;">
                                                                      <label>
                                                                          <input type="checkbox" id="pass_switcher" /><span id="response" style="margin-left:10px">L'élève passe</span>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                              <!-- /.col -->
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Niveau actuel</label>
                                                                        <input type="text" class="form-control" id="level" name="level" disabled>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-md-2" style="padding-top:30px;padding-left:40px;">
                                                                    <span style="">=></span>
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Niveau montant</label>
                                                                        <input type="text" class="form-control" id="new_level" name="new_level" readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label>Section actuelle</label>
                                                                        <input type="text" class="form-control" id="section" name="section" disabled>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-md-2" style="padding-top:30px;padding-left:40px;">
                                                                    <span style="">=></span>
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label>Section montante</label>
                                                                        <input type="text" class="form-control" id="new_section" name="new_section" readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->

                                                            <div class="form-group">
                                                                <label class="control-label"  for="amount">Montant à payer</label>
                                                                <input type="number" class="form-control" id="amount" name="amount" required>
                                                            </div>
                                                    </div>
                                                    <!-- /.col-lg-6 (nested) -->
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
                                  <button type="submit" id="submitPayment" class="btn btn-primary">Enregistrer</button>
                              </div>
                            </form>
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
        <script src="dist/js/reinscriptionController.js"></script>
        <script src="dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Switchery -->
        <script src="vendor/switchery/dist/switchery.min.js"></script>

        <script>
            $(document).ready(function () {
              // Switchery
                // console.log("111");
                // if ($(".js-switch")[0]) {
                //     var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                //     elems.forEach(function (html) {
                //         var switchery = new Switchery(html, {
                //             color: '#26B99A'
                //         });
                //     });
                // }

                

              // /Switchery
                $("#pass_switcher").on('change', function () {
                    var checkBox = document.querySelector("#pass_switcher");
                    var text = document.querySelector("#response");
                    var new_section = document.querySelector('#new_section');
                    var new_level = document.querySelector('#new_level');
                    var section = document.querySelector('#section');
                    var level = document.querySelector('#level');
                    var btnSubmit = document.querySelector("#submitPayment");
                    var fieldAmount = document.querySelector("#amount");

                    if (checkBox.checked === true) {
                        text.innerHTML = "L'élève passe";
                        if(level.value == '6ème' && section.value == 'PRIMAIRE'){
                            new_section.value = '';
                            new_level.value = '';

                            btnSubmit.setAttribute("disabled","disabled");
                            fieldAmount.setAttribute("disabled","disabled");
                            fieldAmount.value = "";
                        }else{
                          if(level.value == '3ème' && section.value == 'MATERNELLE'){
                              new_section.value = 'PRIMAIRE';
                              new_level.value = '1ère';
                          }else{
                              new_section.value = section.value;
                              new_level.value = (parseInt(level.value) + 1) + 'ème';
                          }

                          if(btnSubmit.hasAttribute("disabled")){
                            btnSubmit.removeAttribute("disabled");
                          }
                          if(fieldAmount.hasAttribute("disabled")){
                            fieldAmount.removeAttribute("disabled");
                          }

                        }
                    } else {
                        text.textContent = "L'élève double";
                        new_section.value = section.value;
                        new_level.value = level.value;

                        if(btnSubmit.hasAttribute("disabled")){
                          btnSubmit.removeAttribute("disabled");
                        }
                        if(fieldAmount.hasAttribute("disabled")){
                          fieldAmount.removeAttribute("disabled");
                        }
                    }
                });

            });
        </script>

    </body>

</html>
