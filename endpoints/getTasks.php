<?php
include '../local_arguments.php'; //This file contains our connection DSN. Keep it our of public web directories.
include '../local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.

//Here we will set our content-header.
header('Content-Type: application/json');


//We will get our POST variables.
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


//Now we will create our prepared statement for selecting our tasks from the database.
$tasks_fetch_prepare = pg_prepare($con, 'tasks_fetch', "SELECT t.task_name, t.task_id, EXISTS(SELECT c.task_id FROM completed_tasks c WHERE c.task_id = t.task_id AND c.completion_time = date_trunc('day', now())) as completed FROM tasks t;");

//Now we will execute our prepared statement.
$tasks_fetch_execute = pg_execute($con, 'tasks_fetch', array());

//Now we will get our rows from our executed statement.
$tasks_fetch = pg_fetch_all($tasks_fetch_execute);

//Now we will return them to the client.
$response = new ReturnModel();
$response->setSuccess(true);
$response->setData($tasks_fetch);
echo json_encode($response);

exit();
?>
