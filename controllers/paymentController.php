<?php

session_start();
include_once 'db.php';

class PaymentController {

    private static $reqGetPupilPaymentsInfos = "SELECT pay._IDPAY AS id_pay, term._LABELTERM AS term, sfees._LABEL AS fee_object, pay._AMOUNT AS amount_payed, pay._DATEPAY AS date_pay
                    FROM t_payment pay
                    JOIN t_school_fees sfees ON pay._OBJECT=sfees._CODE
                    JOIN t_terms term ON term._CODETERM=pay._CODETERM
                    WHERE pay._MATR=:matr AND pay._ANASCO=:anasco AND term._ANASCO=:anasco";
    // private static $reqGetActualPupiltermmentsList = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,UPPER(pupils._NAME) AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION AS section
    //                 FROM t_students pupils
    //                 JOIN t_payment payments ON pupils._MAT=payments._MATR
    //                 JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
    //                 WHERE payments._DEPARTMENT=:department AND subscrit._ANASCO=:year";
    // private static $reqGetPupiltermmentsList = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,UPPER(pupils._NAME) AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION AS section, subscrit._ANASCO
    //                 FROM t_students pupils
    //                 JOIN t_payment payments ON pupils._MAT=payments._MATR
    //                 JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
    //                 WHERE payments._DEPARTMENT=:department AND subscrit._ANASCO=:year";

    private static $reqGetTermInfos = "SELECT term.*, sfees._LABEL AS _OBJECT_PAY
                    FROM t_terms term
                    JOIN t_school_fees sfees ON sfees._CODE = term._CODE_FEES
                    WHERE term._CODETERM =:code AND term._ANASCO=:anasco";

    // private static $getTermSumPaidByPupil = "SELECT SUM(_AMOUNT) AS sum_slice_paid FROM t_payment WHERE _CODETERM = ? AND _MATR = ?";

    public static function update($param) {
        $reqUpdate = "UPDATE t_payment SET _AMOUNT=:amount WHERE _IDPAY=:idpay";
        $reqInsert = "INSERT INTO _payments_listener(_id,_former_amount,_new_amount,_reason,_user,_payment_id,_batch)
                    VALUES(NULL,:formeramount,:newamount,:reason,:user,:idpay,:batch)";
        $reqSelect = "SELECT _batch FROM _payments_listener WHERE _payment_id=? ORDER BY _id DESC LIMIT 1";
        $db = getDB();

        try {
            $db->beginTransaction();

            $termInfos = self::getTerm($param['codeterm'], $param['anasco2']);

            $resultSelect = $db->prepare($reqSelect);
            $resultSelect->execute([$param['code_pay']]);
            $listener = $resultSelect->fetch();
            $newbatch = is_numeric($listener->_batch) ? $listener->_batch + 1 : 1;

            $resultUpdate = $db->prepare($reqUpdate);
            $resultUpdate->execute([
                'amount' => $param['new_amount'],
                'idpay' => $param['code_pay']
            ]);

            $resultInsert = $db->prepare($reqInsert);
            $resultInsert->execute([
                'formeramount' => $param['former_amount'],
                'newamount' => $param['new_amount'],
                'reason' => $param['update_reason'],
                'user' => $_SESSION['uid'],
                'idpay' => $param['code_pay'],
                'batch' => $newbatch
            ]);

            $termSumPaid = self::getTermSumPaidByPupil($param['codeterm'], $param['anasco2'], $param['pupil_matr']);

            //varaibles for the invoice data here
            $remaining_amount = $termInfos->_AMOUNT - ($termSumPaid->sum - (int) $param['former_amount'] + (int) $param['new_amount']);

            $_SESSION['namePupil'] = $param['pupil_name'];
            $_SESSION['idpay'] = $param['code_pay'];
            $_SESSION['level'] = ($param['level2'] == 1) ? $param['level2'] . "ère " . $param['section2'] : $param['level2'] . "ème " . $param['section2'];
            $_SESSION['amount'] = $param['new_amount'];
            $_SESSION['motifPay'] = $termInfos->_LABELTERM . "/" . $termInfos->_OBJECT_PAY;
            $_SESSION['remaining_amount'] = $remaining_amount;
            $_SESSION['anascoPay'] = $param['anasco2'];

            $db->commit();
            return 1;
        } catch (\Exception $e) {
            $db->rollBack();
            // return $e->getMessage();
            return $e->getMessage();
        }
    }

