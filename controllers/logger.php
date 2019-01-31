
<?php
    session_start();
    include_once 'db.php';
?>

<?php
    class Logger{
        private $db;
        private $logged="";



        public function getLogger($userid,$pwd){
            $db=getDB();
            $QuerySlice="SELECT * FROM t_slice_payment";
            $SQL_PREPARE=$db->prepare($QuerySlice);
            $SQL_PREPARE->execute();
            $SlicePayment=$SQL_PREPARE->fetchAll(PDO::FETCH_OBJ);

            $Query="SELECT _MATR,_USERNAME,_PRIORITY,_CODE_DIRECTION,_ANASCO,_NAME FROM t_login login 
                    JOIN t_agent agent ON login._MATR_AGENT=agent._MATR
                    WHERE login._USERNAME=:userid AND login._PWD=:pwd";

                   $SQL_PREPARE=$db->prepare($Query);
                   $SQL_PREPARE->execute(array(
                       "userid"=>$userid,
                       "pwd"=>md5($pwd)
                   ));
                   $Login=$SQL_PREPARE->fetchAll(PDO::FETCH_OBJ);

                   if (sizeof($Login)==1) {

                    $users=$this->getCounterStats($Login[0]->_CODE_DIRECTION);
                    $pupils=$this->getPupils
                    (
                        $Login[0]->_CODE_DIRECTION,
                        $Login[0]->_PRIORITY,
                        $Login[0]->_ANASCO
                    );
                    $agents=$this->getAgents($Login[0]->_CODE_DIRECTION,$Login[0]->_PRIORITY);
                       $logged=array
                       (
                        'login'=>$Login,
                        'slices'=>$SlicePayment,
                        'users'=>$users,
                        'pupils'=>$pupils,
                        'agents'=>$agents,
                        'years'=>$this->getYears()
                       );
                   } else {
                       return array();
                   }
                   return $logged;
        }
        public function getCounterStats($direction){
            $db=getDB();
            $Query="SELECT _MATR,_USERNAME,_PRIORITY,_CODE_DIRECTION,_ANASCO FROM t_login ".
            " login JOIN t_agent agent ON login._MATR_AGENT=agent._MATR".
            " WHERE agent._CODE_DIRECTION=:direction";
            $sql=$db->prepare($Query);
            $sql->execute
            (
                array
                (
                    'direction'=>$direction
                )
            );
            $response=$sql->fetchAll(PDO::FETCH_OBJ);
            return $response;


        }

        public function getPupils($direction,$priority,$anasco){
            $db=getDB();
           
            $Query="SELECT DISTINCT(students._MAT),students._NAME,students._SEX,students._PICTURE 
                    FROM t_students students
                    JOIN t_payment pay ON students._MAT=pay._MATR
                    WHERE pay._DEPARTMENT = :direction AND pay._ANASCO = :anasco";
            // " GROUP BY students._MAT";
            $sql=$db->prepare($Query);
            $sql->execute([
                'direction'=>$direction,
                'anasco'=>$anasco
            ]);
            $response=$sql->fetchAll(PDO::FETCH_OBJ);

            return $response;
        }

        public function getAgents($direction,$priority){
            $db=getDB();
            switch ($priority) {
                case 'user':
                    $Query="SELECT * FROM t_agent WHERE _CODE_DIRECTION=:direction";
                    $sql=$db->prepare($Query);
                    $sql->execute
                    (
                        array
                        (
                            'direction'=>$direction
                        )
                    );
                    $response=$sql->fetchAll(PDO::FETCH_OBJ);
                    break;

                default:
                    $Query="SELECT * FROM t_agent WHERE _CODE_DIRECTION=:direction";
                    $sql=$db->prepare($Query);
                    $sql->execute
                    (
                        array
                        (
                            'direction'=>$direction
                        )
                    );
                    $response=$sql->fetchAll(PDO::FETCH_OBJ);
                break;
            }
            return $response;
        }
        public function getYears(){
            $db=getDB();
            $query="SELECT * FROM t_years_school ORDER BY year DESC";
            $query_execute=$db->prepare($query);
            $query_execute->execute();
            $response=$query_execute->fetchAll(PDO::FETCH_OBJ);
            return $response;
        }
    }
?>
