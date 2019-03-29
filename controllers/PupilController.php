<?php

session_start();

include_once 'BaseController.php';

class PupilController extends BaseController {

    private static $reqGetActualPupilsList = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,UPPER(pupils._NAME) AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION AS section
                    FROM t_students pupils
                    JOIN t_payment payments ON pupils._MAT=payments._MATR
                    JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
                    WHERE subscrit._DEPARTMENT=:department AND subscrit._ANASCO=:year";
    private static $reqGetPupilsToReEnrol = "SELECT DISTINCT(pupils._ID) AS id, pupils._MAT AS matricule,UPPER(pupils._NAME) AS name_pupil,pupils._SEX AS gender,subscrit._CODE_CLASS AS level,subscrit._CODE_SECTION AS section
                    FROM t_students pupils
                    JOIN t_payment payments ON pupils._MAT=payments._MATR
                    JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
                    WHERE subscrit._DEPARTMENT=:department AND subscrit._ANASCO=:year
                    AND subscrit._MATR_PUPIL NOT IN (SELECT _MATR_PUPIL FROM t_subscription WHERE _ANASCO=:actualyear)";
    private static $reqInsertPay = "INSERT INTO t_payment (_IDPAY,_MATR,_CODETERM,_OBJECT,_DATEPAY,_TIMEPAY,_AMOUNT,_ANASCO,_USER_AGENT,_DEPARTMENT)
                    VALUES(:idpay,:matr,:codeterm,:objectpay,:datepay,:timepay,:amount,:anasco,:user,:department)";
    private static $reqInsertCollegeYears = "INSERT INTO t_subscription (_MATR_PUPIL,_CODE_CLASS,_CODE_SECTION,_DATE_SUB,_CODE_AGENT,_ANASCO,_DEPARTMENT)
                    VALUES (:matr,:codeClass,:codeSection,:dateSub,:codeAgent,:anasco,:department)";
    private static $reqGetTerm = "SELECT * FROM t_terms WHERE _CODETERM = ? AND _ANASCO = ?";
    private static $getTermSumPaidByPupil = "SELECT SUM(_AMOUNT) AS sum_term_paid FROM t_payment WHERE _CODETERM = ? AND _MATR = ?";

