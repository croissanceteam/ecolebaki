<?php
session_start();
//require_once './html2pdf/html2pdf.class.php';


class RepportController{
    public function generateInvoice(){
        require_once('../html2pdf/vendor/autoload.php');
        require_once('../pages/invoice.php');
        try {
            $html2pdf = new \HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 3);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $pdfname = "RP-".date('Ymd')."-".$_SESSION['idpay'].".pdf";
            $html2pdf->Output($pdfname,'D');
        } catch (HTML2PDF_exception $e) {
            echo "Error HTML2PDF <br>";
            echo $e;
            exit;
        } catch (Exception $e){
            echo "Error <br>";
            echo $e;
        }
    }
}

