<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inscription</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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

</head>

<body>
<?php
     require_once 'partials/menu-bar.php';
?>
<div id="page-wrapper">

    <button class="btn btn-primary btn-lg" data-toggle="modal" style="display: none;" id="btnCamModal" data-target="#myModal">
                                Launch Demo Modal
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: auto;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                        </div>
                                        <div class="modal-body" style="text-align: center;margin: 0 auto;">
                                            <div style="width: 250px;height: 250px;background-color: silver; ">
                                                <video id="videoCam" style="width: 240px;height: 240px;"></video>

                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" id="btnCapture" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Nouvel élève <i class="fa fa-user fa-fw" style="float:right"></i></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Remplissez le formulaire
                            <a style="float:right;margin-top:-.5em" href="viewpupils" class="btn btn-primary">Liste des eleves <i class="fa fa-list"></i></a>

                        </div>
                        <div class="panel-body">
                        <div style="padding-bottom:2em;display:inline-block;width:200px;">
                        <img id="img" src="dist/images/Avatar02-256.png" style="z-index:9999;width:200px;height:200px;cursor:pointer;">
                        <div style="padding-left:3.3
                        em;text-align: center;" id="blockImg">
                        <button style="" id="btnImg" type="button" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-image"></i>
                        </button>
                        <button id="btnCam" type="button" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-camera"></i>
                        </button>
                        </div>
                        </div>
                            <div class="row">

                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess">Nom complet</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Genre</label>
                                            <select class="form-control" name="sex" required>
                                                <option></option>
                                                <option value="M">Masculin</option>
                                                <option value="F">Feminin</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Province d'origine</label>
                                            <select class="form-control" name="town" required>
                                                <option></option>
                                                <option>Bas-Uele</option>
                                                <option>Équateur</option>
                                                <option>Haut-Katanga</option>
                                                <option>Haut-Lomami</option>
                                                <option>Haut-Uele</option>
                                                <option>Ituri</option>
                                                <option>Kasaï</option>
                                                <option>Kasaï-Central</option>
                                                <option>Kasaï-Oriental</option>
                                                <option>Kinshasa</option>
                                                <option>Kongo-Central</option>
                                                <option>Kwango</option>
                                                <option>Kwilu</option>
                                                <option>Lomami</option>
                                                <option>Lualaba</option>
                                                <option>Maindombe</option>
                                                <option>Maniema</option>
                                                <option>Mongala</option>
                                                <option>Nord-Kivu</option>
                                                <option>Nord-Ubangi</option>
                                                <option>Sankuru</option>
                                                <option>Sud-Kivu</option>
                                                <option>Sud-Ubangi</option>
                                                <option>Tanganyika</option>
                                                <option>Tshopo</option>
                                                <option>Tshuapa</option>


                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess">Adresse</label>
                                            <input type="text" name="address" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"  for="inputSuccess">Téléphone</label>
                                            <input type="text" name="phone" class="form-control" required>
                                        </div>



                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6" style="float:right;">

                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess">Lieu de naissance</label>
                                            <input type="text" name="born_town" class="form-control" required>
                                        </div>

                                             <label>Date de naissance</label>
                                        <div class="input-group date dp" style="" data-provider="datepicker">

                                                <input id="date1Export" style="" placeholder="" type="text" name="birthday" class="form-control" required/>
                                                <div class="input-group-addon">
                                                    <span class="fa fa-th"></span>
                                                </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select name="section" class="form-control" onchange="changedSection()" id="cboSection" name="section" required>
                                                <option></option>
                                                <option>MATERNELLE</option>
                                                <option>PRIMAIRE</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                        <label for="">Niveau</label>
                                        <select name="level" class="form-control" id="cboLevel" name="level" required>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"  for="inputSuccess">Montant</label>
                                            <input type="number" name="amount" class="form-control" min="1" required>
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="control-label" for="inputSuccess">Base64</label>
                                            <input name="picture" id="picture" type="text" class="form-control" required>
                                        </div>
                                        <button id="btnAdd" type="submit" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-plus"></i>
                                        </button>

                                    </form>

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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <?php
        require_once '../controllers/TaskPupils.php';
    ?>

<script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script src="dist/js/bootstrap-datepicker.min.js"></script>
    <script src="dist/js/camera.js"></script>
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
   /* img.onmouseout=function(){
        document.querySelector('#btnImg').style.opacity='0';
        document.querySelector('#btnCam').style.opacity='0';
    }
    */
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
