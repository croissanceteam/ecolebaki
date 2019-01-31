<?php
session_start();
require 'logger.php';

function getLogger(){
if (!empty($_POST['user']) && !empty($_POST['pwd'])) {

                 if (isset($_POST['user']) && isset($_POST['pwd'])) {
                 $log=new logger();
                 $response=$log->getLogger($_POST['user'],$_POST['pwd']);
                 if (count($response)>0) {

                     $login=$response['login'];
                     $slices=$response['slices'];
                     $users=$response['users'];
                     $pupils=$response['pupils'];
                     $agents=$response['agents'];
                     $years=$response['years'];
                     $_SESSION['uid']=$login[0]->_USERNAME;
                     $_SESSION['username']=$login[0]->_NAME;
                     $_SESSION['direction']=$login[0]->_CODE_DIRECTION;
                     $_SESSION['priority']=$login[0]->_PRIORITY;
                     $_SESSION['anasco']=$login[0]->_ANASCO;
                    //  $_SESSION['slices']=$slices[0];
                     $_SESSION['slices']=$slices;
                     $_SESSION['counter_users']=sizeof($users);
                     $_SESSION['list_users']=$users;
                     $_SESSION['pupils']=$pupils;
                     $_SESSION['counter_pupil']=sizeof($pupils);
                     $_SESSION['counter_agents']=sizeof($agents);
                     $_SESSION['agents']=$agents;
                     $_SESSION['years_list']=$years;
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

 }

 if ($listener=='GET' && isset($_SESSION['uid'])) {
        echo '<meta http-equiv="refresh" content=0;URL=viewdashboard>';
     }
