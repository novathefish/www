<?php
include('../functions.php');

if(isset($_POST['queue_user_id'])){
  $add_to_queue = $_POST['queue_user_id'];
  // $add_to_queue = 1;
  $check = 0;
  $response_code;
  $sql = $conn->prepare('SELECT `account_id` FROM `queue` WHERE `account_id` = ? LIMIT 1');
  if($sql != FALSE){
    $sql->bind_param('s', $add_to_queue);
    if($sql->execute()){
      $result = $sql->get_result();
      if($result->num_rows > 0){
        $response_code = '0_1';
        // echo 'You are already in the queue';
      }
      else{
        $check = 1;
        $response_code = '1_0';
        // echo 'You are not in the queue yet, we will attempt to add you to the queue<br>';
      }
    }
    else{
      $response_code = '0_2';
      // echo 'Something went wrong with your request -- ';
      // echo $sql->error;
      // echo '<br>';
    }
  }
  else{
    $response_code = '0_2';
    // echo 'Something went wrong with your request -- ';
    // echo $sql->error;
    // echo '<br>';
  }
  $sql->close();

  if($check == 1){
    $sql = $conn->prepare("INSERT INTO `queue` (`account_id`) VALUES (?)");

    if($sql != FALSE){
      $sql->bind_param('s', $add_to_queue);
      if($sql->execute()){
        // prettyprint($sql);

        if($sql->affected_rows > 0){
          //added to queue
          $response_code = '2_0';
          // echo 'You have been added to the queue';
          // echo $conn->error;
        }
        else{
          if($response_code == '1_0'){
            $response_code = '1_2';
            // echo 'We tried adding you to the queue, but something went wrong'
            // echo $conn->error;
          }
          else{
            $response_code = '0_2';
            // echo 'Something went wrong with your request -- test1';
            // echo $conn->error;
          }
        }
      }
      else{
        if($response_code == '1_0'){
          $response_code = '1_2';
          // echo 'We tried adding you to the queue, but something went wrong'
          // echo $conn->error;
        }
        else{
          $response_code = '0_2';
          // echo 'Something went wrong with your request -- test1';
          // echo $conn->error;
        }
      }
    }
    else{
      if($response_code == '1_0'){
        $response_code = '1_2';
        // echo 'We tried adding you to the queue, but something went wrong'
        // echo $conn->error;
      }
      else{
        $response_code = '0_2';
        // echo 'Something went wrong with your request -- test1';
        // echo $conn->error;
      }
    }
  }
}
else{
  $response_code = '0_0';
  // echo 'You are missing an account id';
}

if(!empty($response_code)){
  echo $response_code;
}

?>
