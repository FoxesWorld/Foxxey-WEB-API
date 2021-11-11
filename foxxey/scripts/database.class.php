<?php
/*
=====================================================
 Database class
-----------------------------------------------------
 https://Foxesworld.ru/
-----------------------------------------------------
 Copyright (c) 2016-2021  FoxesWorld
-----------------------------------------------------
 This code is reserved
-----------------------------------------------------
 File: database.class.php
-----------------------------------------------------
 Verssion: 0.1.2.2 Experimental
-----------------------------------------------------
 Usage: Database class
=====================================================
*/
if(!defined('FOXXEY')) {
	die ('{"message": "Not in FOXXEY thread"}');
}	

class db {

  //const CHARSET = 'utf8';
 
  private static $db;

  public function __construct($db_user, $db_pass, $db_name, $db_location = 'localhost'){
	  //if(!self::$db) {
		  try {
			db::$db = new PDO(
			  'mysql:host='.$db_location.';dbname='.$db_name,
			  $db_user,
			  $db_pass,
			  $options = [
				  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
			  ]
			);
		  } catch (PDOException $e) {
			  $query = strval($e->queryString);
			  $message = $e->getMessage();
			  functions::display_error($message, $query, '1');
		  }

		  return self::$db;
	  //}
  }
 
  /**
   * @param $stmt
   * @return PDOStatement
   */
  public static function query($stmt)  {
    return self::$db->query($stmt);
  }
 
  /**
   * @param $stmt
   * @return PDOStatement
   */
  public static function prepare($stmt)  {
    return self::$db->prepare($stmt);
  }
 
  /**
   * @param $query
   * @return boolean
   */
  static public function exec($query) {
    return self::$db->exec($query);
  }
 
  /**
   * @return string
   */
  static public function lastInsertId() {
    return self::$db->lastInsertId();
  }
 
  /**
   * @param $query
   * @param array $args
   * @return PDOStatement
   * @throws Exception
   */
  public static function run($query, $args = [])  {
    try{
      if (!$args) {
        return self::query($query);
      }
      $stmt = self::prepare($query);
      $stmt->execute($args);
      return $stmt;
    } catch (PDOException $e) {
		  $message = $e->getMessage();
		  $num = $e->getCode();
		  functions::display_error($message, $num, $query);
    }
  }

  /**
   * @param $query
   * @param array $args
   * @return mixed
   */
  public static function getRow($query, $args = [])  {
    return self::run($query, $args)->fetch();
  }

  /**
   * @param $query
   * @param array $args
   * @return array
   */
  public static function getRows($query, $args = [])  {
    return self::run($query, $args)->fetchAll();
  }

  /**
   * @param $query
   * @param array $args
   * @return mixed
   */
  public static function getValue($query, $args = [])  {
    $result = self::getRow($query, $args);
    if (!empty($result)) {
      $result = array_shift($result);
    }
    return $result;
  }

  /**
   * @param $query
   * @param array $args
   * @return array
   */
  public static function getColumn($query, $args = [])  {
    return self::run($query, $args)->fetchAll(PDO::FETCH_COLUMN);
  }

  public static function sql($query, $args = [])
  {
    self::run($query, $args);
  }
  
  public static function display_error($error ='No errors', $error_num = 100500, $query) {
	global $config;
		$error = htmlspecialchars($error, ENT_QUOTES, 'ISO-8859-1');
		$trace = debug_backtrace();

		$level = 1;
		if ($trace[1]['function'] == "query" ) $level = 1;
		$trace[$level]['file'] = str_replace(ROOT_DIR, "", $trace[$level]['file']);

		echo '
				<?xml version="1.0" encoding="iso-8859-1"?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<title>MySQL Fatal Error '.$config['webserviceName'].'</title>
				<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
				<style type="text/css">

				body {
						font-family: Verdana, Arial, Helvetica, sans-serif;
						font-size: 11px;
						font-style: normal;
						color: #000000;
					}
					.top {
					  color: #ffffff;
					  font-size: 15px;
					  font-weight: bold;
					  padding-left: 20px;
					  padding-top: 10px;
					  padding-bottom: 10px;
					  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.75);
					  background-image: -moz-linear-gradient(top, #ab8109, #998f5a);
					  background-image: -ms-linear-gradient(top, #ab8109, #998f5a);
					  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ab8109), to(#998f5a));
					  background-image: -webkit-linear-gradient(top, #ab8109, #998f5a);
					  background-image: -o-linear-gradient(top, #ab8109, #998f5a);
					  background-image: linear-gradient(top, #ab8109, #998f5a);
					  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ab8109", endColorstr="#998f5a",GradientType=0); 
					  background-repeat: repeat-x;
					  border-bottom: 1px solid #ffffff;
					}
					.box {
						margin: 10px;
						padding: 4px;
						background-color: #EFEDED;
						border: 1px solid #DEDCDC;
					}

					</style>
					</head>
					<body>
						<div style="width: 700px;margin: 20px; border: 1px solid #D9D9D9; background-color: #F1EFEF; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; -moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3); -webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3); box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);" >
							<div class="top" >MySQ: Error! '.$config['webserviceName'].'</div>
							<div class="box" ><b>MySQL error</b> in file: <b>'.$trace[$level]['file'],'</b> at line <b>'.$trace[$level]['line'].'</b></div>
							<div class="box" >Error Number: <b> '.$error_num.'</b></div>
							<div class="box" >The Error returned was: <b> '.$error.'</b></div>
							<div class="box" ><b>SQL query:</b> '.$query.'</div>
							</div>		
					</body>
					</html>
			';
		exit();
	}
}