    public static function getPupilTermBalanceToPay($param) {

        $termSumPaid = self::getTermSumPaidByPupil($param['term'], $param['year'], $param['matr']);
        $termInfos = self::getTerm($param['term'], $param['year']);
        $balance = $termInfos->_AMOUNT - $termSumPaid->sum;
        return $balance;
    }

    private static function getTerm($term, $year) {
        $db = getDB();
        $req = "SELECT term.*, sfees._LABEL AS _OBJECT_PAY
              FROM t_terms term JOIN t_school_fees sfees ON sfees._CODE = term._CODE_FEES
              WHERE term._CODETERM =:code AND term._ANASCO=:anasco";
        $result = $db->prepare($req);
        $result->execute([
            'code' => $term,
            'anasco' => $year
        ]);
        return $result->fetch();
    }

    private static function getTermSumPaidByPupil($term, $year, $matr) {
        $db = getDB();
        $sql = "SELECT SUM(_AMOUNT) AS sum FROM t_payment WHERE _CODETERM = :codeterm AND _ANASCO = :year  AND _MATR = :matr";
        // try {

        $result = $db->prepare($sql);
        $result->execute([
            'codeterm' => $term,
            'year' => $year,
            'matr' => $matr
        ]);

        return $result->fetch();
        // } catch (\Exception $e) {
        //   return $e->getMessage();
        // }
    }

    public static function getPupilsPaymentsList($year) {
        // if($year === '') $year = $_SESSION['anasco'];

        $reqPupilsList = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,UPPER(pupils._NAME) AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION AS section, subscrit._ANASCO
              FROM t_students pupils
              JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
              WHERE subscrit._ANASCO=:year AND pupils._STATUS = 1
              ORDER BY pupils._ID DESC";
        $reqPay = "SELECT pay._IDPAY AS id_pay, term._LABELTERM AS term, sfees._LABEL AS fee_object, pay._AMOUNT AS amount_payed, pay._DATEPAY AS date_pay
              FROM t_payment pay
              JOIN t_school_fees sfees ON pay._OBJECT=sfees._CODE
              JOIN t_terms term ON term._CODETERM=pay._CODETERM
              WHERE pay._MATR=:matr AND pay._ANASCO=:anasco AND term._ANASCO=:anasco";

        $result = queryDB($reqPupilsList, ['year' => $year]);
        $pupil_infos = [];
        // $data = $result->fetchAll();
        $i = 1;
        while ($data = $result->fetch()) {
            $matricule = $data->matricule;
            $pupil_payments_infos = queryDB($reqPay, ['matr' => $matricule, 'anasco' => $year]);
            $pupil_infos[] = [
                'id' => $i++,
                'matricule' => $matricule,
                'name_pupil' => $data->name_pupil,
                'gender' => $data->gender,
                'level' => $data->level,
                'section' => $data->section,
                'payinfo' => $pupil_payments_infos->fetchAll()
            ];
        }

        return json_encode($pupil_infos);
    }

    public function getFees() {
        $db = getDB();
        $query = "SELECT * FROM t_school_fees WHERE _STATUS=:status";
        $query_execute = $db->prepare($query);
        $query_execute->execute
                (
                array
                    (
                    'status' => 'active'
                )
        );
        return $query_execute->fetchAll(PDO::FETCH_OBJ);
    }

