<?php
session_start();
!isset($_SESSION['uid']) ? header('Location:login') : header('Location:viewdashboard') ;  

