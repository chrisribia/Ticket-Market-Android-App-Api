<?php 

require_once '../includes/DbOperations.php';

$response_data = array(); 

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $db = new DbOperations;
    $events_names = $db->geteventsNames();
    if (!$events_names == null) {
        $response_data['error'] = false; 
         
        $Event = array();
        $Event["names"] = $events_names;

    }
}
echo json_encode($Event);