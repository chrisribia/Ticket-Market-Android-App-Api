<?php 

require_once '../includes/DbOperations.php';
 

if($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_POST['ticket_code'])) {                 
        $db = new DbOperations; 
        $ticket = $db->updateTicketByCode($_POST['ticket_code']);
        $response_data = array();
        $response_data['error'] = false; 
        $response_data['message'] = $ticket; 
    }
}
echo json_encode($response_data);