    public static function addPayment($data) {
        $reqInsertPay = "INSERT INTO t_payment (_IDPAY,_MATR,_CODETERM,_OBJECT,_DATEPAY,_TIMEPAY,_AMOUNT,_ANASCO,_USER_AGENT,_DEPARTMENT)
                      VALUES(:idpay,:matr,:codeterm,:objectpay,:datepay,:timepay,:amount,:anasco,:user,:department)";
        try {

            $db = getDB();
            $payGenerate = "PAY-" . time();

            $db->beginTransaction();
            $termInfos = self::getTerm($data['term'], $data['anasco']);

            $resultInsert = $db->prepare($reqInsertPay);
            $resultInsert->execute([
                'idpay' => $payGenerate,
                'matr' => $data['mat_pupil'],
                'codeterm' => $data['term'],
                'objectpay' => $termInfos->_CODE_FEES,
                'datepay' => date('d/m/Y'),
                'timepay' => date('H:i:s'),
                'amount' => $data['amount'],
                'anasco' => $data['anasco'],
                'user' => $_SESSION['uid'],
                'department' => $_SESSION['direction']
            ]);

            $termSumPaid = self::getTermSumPaidByPupil($data['term'], $data['anasco'], $data['mat_pupil']);

            //varaibles for the invoice data here
            $remaining_amount = $termInfos->_AMOUNT - ($termSumPaid->sum + (int) $data['amount']);

            $_SESSION['namePupil'] = $data['name_pupil'];
            $_SESSION['idpay'] = $payGenerate;
            $_SESSION['level'] = ($data['level'] == 1) ? $data['level'] . "ère " . $data['section'] : $data['level'] . "ème " . $data['section'];
            $_SESSION['amount'] = $data['amount'];
            $_SESSION['motifPay'] = $termInfos->_LABELTERM . " - " . $termInfos->_OBJECT_PAY;
            $_SESSION['remaining_amount'] = $remaining_amount;
            $_SESSION['anascoPay'] = $data['anasco'];

            $db->commit();
            return 1;
        } catch (\Exception $e) {
            $db->rollBack();
            return $e->getMessage();
        }
    }

    public static function loadTermsList() {
        $query = "SELECT _CODETERM, _LABELTERM FROM t_terms LIMIT 0,4";
        $result = queryDB($query);

        $json = [];
        while ($data = $result->fetch()) {
            $json[$data->_CODETERM][] = $data->_LABELTERM;
        }

        // envoi du résultat au success
        echo json_encode($json);
    }

    public static function getPaymentsCustomized($param) {


        $level = $param['level'];
        $option = $param['option'];
        $year = $param['year'];
        $departement = $param['departement'];
        $frais = $param['frais'];


        $hasTerm = ($frais == "all") ? "" : "AND payment._CODETERM=:frais ";

        $Query = "SELECT pupils._MAT,pupils._NAME,pupils._SEX,payment._AMOUNT,payment._IDPAY,payment._DATEPAY,payment._TIMEPAY, payment._USER_AGENT
        FROM t_payment payment
        JOIN t_students pupils ON payment._MATR=pupils._MAT
          JOIN t_subscription subscript ON pupils._MAT=subscript._MATR_PUPIL
          WHERE subscript._ANASCO=:year AND payment._ANASCO=:year " . $hasTerm . "AND subscript._CODE_CLASS=:level AND subscript._CODE_SECTION=:option
          AND payment._DEPARTMENT=:departement ORDER BY payment._DATEPAY DESC";
        $db = getDB();
        $sql_prepare = $db->prepare($Query);
        $sql_prepare->execute(
                array(
                    "year" => $year,
                    "frais" => $frais,
                    "level" => $level,
                    "option" => $option,
                    "departement" => $departement
                )
        );
        $response = $sql_prepare->fetchAll();

        $Query = "SELECT count(DISTINCT(students._MAT)) AS COUNTER
                FROM t_students students
                JOIN t_payment payment ON students._MAT =payment._MATR
                JOIN t_subscription subscript ON students._MAT=subscript._MATR_PUPIL
                WHERE payment._ANASCO=:year AND subscript._CODE_CLASS=:level AND subscript._CODE_SECTION=:option AND payment._DEPARTMENT=:departement";

        $sql_prepare = $db->prepare($Query);
        $sql_prepare->execute(
                array(
                    "year" => $year,
                    "level" => $level,
                    "option" => $option,
                    "departement" => $departement
                )
        );
        $rowers_response = $sql_prepare->fetchAll();

        $tabPay = array();
        $tabCustomized = [];
        foreach ($response as $key => $value) {
            $tabPay[$key] = [
                "_MAT" => $value->_MAT,
                "_NAME" => $value->_NAME,
                "_SEX" => $value->_SEX,
                "_AMOUNT" => $value->_AMOUNT,
                "_IDPAY" => $value->_IDPAY,
                "_DATEPAY" => $value->_DATEPAY,
                "_TIMEPAY" => $value->_TIMEPAY,
                "_AGENT" => $value->_USER_AGENT
            ];
        }
        $tabCustomized["pupils"] = $tabPay;
        $tabCustomized["counter"] = $rowers_response;
        return json_encode($tabCustomized);
    }

}
