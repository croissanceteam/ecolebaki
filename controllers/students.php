<?php
    session_start();
?>
<?php
        include_once 'db.php';
        include_once '__picture__.php';
?>
<?php
        if($_SERVER['REQUEST_METHOD']=="POST") {
           try{
                $data=json_decode(file_get_contents("php://input"));
                $matrGenerate=$data->matr.time();
                $fileImage=time().".png";
            $db=getDB();
            $db->beginTransaction();
            $Query="INSERT INTO t_students (_MAT,_NAME,_SEX,_ADRESS,_PROVINCE,_BIRTHDAY,_BIRTHPLACE,_PHONE,_PICTURE)".
            " VALUES(:matr,:nom,:sex,:address,:province,:birthday,:birthplace,:phone,:picture)";

            $SQL_PREPARE=$db->prepare($Query);
            $SQL_PREPARE->execute(array(
                'matr'=>$matrGenerate,
                'nom'=>$data->nom,
                'sex'=>$data->sex,
                'address'=>$data->address,
                'province'=>$data->province,
                'birthday'=>$data->birthday,
                'birthplace'=>$data->birthplace,
                'phone'=>$data->tel,
                'picture'=>$fileImage
            ));
            convertBase64ToImage($data->picture,$fileImage);
            $db->commit();
            $payGenerate="PAY-".time();

            $Query="INSERT INTO t_payment (_IDPAY,_MATR,_CODE_SLICE,_OBJECT,_DATEPAY,_TIMEPAY,_AMOUNT,_ANASCO,_USER_AGENT,_DEPARTMENT)".
                   " VALUES (:idpay,:matr,:codeSlice,:object,:datepay,:timepay,:amount,:anasco,:userAgent,:department)";
                   $db->beginTransaction();
                   $SQL_PREPARE=$db->prepare($Query);
                   $SQL_PREPARE->execute(array(
                       "idpay"=>$payGenerate,
                       "matr"=>$matrGenerate,
                       "codeSlice"=>"SUB",
                       "object"=>"SUB",
                       "datepay"=>__DATE__,
                       "timepay"=>__TIME__,
                       "amount"=>"10",
                       "anasco"=>$_SESSION['anasco'],
                       "userAgent"=>$_SESSION['uid'],
                       "department"=>$_SESSION['direction']
                   ));
                   $db->commit();

                
                $Query="INSERT INTO t_subscription (_MATR_PUPIL,_CODE_CLASS,_CODE_SECTION,_DATE_SUB,_CODE_PAY,_CODE_AGENT) ".
                " VALUES (:matr,:codeClass,:codeSection,:dateSub,:codePay,:codeAgent)";
                $db->beginTransaction();
                $SQL_PREPARE=$db->prepare($Query);
                $SQL_PREPARE->execute(array(
                    "matr"=>$matrGenerate,
                    "codeClass"=>$data->niveau,
                    "codeSection"=>$data->section,
                    "dateSub"=>__DATE__,
                    "codePay"=>$payGenerate,
                    "codeAgent"=>$_SESSION['uid']

                ));
                $db->commit();
                $_SESSION['idpay']=$payGenerate;
                $_SESSION['namePupil']=$data->nom;
                if($data->niveau==1){
                    $_SESSION["level"]=$data->niveau."ere ".$data->section;
                }else{
                    $_SESSION["level"]=$data->niveau."eme ".$data->section;
                }
            echo "Saved";
           }catch(Exception $e){
               echo $e->getMessage();
           }
}


                if(isset($_GET['_name'])){
                    $db=getDB();
                    $Query="SELECT _MAT FROM t_students WHERE _NAME=:name";
                    $SQL_PREPARE= $db->prepare($Query);
                    $SQL_PREPARE->execute(array(
                        "name"=>$_GET['_name']
                    ));
                    $prepare_1=$SQL_PREPARE->fetchAll(PDO::FETCH_OBJ);
                    
                   if (sizeof($prepare_1)>1) {
                       echo "Superior to 1";
                       $response=array();
                        for ($i=0; $i < sizeof($prepare_1); $i++) { 
                         $matricule=$prepare_1[$i]->_MAT;
                       $Query="SELECT student._MAT, student._NAME,student._PHONE,subscrit._CODE_CLASS,subscrit._CODE_SECTION,pay._CODE_SLICE,pay._ANASCO,student._PICTURE"
                       ." FROM t_students student JOIN t_subscription subscrit ON student._MAT=subscrit._MATR_PUPIL JOIN t_payment pay ON pay._IDPAY=subscrit._CODE_PAY".
                              " WHERE subscrit._MATR_PUPIL=:matr AND pay._DEPARTMENT=:depart";
                       
                       $SQL_PREPARE=$db->prepare($Query);
                       $SQL_PREPARE->execute(array(
                           "matr"=>$matricule,
                           "depart"=>$_SESSION['direction']
                       ));
                       $prepare_2=$SQL_PREPARE->fetchAll(PDO::FETCH_OBJ);
                     
                       $maxRow=sizeof($prepare_2);
                     if ($maxRow>1) {
                         $response[$i]=$prepare_2[($maxRow-1)];
                     }else{
                         $response[$i]=$prepare_2[0];
                     }
                       
                       

                    }
                    echo json_encode($response);

                   } else {
                      if (sizeof($prepare_1)==1) {
                           $matricule=$prepare_1[0]->_MAT;
                       $Query="SELECT student._MAT, student._NAME,student._PHONE,subscrit._CODE_CLASS,subscrit._CODE_SECTION,pay._CODE_SLICE,pay._ANASCO,student._PICTURE"
                       ." FROM t_students student JOIN t_subscription subscrit ON student._MAT=subscrit._MATR_PUPIL JOIN t_payment pay ON pay._IDPAY=subscrit._CODE_PAY".
                              " WHERE subscrit._MATR_PUPIL=:matr AND pay._DEPARTMENT=:depart";
                       
                       $SQL_PREPARE=$db->prepare($Query);
                       $SQL_PREPARE->execute(array(
                           "matr"=>$matricule,
                           "depart"=>$_SESSION['direction']
                       ));
                       $prepare_2=$SQL_PREPARE->fetchAll(PDO::FETCH_OBJ);
                       //echo json_encode($prepare_2);
                       $tab=array();
                       if(sizeof($prepare_2)>1){
                        $tab[0]=$prepare_2[sizeof($prepare_2)-1];
                        echo json_encode($tab);
                       }else{
                           echo json_encode($prepare_2);
                       }
                       
                      } else {
                         echo "not found";
                      }
                      
                   }

                   
                    
                }
                if (isset($_GET['_resub'])) {
                    $resub=$_GET['_resub'];

                    try{
                        $payGenerate="PAY-".time();
                        $db=getDB();
                    $Query="INSERT INTO t_payment (_IDPAY,_MATR,_CODE_SLICE,_DATEPAY,_TIMEPAY,_ANASCO,_AMOUNT,_USER_AGENT,_DEPARTMENT)".
                   " VALUES (:idpay,:matr,:codeSlice,:datepay,:timepay,:anasco,:amount,:userAgent,:department)";
                   $db->beginTransaction();
                   $SQL_PREPARE=$db->prepare($Query);
                   $SQL_PREPARE->execute(array(
                       "idpay"=>$payGenerate,
                       "matr"=>$resub,
                       "codeSlice"=>"RESUB",
                       "datepay"=>__DATE__,
                       "timepay"=>__TIME__,
                       "amount"=>"10",
                       "anasco"=>$_SESSION['anasco'],
                       "userAgent"=>$_SESSION['uid'],
                       "department"=>$_SESSION['direction']
                   ));
                   $db->commit();

                
                $Query="INSERT INTO t_subscription (_MATR_PUPIL,_CODE_CLASS,_CODE_SECTION,_DATE_SUB,_CODE_PAY,_CODE_AGENT) ".
                " VALUES (:matr,:codeClass,:codeSection,:dateSub,:codePay,:codeAgent)";
                $db->beginTransaction();
                $SQL_PREPARE=$db->prepare($Query);
                $SQL_PREPARE->execute(array(
                    "matr"=>$resub,
                    "codeClass"=>$_GET['_codeClasse'],
                    "codeSection"=>$_GET['_codeSection'],
                    "dateSub"=>__DATE__,
                    "codePay"=>$payGenerate,
                    "codeAgent"=>$_SESSION['uid']

                ));
                $db->commit();
                $_SESSION['idpayResub']=$payGenerate;
                $_SESSION['namePupilResub']=$_GET['_namePupil'];
                if($_GET['_codeClasse']==1){
                    $_SESSION["levelResub"]=$_GET['_codeClasse']."ere ".$_GET['_codeSection'];
                }else{
                    $_SESSION["levelResub"]=$_GET['_codeClasse']."eme ".$_GET['_codeSection'];
                }
            echo "Saved";
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }
                }

?>