    public function update($param) {
        if ($_SESSION['priority'] != 'admin')
            return 6;

        try {

            $req1 = "UPDATE t_students SET _NAME=:name, _SEX=:gender, _ADRESS=:address, _PROVINCE=:province, _BIRTHDAY=:birthday, _BIRTHPLACE=:birthplace, _PHONE=:phone
              WHERE _MAT=:matricule";
            $req2 = "UPDATE t_subscription SET _CODE_CLASS=:class, _CODE_SECTION=:section WHERE _MATR_PUPIL=:matricule";

            $req3 = "UPDATE t_students SET _PICTURE=:picture WHERE _MAT=:matricule";

            $req4 = "INSERT INTO _students_listener VALUES(NULL,NULL,:user,:student,:logfile)";

            $req5 = "SELECT student.*, sub._CODE_SECTION,sub._CODE_CLASS FROM t_students student
              INNER JOIN t_subscription sub ON sub._MATR_PUPIL = student._MAT
              WHERE student._MAT=:matricule AND sub._ANASCO=:anasco";

            $db = parent::db();

            // return $param['picture'];
            // return 0;


            $select = $db->prepare($req5);
            $select->execute([
                'matricule' => $param['pupilmatr'],
                'anasco' => $_SESSION['anasco']
            ]);

            if ($select->rowCount() == 1) {
                $student = $select->fetch();
                $date = parent::myLocalDate();
                $time = parent::myLocalTime();
                $file_content = "Informations sur la modification effectuee \n";
                $file_content .= "------------------------------------------\n";
                $file_content .= "Auteur de l'action : " . $_SESSION['uid'] . "\n";
                $file_content .= "Date : " . $date . "\n";
                $file_content .= "Heure : " . $time . "\n";
                $file_content .= "Instance : " . $_SESSION['direction'] . "\n";
                $file_content .= "Annee scolaire en cours : " . $_SESSION['anasco'] . "\n";

                $file_content .= "-----\n\n";
                $file_content .= "Matricule de l'eleve : " . $student->_MAT . "\n\n";
                $file_content .= "DETAILS DE MODIFICATION\n\n";

                $changes = 0;
                if ($student->_NAME != $param['pupilname']) {
                    $file_content .= "- Nom : " . $student->_NAME . " => " . $param['pupilname'] . "\n";
                    $changes += 1;
                }
                if ($student->_SEX != $param['gender']) {
                    $file_content .= "- Genre : " . $student->_SEX . " => " . $param['gender'] . "\n";
                    $changes += 1;
                }
                if ($student->_ADRESS != $param['address']) {
                    $file_content .= "- Adresse : " . $student->_ADRESS . " => " . $param['address'] . "\n";
                    $changes += 1;
                }
                if ($student->_PROVINCE != $param['town']) {
                    $file_content .= "- Province : " . $student->_PROVINCE . " => " . $param['town'] . "\n";
                    $changes += 1;
                }
                if ($student->_BIRTHDAY != $param['birthday']) {
                    $file_content .= "- Date de naissance : " . $student->_BIRTHDAY . " => " . $param['birthday'] . "\n";
                    $changes += 1;
                }
                if ($student->_BIRTHPLACE != $param['born_town']) {
                    $file_content .= "- Lieu de naissance : " . $student->_BIRTHPLACE . " => " . $param['born_town'] . "\n";
                    $changes += 1;
                }
                if ($student->_PHONE != $param['phone']) {
                    $file_content .= "- Telephone : " . $student->_PHONE . " => " . $param['phone'] . "\n";
                    $changes += 1;
                }
                if ($student->_CODE_CLASS != $param['level']) {
                    $file_content .= "- Classe : " . $student->_CODE_CLASS . " => " . $param['level'] . "\n";
                    $changes += 1;
                }
                if ($student->_CODE_SECTION != $param['section']) {
                    $file_content .= "- Section : " . $student->_CODE_SECTION . " => " . $param['section'] . "\n";
                    $changes += 1;
                }


                $db->beginTransaction();

                $update1 = $db->prepare($req1);
                $update1->execute([
                    'name' => $param['pupilname'],
                    'gender' => $param['gender'],
                    'address' => $param['address'],
                    'province' => $param['town'],
                    'birthday' => $param['birthday'],
                    'birthplace' => $param['born_town'],
                    'phone' => $param['phone'],
                    'matricule' => $param['pupilmatr']
                ]);

                $update2 = $db->prepare($req2);
                $update2->execute([
                    'class' => $param['level'],
                    'section' => $param['section'],
                    'matricule' => $param['pupilmatr']
                ]);
                $picture_changed = false;
                if (strlen($param['picture']) > 0) {
                    $fileImage = convertBase64ToImage($param['picture'], $param['pupilmatr'] . ".png");
                    $update3 = $db->prepare($req3);
                    $update3->execute([
                        'picture' => $fileImage,
                        'matricule' => $param['pupilmatr']
                    ]);
                    $picture_changed = true;
                }

                if ($picture_changed) {
                    $file_content .= "- Mise à jour de la photo.";
                    $changes += 1;
                }
                if ($changes == 0) {
                    $file_content = '';
                    return 4;
                } else {
                    $current_dir = getcwd();
                    $current_dir_tab = explode('/', $current_dir);
                    $size = sizeof($current_dir_tab);

                    $size -= 1;
                    $path_tab = [];
                    for ($i = 0; $i < $size; $i++) {
                        $path_tab[] = $current_dir_tab[$i];
                    }
                    $path = implode('/', $path_tab);
                    $date4name = parent::myLocalDate('Y-m-d');
                    $time4name = parent::myLocalTime('H-i-s');
                    $filename = "shule-" . $date4name . "-" . $time4name . ".log";
                    $mypath = $path . "/storage/logs/" . $filename;

                    $file = fopen($mypath, 'a');

                    if (!$file) {
                        throw new \Exception("Erreur! Le fichier n'a pas pu être ouvert.", 1);
                    } else {
                        fwrite($file, $file_content);
                        fclose($file);
                    }
                }

                $insert = $db->prepare($req4);
                $insert->execute([
                    'user' => $_SESSION['uid'],
                    'student' => $param['pupilmatr'],
                    'logfile' => $filename
                ]);
            } else {
                throw new \Exception("Error Processing Request", 1);
            }


            // $current_dir = getcwd();
            //
        // $current_dir_tab = explode($current_dir);
            // // on lit le contenu du fichier
            // $recup = file_get_contents($current_dir.'./monfichier.txt');
            //
        // //on rajoute du contenu
            // $recup .= 'du contenu rajouté';
            //
        // // on enregistre le nouveau contenu dans le même fichier
            // file_put_contents('monfichier.txt', $recup);


            $db->commit();
            return 1;
        } catch (\Exception $e) {
            $db->rollBack();
            return $e->getMessage();
        }
    }

