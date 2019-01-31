<?php
session_start();

if (isset($_SESSION['uid'])) {
  include_once 'subscritController.php';
  include_once 'PupilController.php';
  $sub=new subscritController();
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    if(isset($_POST['sex'])){
      $sub->Add(
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
        $_POST['picture']
      );
    }else if($_POST['reenrol']){
        echo PupilController::reEnrolPupil($_POST);
    }
      
  }else {
      if (isset($_GET['depart']) && isset($_GET['year'])) {
        $sub->get_list_pupils($_GET['depart'],$_GET['year']);
      }else{
        $current_page=$_SERVER['REQUEST_URI'];
        if(strpos($current_page,'getdashboarddata')){
          echo PupilController::countPupilsByPromo();
        }else{
          if (strpos($current_page,'listpupils')) {
            $sub->get_list_pupils_actuals();
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
