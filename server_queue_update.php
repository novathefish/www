<?php
session_start();
include('../functions.php');
prettyprint($_SESSION);


$sql = ("SELECT `account_id` FROM `queue` ORDER BY `id` ASC");


$sql = $conn->prepare('SELECT `account_id` FROM `queue` ORDER BY `id` ASC');
if($sql != FALSE){
  if($sql->execute()){
    $result = $sql->get_result();
    while($row = $result->fetch_assoc()){
      $queue_array = $row['account_id'];
    }
      $sql->close();
  }
  else{
    echo "Something went wrong with your request -- ";
    echo $conn->error;
  }
}


if($row->result > 0){
  while($row->fetch_assoc()){
     $queue_array[] = $row['account_id'];
  }
  if(count($queue_array) == even){
   foreach($queue_array){

    }
  }
  else{
   //remove last array item
   $players_per_match = 1;
   $match_id = 0;
   foreach($queue_array as $key => $value){
    if($players_per_match == 1){
      $new_match_array[$match_id]['account_id'] = $queue_array['account_id'];
      $players_per_match++;
    }
    elseif($players_per_match == 2){
      $new_match_array[$match_id]['account_id'] = $queue_array['account_id'];
      $players_per_match--;
      $match_id++;
    }
  }
}
echo $key;

?>
