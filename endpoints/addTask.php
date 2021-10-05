<?php
include '../local_arguments.php'; //This file contains our connection DSN. Keep it our of public web directories.
include '../local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.

//Here we will set our content-header.
header('Content-Type: application/json');


//We will get our POST variables.
$taskName = $_POST['taskName'];
$SESSION_HASH = $_POST['token'];


//Here we will check our session
if (!isUserSessionValid($SESSION_HASH)) {
	//Our session is invalid, so we are returning a failed message to the client.
	$response = new ReturnModel();
  $response->setData("Invalid session.");
  $response->setSuccess(false);
  echo json_encode($response);
	exit();
}


//Now we will create our prepared statement for inserting our new task into the database.
$task_insert_prepare = pg_prepare($con, 'task_insert', 'INSERT INTO tasks (task_name) VALUES (TRIM($1)) RETURNING task_id');

//Now we will execute our prepared statement.
$task_insert_execute = pg_execute($con, 'task_insert', array($taskName));

//Now we will check to see how many rows were affected to see if the execution worked.
if(pg_affected_rows($task_insert_execute) == 1) {

	//All is good! We will return a success message to the client.

	//Lets get the task_id returned from the insert function and send that as the data to the client.
	$task_id = pg_fetch_all($task_insert_execute);
	$task_id = $task_id[0]['task_id'];

	$response = new ReturnModel();
  $response->setData($task_id);
  $response->setSuccess(true);
  echo json_encode($response);
	exit();
}
else {
	//There was an issue inserting, we will return a failed message to the client.
	$response = new ReturnModel();
  $response->setData("Failed to insert.");
  $response->setSuccess(false);
  echo json_encode($response);
	exit();
}



?>
