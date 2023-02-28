<?php
//<!-----
#
global $mysqli;

function db_conn($db_suffix = '') {
global $g, $mysqli;
require_once('db_config.php');

########################################################
$mysqli = new mysqli("$db_host","$db_user","$db_pass");
if (!$mysqli) {
  msg("Can't connect to MySQL!");
  return 1;
}

$mysqli->select_db($db);
}

function mysql_keep_alive() {
global $mysqli;
  if($mysqli->ping()!=1 && $mysqli->ping()!=1) {
      @$mysqli->close();
      while(db_conn()==1) sleep(5);
  }
}

function db_update($sql) {
global $mysqli;
   msg($sql);
   $mysqli->query($sql);
   return $mysqli->affected_rows;
}

function db_insert($sql) {
    global $mysqli;
       msg($sql);
       $mysqli->query($sql);
       if(!empty($mysqli->error)){
           var_dump($mysqli->error);
       }
       return $mysqli->affected_rows;
}

function db_select($sql) {
global $mysqli;
   msg($sql);
   @$result = $mysqli->query($sql);
   if($mysqli->affected_rows == 1) {
      $row = $result->fetch_object();
      $mysqli->next_result();
   }
   if(is_object($result)) $result->close();
   if(is_object($row)) return $row;
      else return 0;
}

function db_select_one($sql) {    
global $mysqli;
   msg($sql);
   $data = NULL;
   @$result = $mysqli->query($sql);
   if($mysqli->affected_rows == 1) {
      $row = $result->fetch_array(2);
      $data = $row[0];
   }
   if(is_object($result)) $result->close();
   return $data;
}


function db_select_array($sql,$i=0) {
global $mysqli;
   msg($sql);
   @$result = $mysqli->query($sql);
   if($mysqli->affected_rows > 0) {
      while($row = $result->fetch_object()) {                  
        if($i == 0) {
            $key = current($row);   # first row should be unique
            $obj[$key] = $row;
        } else {
            if($i == 1) {
                $obj[] = $row;
            } else {
                # i = 2
                if(!$field) $field = key($row);                
                $obj[] = $row->$field;
            }
        }
      }
   } else $obj = 0;
   if(is_object($result)) $result->close();
   return $obj;
}

function db_select_array_result($sql) {
    global $mysqli;
       msg($sql);
       $rows = array();     
       @$result = $mysqli->query($sql);       
       if($mysqli->affected_rows > 0) {
            while($row = $result->fetch_object()) {
                $rows[]=$row;
            }
       }
       $result->close();
       return $rows; 
}

function get($index){
    if(!empty($_GET[$index])){
        $str=$_GET[$index];
        return $str;
    }
    return "";
}

function genRandNum($length){
    $digits = $length;
    return $rand = rand(pow(10, $digits-1), pow(10, $digits)-1);
}

function genCallid($length)
{
        $rand = genRandNum(4);
        $tstmp = strrev(time());
        return $str = $tstmp.$rand;
}

function msg($str) {       
  global $debug,$agi,$logfile;
  if($debug) {
      if(is_array($str) || is_object($str)) $str = print_r($str, true);
  }

  if($debug == 1) echo "$str\n";
    elseif($debug == 2) $agi->verbose($str);
    elseif($debug == 3) file_put_contents($logfile, "$str\n", FILE_APPEND | LOCK_EX);
}

function write_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}

function recieve_sms(){
    $sms_from = get('cli');
    $sms_to = get('sms_to');
    $sms_text = get('message');
    $provider = get('provider');
    global $mysqli;
    
    if (mb_detect_encoding($sms_text) == 'UTF-8') {
        $sms_text = iconv('utf-8', 'ucs-2', $sms_text);        
    }
    $sms_text = mysqli_real_escape_string($mysqli, $sms_text);
    //$account_id = '100000';

    $callid = genCallid(4);
    $sms_from = ltrim($sms_from, '+');
    $sms_to = ltrim($sms_to, '+');
    $log_time = date('Y-m-d H:i:s');

    $account_id = db_select_one("SELECT account_id FROM did WHERE did = $sms_to");
    if(!empty($account_id)){
        db_insert("INSERT INTO log_sms (account_id, callid, did, client, sms_text, log_time, status, direction) VALUES ('$account_id', '$callid', '$sms_to', '$sms_from', '$sms_text', '$log_time', 'U', 'I')");
    }else{
        write_log("[".date('Y-m-d H:i:s')."] From: $sms_from , To: $sms_to, Text: $sms_text, Message: Error: Account Id not found.");
    }
}
db_conn();
recieve_sms();

