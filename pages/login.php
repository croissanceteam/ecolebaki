<?php
 session_start();
  include_once '../controllers/TaskLogger.php';
?>
<?php
 if(!isset($_SESSION['uid'])){
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login page</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
            #iu{
                float:right;

            }
    </style>
</head>

<body ng-app="app" ng-controller="ctrLog">

    <div class="container">
        <div class="row">


            <div class="col-md-4 col-md-offset-4">
                 <?php
             if ($_SERVER['REQUEST_METHOD']=='POST') {
                $response_logger= getLogger();
              switch ($response_logger) {
                  case 0:
                            echo "<div class=\"alert alert-danger\" style=\"position: relative;top:5em;text-align: center;\"> Nom utilisateur ou mot de passe incorrect</div>";
                      break;

                  default:


                      break;
              }
            }
            ?>
                <div style="text-align:center;">
                    <img src="dist/images/logo-reverse.png" style="width:70%;position:relative;bottom:0" alt="logo">
                </div>
                <div class="login-panel panel panel-default" style="margin-top:10px;">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Connectez-vous
                            <i id="iu" class="fa fa-user"></i>

                        </h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" name="frm" ng-submit="send()" id="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="username" name="user" type="text" autofocus required ng-model="user.name">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="pwd" type="password" value="" required ng-model="user.password">
                                </div>
                                <div class="checkbox" style="display:none">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button ng-disabled="frm.$invalid" type="submit" class="btn btn-lg btn-success btn-block" >Se connecter</button>
                               <button style="display:none;" ng-click="ona()">ONA.IO</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script type="text/javascript" src="dist/js/angular.min.js"></script>
    <script type="text/javascript" src="dist/js/loginController.js"></script>

</body>

</html>

<?php
 }else{

 }

?>
