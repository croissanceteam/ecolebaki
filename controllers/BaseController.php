<?php
session_start();
include_once 'db.php';

class BaseController{

  protected function db()
  {
    return getDB();
  }
    /**
   * Undocumented function
   *
   * @param \String  $format
   * @return \DateTime
   */
  protected function myLocalTime($format = 'H:i:s')
  {
      $timezone  = 1; //(GMT -5:00) EST (U.S. & Canada)
      $time = time() + 3600*($timezone+date("I"));
      $newtime = gmdate($format, $time);
      return $newtime;
  }

  /**
 * Undocumented function
 *
 * @param \String  $format
 * @return \DateTime
 */
protected function myLocalDate($format = 'd-M-Y')
{
    $timezone  = 1; //(GMT -5:00) EST (U.S. & Canada)
    $time = time() + 3600*($timezone+date("I"));
    $newdate = gmdate($format, $time);
    return $newdate;
}
}
