<?php 

require_once '../includes/DbOperations.php';
 

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $db = new DbOperations;

    $tickets = $db->getAllUnconfirmedTickets('UEG0K6VLY9KS');     
        $response_data = array();
        $response_data['error'] = false;
        $response_data['balance'] = $tickets;
    
}
echo json_encode($response_data);