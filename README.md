# Accomplish: The Simple Todo List App
A simple todo list app made for one person. Made in PHP, React-Native-Web, React.js, and uses Postgres. It reminds you to complete daily recurring tasks and sends you a reminder email if you have yet to complete them.

<div align="center" style="display: flex; flex-direction: row; width: 100%;">
  <img width="335" alt="Screen Shot 2021-10-06 at 1 43 27 AM" src="https://user-images.githubusercontent.com/40678238/136148078-f9ba63b8-37c3-42de-8fd6-f84d33517429.png">

  <img width="334" alt="Screen Shot 2021-10-06 at 1 43 35 AM" src="https://user-images.githubusercontent.com/40678238/136148107-7144fea1-b940-40eb-ad50-5e685edae690.png">
</div>


## Why
I've been coding for 15 years as of October 2021 but I mysteriously never made a todo list app, which seems to be everyone's first project. It also feels like a rite of passage, and I needed something to remind me to do Leetcode everyday (gosh darn tech interviews). I decided to bang it out one night, and in the spirit of Hacktoberfest, I decided to open source it.

## How it works
It's pretty simple, I have a PHP script called `setupDatabases.php` that connects to your default database (likely postgres) in your database server using PDO and builds out the two tables and two sequences required for accomplish. Edit the files to include your database server details, and then run that via command line to get all the tables setup.


I then have a /website/ directory that has our index.php. The index.php in this case just creates and injects our session in our React Native Web app which is include()'d in the file.


The endpoints are to be placed in a folder called /endpoints/ that is publically accessible. You will see warnings on the files about the `include` statements at the top; They are warning you to not place `local_utilities.php` and `local_arguments.php` in public directories. You can modify the relative URLs in the include to reflect where you've placed those files.


Finally, there are two files called `checkTasks.php` and `sendMail.php`. `checkTasks.php` gets called by our cronjob to query the database, check which tasks have not been completed, and send an email reminding us of them via `sendMail.php`. I have my cronjob set to run everyday at 7PM so there is enough time to squeeze out those last few tasks.

## The Stack
This is using vanilla PHP, React-Native-Web, React.js, and PostgreSQL. I picked PHP because this todo list app is only to be used by me, so I am not concerned about performance. Session based security is also enough for this use case.
