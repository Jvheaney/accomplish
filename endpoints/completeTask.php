<?php
include '../local_arguments.php'; //This file contains our connection DSN. Keep it our of public web directories.
include '../local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.

//Here we will set our content-header.
header('Content-Type: application/json');


//We will get our POST variables.
$taskId = $_POST['task_id'];
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


//Now we will create our prepared statement for inserting our new completed task into the database.
$task_complete_prepare = pg_prepare($con, 'task_complete', 'INSERT INTO completed_tasks (task_id, completion_time) VALUES ($1, now())');

//Now we will execute our prepared statement.
$task_complete_execute = pg_execute($con, 'task_complete', array($taskId));

//Now we will check to see how many rows were affected to see if the execution worked.
if(pg_affected_rows($task_complete_execute) == 1) {
	//All is good! We will return a success message to the client.
	$response = new ReturnModel();
  $response->setData("Success.");
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
