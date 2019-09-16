<?php 

require_once '../includes/DbOperations.php';

$response_data = array(); 

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $db = new DbOperations;
    $tickets = $db->getevents();
    if (!$tickets == null) {
        $response_data['error'] = false;
       // $response_data['Tickets'] = $tickets;
         $Events = array();
         $Event = array();

        foreach($tickets as $Eventz){ 
            $event_name = $db->getevent($Eventz["event_code"]); 
            $tickets_details = $db->getTicketType($Eventz["event_code"]);  
            $Event_code =    $db->getevents($Eventz["event_code"]); 
            $Event_uncofirmed_tickets =    $db->getAllUnconfirmedTickets($Eventz["event_code"]); 
            $Event_cofirmed_tickets =    $db->getAllconfirmedTickets($Eventz["event_code"]); 


            $Event["unconfirmed_tickets"] = $Event_uncofirmed_tickets;
            $Event["confirmed_tickets"] = $Event_cofirmed_tickets;
            foreach($event_name as $ename){                
            $Event["event_name"] =  $ename['event_name'];
            }

          

            array_push($Events, $Event);              
        } 
        $response_data['Events'] = $Events;
    }
}
echo json_encode($response_data);