<?php

session_start();
include_once 'PaymentController.php';
include_once 'RepportController.php';

if (isset($_SESSION['uid'])) {
    $repport = new RepportController();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        PaymentController::addPayment($_POST);
        
    } else {
        if (isset($_GET['depart']) && isset($_GET['year'])) {
            echo PaymentController::getPupilsPaymentsList($_GET['depart'],$_GET['year']);
        }else{
            $current_page=$_SERVER['REQUEST_URI'];
            if (isset($_GET['getslices'])) {
                PaymentController::loadSlicesList();
            } else if (isset($_GET['invoice'])) {
                $repport->generateInvoice();
            } else if (isset($_GET['departement'])) {
                echo PaymentController::getPaymentsCustomized($_GET);
            } else if (strpos($current_page,'listpayments')) {
                echo PaymentController::getActualPupilsPaymentsList();
            }
        }
        
    }
} else {
    echo '<meta http-equiv="refresh" content=0;URL=login>';
}
