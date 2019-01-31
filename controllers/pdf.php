<?php
require_once('../libs/tcpdf/tcpdf.php');
session_start();

function getInvoiceAction()
{

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ECOLE BAKI |'.$_SESSION['direction']);
    $pdf->SetTitle('ECOLE BAKI |'.$_SESSION['direction']);
    $pdf->SetSubject('Invoice');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,'PREUVE DE PAIEMENT','ECOLE BAKI |'.$_SESSION['direction']);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $html='
    <h1>
    Motif de paiement : <label>'.$_SESSION['subject'].'</label>
    </h1>
    <h4>Date paie : '.date('d/m/Y').'</h4>
    <hr>
    <div style="width:100%;">
      <p>Les information concernant le beneficiaire</p>
      <table style="width:100%" style="font-size:14px;">
      <tr>
        <td style="width:0.3em;font-weight:bold;">Code paie </td>
        <td>: '.$_SESSION['idpay'].'</td>
      </tr>
        <tr>
          <td style="width:0.3em;font-weight:bold;">Nom du beneficiaire </td>
          <td>: '.$_SESSION['namePupil'].'</td>
        </tr>
        <tr>
          <td style="width:0.3em;font-weight:bold;">Promotion </td>
          <td>: '.$_SESSION['level'].'</td>
        </tr>
        <tr>
          <td style="width:0.3em;font-weight:bold;">Année scolaire </td>
          <td>: '.$_SESSION['anasco'].'</td>
        </tr>

        <tr>
          <td style="width:0.3em;font-weight:bold;">Montant payé </td>
          <td>: 10$</td>
        </tr>
      </table>
    <br>
    <h4 style="text-align:right;">Signature du percepteur<br/>
        '.$_SESSION['username'].'
    </h4>
    <hr>
    </div>   ';
    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('helvetica', '', 9);

    // add a page
    $pdf->AddPage();

    // create some HTML content


    // output the HTML content
    $pdf->writeHTML($html, true, 0, true, 0);

    // reset pointer to the last page
    $pdf->lastPage();

    // ---------------------------------------------------------

    //Close and output PDF document
    $namefileOutPut='invoice- '.$_SESSION['idpay'].date('d/m/yyyy').' '.date('h:m:s').'.pdf';
    $pdf->Output($namefileOutPut, 'D');

  //getPrinter('Sub');
}
getInvoiceAction();
 ?>
