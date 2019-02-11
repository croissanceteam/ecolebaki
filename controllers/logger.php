
<?php

session_start();
include_once 'db.php';
?>

<?php

class Logger {

    private $db;
    private $logged = "";

    public function getLogger($userid, $pwd) {
        $db = getDB();

        $req = "SELECT _MATR,_USERNAME,_PWD AS password,_PRIORITY,_CODE_DIRECTION,_ANASCO,_NAME FROM t_login login
                JOIN t_agent agent ON login._MATR_AGENT=agent._MATR
                WHERE login._USERNAME=?";

        $SQL_PREPARE = $db->prepare($req);
        $SQL_PREPARE->execute([$userid]);
        $Login = $SQL_PREPARE->fetch();


        if ($Login && password_verify($pwd, $Login->password)) {

            $QuerySlice = "SELECT * FROM t_slice_payment WHERE _ANASCO = ?";
            $SQL_PREPARE = $db->prepare($QuerySlice);
            $SQL_PREPARE->execute([$Login->_ANASCO]);
            $SlicePayment = $SQL_PREPARE->fetchAll();

            $users = $this->getCounterStats($Login->_CODE_DIRECTION);
            $pupils = $this->getPupils($Login->_CODE_DIRECTION, $Login->_PRIORITY, $Login->_ANASCO);
            $agents = $this->getAgents($Login->_CODE_DIRECTION, $Login->_PRIORITY);
            $logged = array
                (
                'login' => $Login,
                'slices' => $SlicePayment,
                'users' => $users,
                'pupils' => $pupils,
                'agents' => $agents,
                'years' => $this->getYears()
            );
        } else {
            return array();
        }
        return $logged;
    }

    public function getCounterStats($direction) {
        $db = getDB();
        $Query = "SELECT _MATR,_USERNAME,_PRIORITY,_CODE_DIRECTION,_ANASCO FROM t_login
                  login JOIN t_agent agent ON login._MATR_AGENT=agent._MATR
                  WHERE agent._CODE_DIRECTION=:direction";
        $sql = $db->prepare($Query);
        $sql->execute(['direction' => $direction]);
        $response = $sql->fetchAll();
        return $response;
    }

    public function getPupils($direction, $priority, $anasco) {
        $db = getDB();

        $Query = "SELECT DISTINCT(students._MAT),students._NAME,students._SEX,students._PICTURE
                    FROM t_students students
                    JOIN t_payment pay ON students._MAT=pay._MATR
                    WHERE pay._DEPARTMENT = :direction AND pay._ANASCO = :anasco";
        // " GROUP BY students._MAT";
        $sql = $db->prepare($Query);
        $sql->execute([
            'direction' => $direction,
            'anasco' => $anasco
        ]);
        $response = $sql->fetchAll();

        return $response;
    }

    public function getAgents($direction, $priority) {
        $db = getDB();
        switch ($priority) {
            case 'user':
                $Query = "SELECT * FROM t_agent WHERE _CODE_DIRECTION=:direction";
                $sql = $db->prepare($Query);
                $sql->execute
                        (
                        array
                            (
                            'direction' => $direction
                        )
                );
                $response = $sql->fetchAll(PDO::FETCH_OBJ);
                break;

            default:
                $Query = "SELECT * FROM t_agent WHERE _CODE_DIRECTION=:direction";
                $sql = $db->prepare($Query);
                $sql->execute
                        (
                        array
                            (
                            'direction' => $direction
                        )
                );
                $response = $sql->fetchAll(PDO::FETCH_OBJ);
                break;
        }
        return $response;
    }

    public function getYears() {
        $db = getDB();
        $query = "SELECT * FROM t_years_school ORDER BY year DESC";
        $query_execute = $db->prepare($query);
        $query_execute->execute();
        $response = $query_execute->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

}
?>
