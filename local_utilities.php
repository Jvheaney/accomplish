<?php
//Our function for creating a session between the client and the server.
function createSession() {
	
	session_start();
	$SESSION_HASH='';
	
	$_SESSION['SESSION_TOKEN'] = microtime();
	if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    		$salt = '$iie7jdkks$' . substr(md5(uniqid(mt_rand(), true)), 0, 22);
    		$SESSION_HASH = crypt($_SESSION['SESSION_TOKEN'], $salt);
		return $SESSION_HASH;	
	}
	else {
		return "CRYPTERROR";
	}
}


//Our function for checking if a session is active and valid.
function isUserSessionValid($SESSION_HASH = null) {

	if ($SESSION_HASH == null) {
		return false;
	}

	session_start();
	if (crypt($_SESSION['SESSION_TOKEN'], $SESSION_HASH) == $SESSION_HASH) {
		return true;
	}
	else {
		return false;
	}

}

//Our JSON return class.
class ReturnModel {

	//This should be a boolean.
	public $success;
	//This will contain our success, error, or array data.
	public $data;

	public function getSuccess() {
		return $this->success;
	}

	public function setSuccess($success) {
		$this->success = $success;
	}

	public function getData() {
		return $this->data;
	}

	public function setData($data) {
		$this->data = $data;
	}

}

?>
