<?php

session_start();
include_once 'PaymentController.php';
include_once 'RepportController.php';

if (isset($_SESSION['uid'])) {
    $repport = new RepportController();
    $current_page = $_SERVER['REQUEST_URI'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(strpos($current_page,'addpayment')){
          echo PaymentController::addPayment($_POST);
        }else if(strpos($current_page,'updatepayment')){
          echo PaymentController::update($_POST);
        }


    } else {
        // echo 'oo';
        if (isset($_GET['year']) && strpos($current_page,'listpayments')) {
            // echo $_GET['year'];
            echo PaymentController::getPupilsPaymentsList($_GET['year']);
        } elseif (isset($_GET['term']) && isset($_GET['matr']) && isset($_GET['year'])) {
            echo PaymentController::getPupilTermBalanceToPay($_GET);
        }
        else{

            if (isset($_GET['getterms'])) {
                PaymentController::loadTermsList();
            } else if (isset($_GET['invoice'])) {
                $repport->generateInvoice();
            } else if (isset($_GET['departement'])) {
                echo PaymentController::getPaymentsCustomized($_GET);
            } else if (strpos($current_page,'listpayments')) {
                echo PaymentController::getPupilsPaymentsList($_SESSION['anasco']);
            }
        }

    }
} else {
    echo '<meta http-equiv="refresh" content=0;URL=login>';
}
