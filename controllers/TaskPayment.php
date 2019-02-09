<?php

session_start();
include_once 'PaymentController.php';
include_once 'RepportController.php';

if (isset($_SESSION['uid'])) {
    $repport = new RepportController();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        PaymentController::addPayment($_POST);

    } else {
        $current_page = $_SERVER['REQUEST_URI'];
        if (isset($_GET['year']) && $current_page == 'listpayments') {
            echo PaymentController::getPupilsPaymentsList($_GET['year']);
        } elseif (isset($_GET['slice']) && isset($_GET['matr']) && isset($_GET['year'])) {
            echo PaymentController::getPupilSliceBalanceToPay($_GET);
        }
        else{

            if (isset($_GET['getslices'])) {
                PaymentController::loadSlicesList();
            } else if (isset($_GET['invoice'])) {
                $repport->generateInvoice();
            } else if (isset($_GET['departement'])) {
                echo PaymentController::getPaymentsCustomized($_GET);
            } else if (strpos($current_page,'listpayments')) {
                echo PaymentController::getPupilsPaymentsList();
            }
        }

    }
} else {
    echo '<meta http-equiv="refresh" content=0;URL=login>';
}
