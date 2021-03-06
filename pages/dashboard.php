<?php
session_start();
?>
<?php
if (!isset($_SESSION['uid'])) {
    header('Location:login');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tableau de bord Baki</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php
            require_once 'partials/menu-bar.php';
            ?>

            <div id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Tableau de bord</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="loader" id="loader">
                    <img src="dist/images/loader/spinner.gif">
                </div>
                <div class="row body1" style="display:none">
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $_SESSION['counter_users'] ?></div>
                                        <div>Utilisateurs</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Voir détails</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="display: none;">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $_SESSION['counter_agents'] ?></div>
                                        <div>Agents</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Voir détails</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-graduation-cap fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $_SESSION['counter_pupil'] ?></div>
                                        <div>Elèves</div>
                                    </div>
                                </div>
                            </div>
                            <a href="viewpupils">
                                <div class="panel-footer">
                                    <span class="pull-left">Voir détails</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" style="display: none;">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row body2" style="display:none">
                    <div class="col-lg-12" style="width: 100%;">
                        <div class="panel panel-default" style="width: 100%" id="bar-chart">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Histogramme des statistiques d'élèves par promotion
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Affichage
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#" id="show-area-chart">Zones</a>
                                            </li>
                                            <li><a href="#" id="show-line-chart">Courbes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                        <div class="panel panel-default" style="width: 100%" id="area-chart">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Zones représentant les statistiques d'élèves par promotion
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Affichage
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#" id="show-line-chart">Courbes</a>
                                            </li>
                                            <li><a href="#" id="show-bar-chart">Histogrammes</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->


                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12" style="width: 100%;">
                        <div class="panel panel-default" style="width: 100%" id="line-chart">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Courbes représentant les statistiques d'élèves par promotion
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Affichage
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#" id="show-bar-chart">Histogrammes</a>
                                            </li>
                                            <li><a href="#" id="show-area-chart">Zones</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-line-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-12" style="width: 100%;">

                        <div class="panel panel-default hidden">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                                <a href="#" class="btn btn-default btn-block">View Details</a>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>
                    <!-- /.col-lg-12 -->

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

        <!-- Morris Charts JavaScript -->
        <script src="vendor/raphael/raphael.min.js"></script>
        <script src="vendor/morrisjs/morris.min.js"></script>
        <script src="data/morris-data.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>

        <script src="dist/js/app.js"></script>
        <script>
            $(document).ready(function () {
                var lineChart = document.querySelector('#line-chart');
                var barChart = document.querySelector('#bar-chart');
                var areaChart = document.querySelector('#area-chart');

                setTimeout(function () {
                  //these charts MUST be hidden after that Morris has set charts data
                    lineChart.style.display = 'none';
                    areaChart.style.display = 'none';
                    console.log('Charts hidden');
                    document.querySelector('#loader').style.display = 'none';
                }, 1000);
                //these blocks MUST be displayed before that Morris set charts data
                document.querySelector('.body1').style.display = 'block';
                document.querySelector('.body2').style.display = 'block';
                console.log('Blocks displayed');


                $('a#show-line-chart').click(function () {
                    lineChart.style.display = 'block';
                    barChart.style.display = 'none';
                    areaChart.style.display = 'none';
                    return false;
                });

                $('a#show-bar-chart').click(function () {
                    barChart.style.display = 'block';
                    lineChart.style.display = 'none';
                    areaChart.style.display = 'none';
                    return false;
                });

                $('a#show-area-chart').click(function () {
                    areaChart.style.display = 'block';
                    lineChart.style.display = 'none';
                    barChart.style.display = 'none';
                    return false;
                });
            });
        </script>

    </body>

</html>
