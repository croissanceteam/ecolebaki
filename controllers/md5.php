<?php
// echo md5('1234567');
// include_once 'db.php';
//
//
// $db = getDB();
//
// $req5 = "SELECT student.*, sub._CODE_SECTION,sub._CODE_CLASS FROM t_students student
//       INNER JOIN t_subscription sub ON sub._MATR_PUPIL = student._MAT
//       WHERE student._MAT=:matricule AND sub._ANASCO=:anasco";
//
// $select = $db->prepare($req5);
// $select->execute([
//   'matricule'  =>  'YOLO000228',
//   'anasco'  =>  null
// ]);
//
// var_dump($select->rowCount());
//
// $student = $select->fetch();
//
// die();
// $current_dir = getcwd();
//
// $current_dir_tab = explode('/',$current_dir);
//
// // var_dump($current_dir_tab);
// $size = sizeof($current_dir_tab);
//
// $size -= 1;
// $path_tab = [];
// for ($i=0; $i < $size; $i++) {
//   $path_tab[] = $current_dir_tab[$i];
// }
//
// // var_dump($path_tab);
//
// $path = implode('/',$path_tab);
//
// var_dump(is_writable($path.'/storage'));
// // if(!is_dir($path.'/storage')){
// //   mkdir($path.'/storage',0777,true);
// // }
//
// var_dump(is_dir($path.'/storage'));
//
// $file_content = "Update hello";
//
// $mypath = $path."/storage/Monlog-".time().".ch";
//
// $file = fopen($mypath,'a');
//
//   fwrite($file, $file_content);
//   fclose($file);


$pass = password_hash('Baki123',PASSWORD_BCRYPT);

echo "Hash : ".$pass;
