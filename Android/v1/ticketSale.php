<?php 

require_once '../includes/DbOperations.php';
 
$response_data = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

    if (
        isset($_POST['event']) and 
        isset($_POST['ticket_type']) and
         isset($_POST['phone']) and
          isset($_POST['email']) and 
          isset($_POST['code'])) {    

        $db = new DbOperations; 
        $ticket = $db->makeSales($_POST['event'],$_POST['ticket_type'],$_POST['phone'],$_POST['email'],$_POST['code']);
        $response_data = array();
        $response_data['error'] = false; 
        $response_data['message'] = $ticket; 
    }
}
echo json_encode($response_data);