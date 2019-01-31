<?php
session_start();
include_once('db.php');

$db=getDB();
$query_sql="SELECT schoolfees._CODE_YEAR,schoolfees._FEES_SCHOOL,fees._LABEL,schoolfees._SOLD ".
          "FROM t_years_school AS years JOIN t_school_fees_years AS schoolfees ".
                "ON years.year=schoolfees._CODE_YEAR JOIN t_school_fees AS fees ON ".
                "fees._CODE=schoolfees._FEES_SCHOOL WHERE years.year=:anasco";

$query_execute=$db->prepare($query_sql);
$query_execute->execute
(
    array
    (
        'anasco'=>$_SESSION['anasco'],
    )
);
$tabs=$query_execute->fetchAll(PDO::FETCH_OBJ);
echo json_encode($tabs);
 ?>
