<?php
include '../local_arguments.php'; //This file contains our connection DSN. Keep it our of public web directories.
include '../local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.

//Here we will set our content-header.
header('Content-Type: application/json');


//We will get our POST variables.
$taskId = $_POST['taskId'];
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
$task_undo_prepare = pg_prepare($con, 'task_undo', "DELETE FROM completed_tasks WHERE task_id=$1 AND completion_time = date_trunc('day',now())");

//Now we will execute our prepared statement.
$task_undo_execute = pg_execute($con, 'task_undo', array($taskId));


$response = new ReturnModel();
$response->setData("Success.");
$response->setSuccess(true);
echo json_encode($response);
exit();


?>
