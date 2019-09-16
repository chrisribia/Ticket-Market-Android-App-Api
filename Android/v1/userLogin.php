<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['email']) and isset($_POST['passcode'])) {
        $db = new DbOperations();
		$existence = $db->isEmailExist($_POST['email']);
		$response_data = array();
		if ($existence) 
		{
		if (password_verify($_POST['passcode'], $db->userLogin($_POST['email']))) {
			$ticket = $db->getUserByUsername($_POST['email']);                
			$response_data['error'] = false;
			$response_data['message'] = "login success";
			$response_data['user'] = $ticket;
		} else {
			$response_data['error'] = true;
			$response_data['message'] = "Invalid password";
		}
	} else {
		$response_data['error'] = true;
		$response_data['message'] = "User does not exist";
	}
} 
}
echo json_encode($response_data);
