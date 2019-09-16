<?php 

require_once '../includes/DbOperations.php';
 

if($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_POST['qr_code'])) {                 
        $db = new DbOperations; 
        $ticket = $db->getTicketStatus($_POST['qr_code']);
        $response_data = array();
        $response_data['error'] = false; 
        $response_data['status'] = $ticket; 
    }
}
echo json_encode($response_data);