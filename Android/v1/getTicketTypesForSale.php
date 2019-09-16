<?php 

require_once '../includes/DbOperations.php';

$response_data = array(); 

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $db = new DbOperations;
    $tickets = $db->getTicketTypeX();
    $Events = array();
    $Event = array();
    if (!$tickets == null) {
        $response_data['error'] = false; 
        

        foreach($tickets as $Eventz){ 
            $event_name = $db->getevent($Eventz["event_code"]);           

 
            $Event["id"] = $Eventz['id'];
            foreach($event_name  as $name){                    
            $Event["event_name"] = $name['event_name'];
            }
            $Event["ticket_type"] = $Eventz['ticket_type'];
            $Event["available_tickets"] = $Eventz['available_tickets'];
            $Event["ticket_price"] = $Eventz['ticket_price'];

            array_push($Events, $Event);              
        } 
        $response_data['Tickets'] = $Events;
    }
}
echo json_encode($response_data);