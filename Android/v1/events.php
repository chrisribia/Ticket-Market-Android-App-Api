<?php 

require_once '../includes/DbOperations.php';
 
 
                            
        $db = new DbOperations; 
        $ticket = $db->getClientName();
        $response_data = array();
        $response_data['error'] = false; 
        $response_data['Events'] = $ticket; 
   
echo json_encode($response_data);