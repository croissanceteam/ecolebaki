<?php
session_start();

$tz = "Africa/Kinshasa";
$date = new DateTime($tz);
$date->setTimezone(new DateTimeZone($tz));
echo $date->format('Y-m-d H:i:s');
// echo $date->getTimestamp();
/*
date_default_timezone_set('Africa/Kinshasa');
echo date("Y-m-d H:d:s");
*/

/*
$amount = 49.9;
$termSumPaid = 100.00;
$totalTrim = 150.00;

$paid = $termSumPaid + $amount;
echo bcsub($totalTrim,$paid,2);
*/
// include_once('db.php');
//
// $db=getDB();
// $query_sql="SELECT schoolfees._CODE_YEAR,schoolfees._FEES_SCHOOL,fees._LABEL,schoolfees._SOLD ".
//           "FROM t_years_school AS years JOIN t_school_fees_years AS schoolfees ".
//                 "ON years.year=schoolfees._CODE_YEAR JOIN t_school_fees AS fees ON ".
//                 "fees._CODE=schoolfees._FEES_SCHOOL WHERE years.year=:anasco";
//
// $query_execute=$db->prepare($query_sql);
// $query_execute->execute
// (
//     array
//     (
//         'anasco'=>$_SESSION['anasco'],
//     )
// );
// $tabs=$query_execute->fetchAll(PDO::FETCH_OBJ);
// echo json_encode($tabs);
//  ?>
