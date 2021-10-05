<?php
//This file _MUST_ be left out of public web directories.

//We must reference the exact location of the files so that they can be found in a cronjob execution.
$DIR="";

include $DIR . 'local_arguments.php'; //This file contains our connection DSN. Keep it our of public web directories.
include $DIR . 'local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.
include $DIR . 'sendMail.php'; //This file contains our sendMail function. Keep it out of public web directories.

//Static variables
$receipientName = ""; //The name of the person you're sending the email to.
$recipientEmail = "";	//The email of the person you're sending the email to.

//Now we will create our prepared statement for selecting our uncomplete tasks from the database.
$tasks_fetch_prepare = pg_prepare($con, 'tasks_fetch', "SELECT task_table.task_name FROM tasks task_table WHERE task_table.task_id NOT IN (SELECT task_id FROM completed_tasks WHERE completion_time > date_trunc('day', now()))");

//Now we will execute our prepared statement.
$tasks_fetch_execute = pg_execute($con, 'tasks_fetch', array());

//Now we will get our rows from our executed statement.
$tasks_fetch = pg_fetch_all($tasks_fetch_execute);

//We are going to iterate over our results and create a string to pass as our email body.
$task_string = "You forgot to complete the following tasks:\n\n";
for ($i = 0; $i < count($tasks_fetch); $i++) {
	$task_string = $task_string . $tasks_fetch[$i]['task_name'];
	if ($i != count($tasks_fetch) - 1) {
		$task_string .= ", and\n";
	}
	else {
		$task_string .= ".\n\n What are you going to do about it?";
	}
}

$result = sendMail($task_string, $recipientName, $recipientEmail);

echo $result;

exit();

?>
