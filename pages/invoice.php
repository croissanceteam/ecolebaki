<?php
session_start();
ob_start();
?>
<style type="text/css">

    page{
        /* color: #424242; */
    }
    table td{
        /* border: 1px solid #CFD1D2; */
        padding:1mm;
    }
    td.value{
        font-family: Arial, Helvetica, sans-serif;
        width:450px;
    }
    td.label{
        font-weight:bold;
        width:200px;
    }

</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <div style="margin-left:10mm;margin-right:10mm;">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left;width: 33%;"><h3 style="margin-bottom:25px;">ECOLE BAKI / <?= $_SESSION['direction'] ?></h3>Nº12, Av. EZO <br>Q/YOLO-NORD<br>C/KALAMU.<br>Site web: http://www.ecolebaki.com</td>
                    <td style="text-align: center;width: 34%;"></td>
                    <td style="text-align: right; width:33%"><img src="../dist/images/logo-reverse.png" width=150 alt=""> </td>
                </tr>
                
            </table>

            <div style="width: 100%; height:2px; background-color:grey;"></div>
        </div>


    </page_header>
    <page_footer>
        <table>
            <tr>
                <td style="text-align: right;width: 50%"></td>
                <td style="text-align: right;width: 50%;"></td>
            </tr>
        </table>
    </page_footer>

    <div style="text-align: center; margin-top:100px;">
        <h2>PREUVE DE PAIEMENT</h2>
    </div>
    <div style="width: 100%; height:2px; background-color:grey;margin-bottom:50px;"></div>
    <div style="text-align: right;"><span style="font-weight:bold;">Date :</span> <?= date('d/m/Y'); ?></div>
    <table style="font-size:14px;">

        <tr>
            <td class="label">Nom du beneficiaire </td>
            <td class="value">: <?= $_SESSION['namePupil'] ?></td>
        </tr>

        <tr>
            <td class="label">Promotion </td>
            <td class="value">: <?= $_SESSION['level'] ?></td>
        </tr>
        <tr>
            <td class="label">Année scolaire </td>
            <td class="value">: <?= $_SESSION['anasco'] ?></td>
        </tr>
        <tr><td style="height:10px;"></td></tr>
        <tr>
            <td class="label">Code paie </td>
            <td class="value">: <?= $_SESSION['idpay'] ?></td>
        </tr>
        <tr>
            <td class="label">Motif de paiement </td>
            <td class="value">: <?= $_SESSION['motifPay'] ?></td>
        </tr>
        <tr>
            <td class="label">Montant payé </td>
            <td class="value">: <?= $_SESSION['amount'] ?> $</td>
        </tr>
        <tr>
            <td class="label" >Montant restant </td>
            <td class="value">: <?= $_SESSION['remaining_amount'] ?> $</td>
        </tr>
    </table>
    <div style="text-align:right;"><span style="font-weight:bold;">Signature du percepteur</span> <br/><br/>
        <?= $_SESSION['username'] ?>
    </div>

</page>
<?php
$content = ob_get_clean();
?>
