<?php

$host = '127.0.0.1';
$db = 'test_project';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function prettyprint($value){
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

function initiate_game(){

}

function queue($conn){

}

function novas_game($conn){
	$user_accounts = array();

	$sql = 'SELECT * FROM `accounts`';
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$user_accounts[$row['id']]['id'] = $row['id'];
			$user_accounts[$row['id']]['username'] = $row['username'];
			$user_accounts[$row['id']]['password'] = $row['password'];
			$user_accounts[$row['id']]['wins'] = $row['wins'];
			$user_accounts[$row['id']]['losses'] = $row['losses'];
		}
    // prettyprint($user_accounts);
	}
	else {
	  echo "0 results";
	}
}


// queue list > throw 2 account ids into player 1 and player 2 slot > player table gets both

?>