    public function getPupilInfos($id) {
        $db = parent::db();
        $query = "SELECT sb.*, st.* FROM t_students st
                  INNER JOIN t_subscription sb ON sb._MATR_PUPIL=st._MAT WHERE st._MAT=?";

        $result = $db->prepare($query);
        $result->execute([$id]);
        $ds = $result->fetch();

        return json_encode($ds);
    }

    public static function getPupils($direction, $year) {

        $db = parent::db();
        $query_sql = "SELECT DISTINCT(pupils._ID) as id, pupils.*, subscrit.*
                    FROM t_students pupils JOIN t_subscription subscrit ON pupils._MAT=subscrit._MATR_PUPIL
                    WHERE subscrit._DEPARTMENT=:department AND subscrit._ANASCO=:year AND pupils._STATUS = 1
                    ORDER BY pupils._ID DESC";
        $query_execute = $db->prepare($query_sql);
        $query_execute->execute([
            'department' => $direction,
            'year' => $year
        ]);
        // $tabs = $query_execute->fetchAll();
        $tabs = [];
        // $row = $query_execute->fetch();
        $i = 1;
        while ($row = $query_execute->fetch()) {
            $tabs[] = [
                'id' => $i++,
                'matricule' => $row->_MAT,
                'fullname' => $row->_NAME,
                'gender' => $row->_SEX,
                'address' => $row->_ADRESS,
                'town' => $row->_PROVINCE,
                'birthday' => $row->_BIRTHDAY,
                'born_town' => $row->_BIRTHPLACE,
                'phone' => $row->_PHONE,
                'picture' => $row->_PICTURE,
                'level' => $row->_CODE_CLASS,
                'section' => $row->_CODE_SECTION
            ];
        }
        $response = json_encode($tabs);
        $_SESSION['list_current_pupils'] = $response;
        $_SESSION['counter_pupil'] = sizeof(json_decode($response));
        echo $response;
    }

    public static function countPupilsByPromo() {
        $db = parent::db();
        $query = "SELECT pupil._MAT AS matr, sub._CODE_CLASS AS class, sub._CODE_SECTION AS section, sub._ANASCO AS anasco
                FROM t_students pupil
                JOIN t_subscription sub ON pupil._MAT=sub._MATR_PUPIL
                WHERE sub._DEPARTMENT=:department AND sub._ANASCO=:anasco OR sub._ANASCO=:last_anasco";
        $year = explode('-', $_SESSION['anasco']);
        $lastA = (int) $year[0] - 1;
        $last = $lastA . '-' . $year[0];
        $execute = queryDB($query, [
            'department' => $_SESSION['direction'],
            'anasco' => $_SESSION['anasco'],
            'last_anasco' => $last
        ]);
        $ds = $execute->fetchAll();
        $data = [];
        $M = [];
        $P = [];
        $current = $_SESSION['anasco'];
        for ($i = 1; $i <= 6; $i++) {
            $P[$current][$i] = 0;
            $P[$last][$i] = 0;
        }
        for ($i = 1; $i <= 3; $i++) {
            $M[$current][$i] = 0;
            $M[$last][$i] = 0;
        }

        foreach ($ds as $value) {

            switch ($value->class) {
                case 1:
                    if ($value->section == 'MATERNELLE') {
                        $M[$value->anasco][1] ++;
                    } else {
                        $P[$value->anasco][1] ++;
                    }
                    break;
                case 2:
                    if ($value->section == 'MATERNELLE') {
                        $M[$value->anasco][2] ++;
                    } else {
                        $P[$value->anasco][2] ++;
                    }
                    break;

                case 3:
                    if ($value->section == 'MATERNELLE') {
                        $M[$value->anasco][3] ++;
                    } else {
                        $P[$value->anasco][3] ++;
                    }
                    break;

                case 4:
                    $P[$value->anasco][4] ++;
                    break;

                case 5:
                    $P[$value->anasco][5] ++;
                    break;

                case 6:
                    $P[$value->anasco][6] ++;
                    break;

                default:
                    # code...
                    break;
            }
        }

        for ($class = 1; $class <= 3; $class++) {
            $suffix = ($class == 1) ? 'ere ' : 'eme';
            $data[] = [
                'promotion' => $class . 'º Ma.',
                'current' => $M[$current][$class],
                'last' => $M[$last][$class]
            ];
        }

        for ($class = 1; $class <= 6; $class++) {
            $suffix = ($class == 1) ? 'ere ' : 'eme';
            $data[] = [
                'promotion' => $class . 'º Pri.',
                'current' => $P[$current][$class],
                'last' => $P[$last][$class]
            ];
        }
        return json_encode($data);
    }

