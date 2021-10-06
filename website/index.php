<?php
include '../local_utilities.php'; //This file contains helpful functions and models. Keep it out of public web directories.

//Now we will call our session creation function.
$SESSION_HASH = createSession();

//We inject a script tag to the end of the page to insert out session hash.
echo "<script>window.token='$SESSION_HASH';</script>";

//And now we will render our html.
include("./index.html");


?>

