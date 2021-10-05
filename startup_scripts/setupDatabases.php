<?php
//This script should be run first and from the command line.
//This script should _NEVER_ be placed in public directories.

//Our static variables
$DB_ADDRESS="";	//The address of our database server.
$DB_PORT="";		//The port of our database server.
$DB_NAME="";		//The initial database we are going to connect to. You probably want 'postgres'.
$USER="";			//A superuser for our database server.
$PASSWORD="";			//Our superuser's password.
$DB_NON_SU_USER="";	//A non-superuser for our new database.

//Our two connection strings; the first is for the initial database, the second is for the one that will be created.
$DSN="pgsql:host=$DB_ADDRESS;port=$DB_PORT;dbname=$DB_NAME;user=$USER;password=$PASSWORD";
$DSN_accomplish="pgsql:host=$DB_ADDRESS;port=$DB_PORT;dbname=accomplish;user=$USER;password=$PASSWORD";

//Now we will begin our code execution.
try {

	//We will connect to our initial database with the first connection string.
	$con = new PDO($DSN);

	if($con) {
		echo "Successfully connected to database server!\n";

		//Creating our database.
		$createDatabase_sql = "CREATE DATABASE accomplish;";
		//Executing our creation SQL.
		$con->exec($createDatabase_sql);

		//Now we will create a new PDO with our new database.
		try {
			$con_accomplish = new PDO($DSN_accomplish);

			if($con_accomplish) {
				echo "Successfully connected to accomplish database server!\n";

				//This creates the table for storing our daily tasks. It is very simple, you can add a lot more to this like frequency, userids, etc.
				$tasksTableCreate_sql = "CREATE TABLE IF NOT EXISTS tasks (task_id serial PRIMARY KEY, task_name varchar(256) NOT NULL)";
				//This creates the table that stores our task completions.
				$taskCompletionTableCreate_sql = "CREATE TABLE IF NOT EXISTS completed_tasks (completion_id serial PRIMARY KEY, task_id int NOT NULL, completion_time timestamptz NOT NULL)";
				//This creates a unique index for the task_id and day of completion on completed_tasks.
				$uniqueIndexCreate_sql = "CREATE UNIQUE INDEX task_and_day ON completed_tasks(task_id, date_trunc('day',completion_time AT TIME ZONE 'EST'));";


				//Now we will execute our above SQL statements.
				$con_accomplish->exec($tasksTableCreate_sql);
				$con_accomplish->exec($taskCompletionTableCreate_sql);
				$con_accomplish->exec($uniqueIndexCreate_sql);

				//Our tables are created now, now we need to grant privileges to these tables for our non-superuser.
				$grantTablePrivileges_sql = "GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE tasks, completed_tasks TO $DB_NON_SU_USER";

				//Now we do the same for our sequences.
				$grantSequencePrivileges_sql = "GRANT USAGE, SELECT, UPDATE ON SEQUENCE tasks_task_id_seq, completed_tasks_completion_id_seq TO $DB_NON_SU_USER";


				//Now we will execute our above SQL statement.
				$con_accomplish->exec($grantTablePrivileges_sql);
				$con_accomplish->exec($grantSequencePrivileges_sql);
			}
			else {
				echo "Something is up while connecting to the accomplish database server...\n";
			}
		}
		catch(PDOException $e2) {
			echo $e2->getMessage();
		}
	}
	else{
		echo "Something is up while connecting to the initial database server...\n";
	}

}
catch(PDOException $e) {
	echo $e->getMessage();
}


?>