    public static function getPupilsToReEnrol() {

        $query_execute = queryDB(self::$reqGetPupilsToReEnrol, [
            'department' => $_SESSION['direction'],
            'year' => self::getLastYear(),
            'actualyear' => $_SESSION['anasco']
        ]);

        $ds = $query_execute->fetchAll();
        return json_encode($ds);
    }

    public static function getFees() {
        $db = parent::db();
        $query = "SELECT * FROM t_school_fees WHERE _STATUS=:status";
        $query_execute = $db->prepare($query);
        $query_execute->execute
                (
                array
                    (
                    'status' => 'active'
                )
        );
        return $query_execute->fetchAll();
    }

    public static function reEnrolPupil($data) {
        $payGenerate = "PAY-" . time();
        $db = parent::db();

        try {

            $db->beginTransaction();

            $execQuery1 = $db->prepare(self::$reqInsertPay);
            $execQuery1->execute([
                'idpay' => $payGenerate,
                'matr' => $data['mat_pupil'],
                'codeterm' => '1TRIM',
                'objectpay' => 'FRSCO',
                'datepay' => date('d/m/Y'),
                'timepay' => date('H:i:s'),
                'amount' => $data['amount'],
                'anasco' => $_SESSION['anasco'],
                'user' => $_SESSION['uid'],
                'department' => $_SESSION['direction']
            ]);

            $execQuery2 = $db->prepare(self::$reqInsertCollegeYears);
            $execQuery2->execute([
                "matr" => $data['mat_pupil'],
                "codeClass" => substr($data['new_level'], 0, 1),
                "codeSection" => $data['new_section'],
                "dateSub" => date('d/m/Y'),
                "codeAgent" => $_SESSION['uid'],
                "anasco" => $_SESSION['anasco'],
                "department" => $_SESSION['direction']
            ]);

            $resultTermInfos = $db->prepare(self::$reqGetTerm);
            $resultTermInfos->execute(['1TRIM', $_SESSION['anasco']]);

            $db->commit();

            $termAmount = $resultTermInfos->fetch();
            $total1TRIM = $termAmount->_AMOUNT;
            $remaining_amount = $total1TRIM - $data['amount'];

            $_SESSION['namePupil'] = $data['name_pupil'];
            $_SESSION['idpay'] = $payGenerate;
            $_SESSION['level'] = $data['new_level'] . " " . $data['new_section'];
            $_SESSION['amount'] = $data['amount'];
            $_SESSION['motifPay'] = $remaining_amount == 0 ? "1TRIM Trimestre - FRAIS SCOLAIRE" : "ACOMPTE - 1TRIM Trimestre - FRAIS SCOLAIRE";
            $_SESSION['remaining_amount'] = $remaining_amount;
            $_SESSION['anascoPay'] = $_SESSION['anasco'];
            return 1;
        } catch (PDOException $e) {
            $db->rollBack();
            return json_encode($e->getMessage());
        } catch (\Throwable $th) {
            $db->rollBack();
            return json_encode($th->getMessage());
        }
    }

    public static function getLastYear() {
        $result = queryDB("SELECT * FROM t_years_school ORDER BY year DESC LIMIT 0,2");
        $ds = $result->fetchAll();
        return $ds[1]->year;
    }

}
