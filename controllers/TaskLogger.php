<?php
session_start();
require 'logger.php';

function getLogger(){
  if (!empty($_POST['user']) && !empty($_POST['pwd'])) {

                 if (isset($_POST['user']) && isset($_POST['pwd'])) {
                 $log=new logger();
                 $response=$log->getLogger($_POST['user'],$_POST['pwd']);


                 if($response == 'locked')
                 {
                   return 6;
                 }else if ($response) {

                     $login=$response['login'];
                     $terms=$response['terms'];
                     $users=$response['users'];
                     $pupils=$response['pupils'];
                     $agents=$response['agents'];
                     $years=$response['years'];
                     $_SESSION['uid']=$login->_USERNAME;
                     $_SESSION['username']=$login->_NAME;
                     $_SESSION['direction']=$login->_CODE_DIRECTION;
                     $_SESSION['priority']=$login->_PRIORITY;
                     $_SESSION['anasco']=$login->_ANASCO;
                    //  $_SESSION['slices']=$slices[0];
                     $_SESSION['terms']=$terms;
                     $_SESSION['counter_users']=sizeof($users);
                     $_SESSION['list_users']=$users;
                     $_SESSION['pupils']=$pupils;
                     $_SESSION['counter_pupil']=sizeof($pupils);
                     $_SESSION['counter_agents']=sizeof($agents);
                     $_SESSION['agents']=$agents;
                     $_SESSION['years_list']=$years;
                     $_SESSION['nbr_typepass_try'] = 3;
                     echo '<meta http-equiv="refresh" content=0;URL=viewdashboard>';

                 }else{
                   return 0;


                 }
                 //echo 'Depratement :'.$_SESSION['direction'];
            //  echo '<meta http-equiv="refresh" content=0;URL=viewdashboard>';
               // echo json_encode($response);


             }
            // echo "<div class=\"alert alert-danger\" style=\"position: relative;top:5em;text-align: center;\">".
                 //  "Nom utilisateur ou mot de passe incorrect</div>";


     }
     return 1;
 }
$listener= $_SERVER['REQUEST_METHOD'];
$url=$_SERVER['REQUEST_URI'];

 if ($listener=='POST') {
   $user = new Logger();
   if(isset($_POST['username']) && isset($_POST['actual-password'])){
     echo $user->changePassword($_POST);
   }
 }

 if ($listener=='GET' && isset($_SESSION['uid'])) {
    echo '<meta http-equiv="refresh" content=0;URL=viewdashboard>';
 }
