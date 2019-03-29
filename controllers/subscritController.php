<?php

session_start();
include_once 'db.php';
include_once 'LoadPicture.php';

class SubscritController {

    public function __construct() {
        
    }

    public function ViewProperties() {
        echo json_encode($this);
    }

    public function Add($name, $sex, $phone, $town, $address, $born_town, $birthday, $section, $level, $amount, $picture, $supported) {

        try {
            $matrGenerate = $_SESSION['direction'] . time();

            if (strlen($picture) > 0) {
                $fileImage = convertBase64ToImage($picture, $matrGenerate . ".png");
            } else {
                $fileImage = 'avatar.png';
            }
            $db = getDB();
            $db->beginTransaction();
            $req1 = "INSERT INTO t_students (_MAT,_NAME,_SEX,_ADRESS,_PROVINCE,_BIRTHDAY,_BIRTHPLACE,_PHONE,_PICTURE,_SUPPORTED)
            VALUES(:matr,:nom,:sex,:address,:province,:birthday,:birthplace,:phone,:picture,:supported)";

            $query_execute = $db->prepare($req1);
            $query_execute->execute([
                'matr' => $matrGenerate,
                'nom' => $name,
                'sex' => $sex,
                'address' => $address,
                'province' => $town,
                'birthday' => $birthday,
                'birthplace' => $born_town,
                'phone' => $phone,
                'picture' => $fileImage,
                'supported' => ($supported == 'on') ? 1 : 0
            ]);

            $payGenerate = "PAY-" . time();

            $req2 = "INSERT INTO t_payment (_IDPAY,_MATR,_CODETERM,_OBJECT,_DATEPAY,_TIMEPAY,_AMOUNT,_ANASCO,_USER_AGENT,_DEPARTMENT)" .
                    " VALUES (:idpay,:matr,:codeTerm,:object,:datepay,:timepay,:amount,:anasco,:userAgent,:department)";

            $query_execute = $db->prepare($req2);
            $query_execute->execute([
                "idpay" => $payGenerate,
                "matr" => $matrGenerate,
                "codeTerm" => "1TRIM",
                "object" => "FRSCO",
                "datepay" => date('d/m/Y'),
                "timepay" => date('H:i:s'),
                "amount" => $amount,
                "anasco" => $_SESSION['anasco'],
                "userAgent" => $_SESSION['uid'],
                "department" => $_SESSION['direction']
            ]);

            $Query = "INSERT INTO t_subscription (_MATR_PUPIL,_CODE_CLASS,_CODE_SECTION,_DATE_SUB,_CODE_AGENT,_ANASCO,_DEPARTMENT)
             VALUES (:matr,:codeClass,:codeSection,:dateSub,:codeAgent,:anasco,:department)";

            $query_execute = $db->prepare($Query);
            $result = $query_execute->execute([
                "matr" => $matrGenerate,
                "codeClass" => $level,
                "codeSection" => $section,
                "dateSub" => date('d/m/Y'),
                "codeAgent" => $_SESSION['uid'],
                "anasco" => $_SESSION['anasco'],
                "department" => $_SESSION['direction']
            ]);

            // if ($result == 1) {
            //   $_SESSION['success'] = 'L\'inscription a réussi';
            // }else{
            //   $_SESSION['error'] = 'L\'inscription a échoué';
            // }

            $_SESSION['anascoPay'] = $_SESSION['anasco'];
            $_SESSION['idpay'] = $payGenerate;
            $_SESSION['namePupil'] = $name;
            $_SESSION['amount'] = $amount;
            if ($level == 1) {
                $_SESSION["level"] = $level . "ère " . $section;
            } else {
                $_SESSION["level"] = $level . "ème " . $section;
            }
            $result = queryDB("SELECT _AMOUNT FROM t_terms WHERE _CODETERM = '1TRIM' AND _ANASCO = ?", [$_SESSION['anasco']]);
            $termAmount = $result->fetch();
            $total1TRIM = $termAmount->_AMOUNT;
            // $_SESSION['subject']="Inscription";
            $_SESSION['motifPay'] = $total1TRIM == $amount ? "1er Trimestre - FRAIS SCOLAIRE" : "ACOMPTE - 1er Trimestre - FRAIS SCOLAIRE";
            //$this->getPDFInvoiceLayout();

            $remaining_amount = $total1TRIM - $amount;
            $_SESSION['remaining_amount'] = $remaining_amount;

            $db->commit();
            return 1;
            // echo '<meta http-equiv="refresh" content=0;URL=invoice>';
        } catch (\Exception $e) {
            $db->rollBack();
            return $e->getMessage();
            //echo $e->getMessage();
            // throw new \Exception($e->getMessage(), 1);
        }
    }

    public function get_list_pupils($direction, $year) {
        $db = getDB();
        $query_sql = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,pupils._NAME AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,
        subscrit._CODE_SECTION AS section,pupils._PICTURE AS picture,pupils._PHONE AS phone, pupils._ADRESS AS adress, pupils._BIRTHDAY AS datenaiss,pupils._BIRTHPLACE as townBorn,pupils._PROVINCE AS townFrom
                    FROM t_students pupils JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
                    WHERE subscrit._DEPARTMENT=:department AND subscrit._ANASCO=:year
                    ORDER BY subscrit._MATR_PUPIL DESC";
        $query_execute = $db->prepare($query_sql);
        $query_execute->execute
                (
                array
                    (
                    'department' => $direction,
                    'year' => $year
                //'object'=>$object,
                //'resub'=>'RESUB'
                )
        );
        $tabs = $query_execute->fetchAll();
        $response = json_encode($tabs);
        echo $response;
    }

    public function get_list_pupils_actuals() {


        $db = getDB();
        $query_sql = "SELECT DISTINCT(pupils._ID) as id, pupils._MAT as matricule,pupils._NAME AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION as section
                    FROM t_students pupils JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
                    WHERE subscrit._DEPARTMENT=:department AND subscrit._ANASCO=:year
                    ORDER BY pupils._ID DESC";
        $query_execute = $db->prepare($query_sql);
        $query_execute->execute
                (
                array
                    (
                    'department' => $_SESSION['direction'],
                    'year' => $_SESSION['anasco']
                )
        );
        $tabs = $query_execute->fetchAll();
        $response = json_encode($tabs);
        $_SESSION['list_current_pupils'] = $response;
        $_SESSION['counter_pupil'] = sizeof(json_decode($response));
        echo $response;
    }

    public function get_list_years() {
        $db = getDB();
        $query = "SELECT * FROM t_years_school ORDER BY year DESC LIMIT 0,3";
        $query_execute = $db->prepare($query);
        $query_execute->execute();
        $response = $query_execute->fetchAll();
        return $response;
    }

}
