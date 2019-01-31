<?php
    session_start();
?>
<?php
    include_once('db.php');
?>

<?php
    $db=getDB();
    if (isset($_GET['_name'])){
        $name=$_GET['_name'];
        $anasco=$_GET['_anasco'];
        $type_frais=$_GET['type_frais'];
        $Query_Search="SELECT * FROM t_students WHERE _NAME=:name";
        $sql_prepare_Search=$db->prepare($Query_Search);
        $sql_prepare_Search->execute(
                array(
                    "name"=>$name
                )
        );
        $Pupil=$sql_prepare_Search->fetchAll(PDO::FETCH_OBJ);
        $rowers=sizeof($Pupil);
       // echo $rowers;
     
        if ($rowers==1) {
             $Query="SELECT payment._IDPAY,payment._DATEPAY,payment._TIMEPAY,payment._AMOUNT,payment._USER_AGENT,payment._CODE_SLICE".
         ",pupils._PICTURE,payment._OBJECT FROM t_payment payment JOIN t_students pupils ON pupils._MAT=payment._MATR".
               " WHERE pupils._NAME=:name AND payment._ANASCO=:anasco AND payment._CODE_SLICE=:object";
            
            $sql_prepare=$db->prepare($Query);
            $sql_prepare->execute(
                array(
                    "name"=>$name,
                    "anasco"=>$anasco,
                    "object"=>$type_frais
                )
            );
            $response=$sql_prepare->fetchAll(PDO::FETCH_OBJ);
            if (sizeof($response)==0) {
                echo json_encode($Pupil);
            }else {
            echo json_encode($response);                    
            }
        } else {
            echo "not found";
        }
        
       

    }

if (isset($_GET['departement'])) {
    $level=$_GET['level'];
    $option=$_GET['option'];
    $year=$_GET['year'];
    $departement=$_GET['departement'];
    $frais=$_GET['frais'];
    
    $Query="SELECT pupils._MAT,pupils._NAME,pupils._SEX,payment._AMOUNT,payment._IDPAY,payment._DATEPAY,payment._TIMEPAY FROM t_payment payment JOIN t_students pupils ON payment._MATR=pupils._MAT".
          " JOIN t_subscription subscript ON pupils ._MAT=subscript._MATR_PUPIL".
          " WHERE payment._ANASCO=:year AND payment._OBJECT=:frais AND subscript._CODE_CLASS=:level AND subscript._CODE_SECTION=:option"
          ." AND payment._DEPARTMENT=:departement ORDER BY payment._DATEPAY DESC";
    $db=getDB();
    $sql_prepare=$db->prepare($Query);
    $sql_prepare->execute(
        array(
             "year"=>$year,
             "frais"=>$frais,
             "level"=>$level,
             "option"=>$option,
             "departement"=>$departement
        )
    );
    $response=$sql_prepare->fetchAll(PDO::FETCH_OBJ);
    $Query="SELECT count(DISTINCT(students._MAT)) AS COUNTER FROM t_students students JOIN t_payment payment ON students._MAT =payment._MATR".
          " JOIN t_subscription subscript ON students._MAT=subscript._MATR_PUPIL".
          " WHERE payment._ANASCO=:year AND subscript._CODE_CLASS=:level AND subscript._CODE_SECTION=:option AND payment._DEPARTMENT=:departement";
    
    $sql_prepare=$db->prepare($Query);
    $sql_prepare->execute(
        array(
            "year"=>$year,
            "level"=>$level,
             "option"=>$option,
             "departement"=>$departement
        )
    );
    $rowers_response=$sql_prepare->fetchAll(PDO::FETCH_OBJ);
   
    $tabPay=array();
    $tabCustomized=array();
    foreach ($response as $key => $value) {
        $tabCurrent=array(
                "_MAT"=>$value->_MAT,
                "_NAME"=>$value->_NAME,
                "_SEX"=>$value->_SEX,
                "_AMOUNT"=>$value->_AMOUNT,
                "_IDPAY"=>$value->_IDPAY,
                "_DATEPAY"=>$value->_DATEPAY,
                "_TIMEPAY"=>$value->_TIMEPAY

        );
        $tabPay[$key]=$tabCurrent;
    }
    $tabCustomized["pupils"]=$tabPay;
    $tabCustomized["counter"]=$rowers_response;
    echo json_encode($tabCustomized);
    
    
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $data=json_decode(file_get_contents("php://input"));
    

    $data=json_decode(file_get_contents("php://input"));
    $Query="SELECT * FROM t_students student WHERE student._NAME=:name";
    $db=getDB();
    $sql_prepare=$db->prepare($Query);
    $sql_prepare->execute(
        array(
            "name"=>$data->name
        )
    );
    $response=$sql_prepare->fetchAll(PDO::FETCH_OBJ);
    $Pupil=json_decode(json_encode($response));

    $matrPupil= $Pupil[0]->_MAT;
    $payGenerate="PAY-".time();
    

   if (!empty($matrPupil)) {
        $Query_Udpate="INSERT INTO t_payment VALUES(:idpay,:matr,:slice,:object,:datepay,:timepay,:amount,:anasco,:user,:departement)";
    $sql_prepare=$db->prepare($Query_Udpate);
    $sql_prepare->execute(
        array(
            "idpay"=>$payGenerate,
            "matr"=>$matrPupil,
            "slice"=>$data->slice,
            "object"=>$data->object,
            "datepay"=>__DATE__,
            "timepay"=>__TIME__,
            "amount"=>$data->amount,
            "anasco"=>$_SESSION['anasco'],
            "user"=>$_SESSION['uid'],
            "departement"=>$_SESSION['direction']

        )
    );
    $return_json=array(
            "_IDPAY"=>$payGenerate,
            "_DATEPAY"=>__DATE__,
            "_TIMEPAY"=>__TIME__,
            "_AMOUNT"=>$data->amount,
            "_OBJECT"=>$data->object,
            "_USER_AGENT"=>$_SESSION['uid']
    );
    echo json_encode($return_json);
   }
 
}
?>