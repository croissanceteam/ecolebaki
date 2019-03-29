<?php
session_start();

if (isset($_SESSION['uid'])) {
  include_once 'subscritController.php';
  include_once 'PupilController.php';
  $sub=new subscritController();
  $current_page=$_SERVER['REQUEST_URI'];
  if ($_SERVER['REQUEST_METHOD']=='POST')
  {
    if(strpos($current_page,'updatepupil'))
    {
      echo PupilController::update($_POST);
    }else if(isset($_POST['sex'])){
      try {
          echo $sub->Add(
            $_POST['name'],
            $_POST['sex'],
            $_POST['phone'],
            $_POST['town'],
            $_POST['address'],
            $_POST['born_town'],
            $_POST['birthday'],
            $_POST['section'],
            $_POST['level'],
            $_POST['amount'],
            $_POST['picture'],
            $_POST['supported_student']
          );

      } catch (\Exception $e) {
          echo 'Erreur';
      } finally
      {
        // echo '<meta http-equiv="refresh" content=0;URL=subscrit>';
      }


    }else if($_POST['reenrol']){
        echo PupilController::reEnrolPupil($_POST);
    }

  }else {
      if (isset($_GET['depart']) && isset($_GET['year'])) {
        PupilController::getPupils($_GET['depart'],$_GET['year']);
      } else if(isset($_GET['mat']))
        echo PupilController::getPupilInfos($_GET['mat']);
      else {
        $current_page=$_SERVER['REQUEST_URI'];
        if(strpos($current_page,'getdashboarddata')){
          echo PupilController::countPupilsByPromo();
        }else{
          if (strpos($current_page,'listpupils')) {
            PupilController::getPupils($_SESSION['direction'],$_SESSION['anasco']);
          }
          if (strpos($current_page,'listyears')) {
            echo json_encode($sub->get_list_years());
          }
          if (strpos($current_page,'pupilstoreenrol')) {
            echo PupilController::getPupilsToReEnrol();
          }
        }

      }
  }

}else {
  echo '<meta http-equiv="refresh" content=0;URL=login>';
}
