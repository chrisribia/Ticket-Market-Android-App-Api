<?php 

require_once '../includes/DbOperations.php';

$response_data = array(); 

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $db = new DbOperations;
    $tickets = $db->getAllTicket();
    if (!$tickets == null) {
        $response_data['error'] = false;
       // $response_data['Tickets'] = $tickets;
         $Events = array();
         $Event = array();

        foreach($tickets as $Eventz){ 
            $event_name = $db->getevent($Eventz["event_code"]); 
            $tickets_details = $db->getTicketType($Eventz["event_code"]);            

            $Event["id"] = $Eventz["id"];
            $Event["qr_code"] = $Eventz["qr_code"];
            $Event["ticket_code"] = $Eventz["ticket_code"];

            if($Eventz["attended"] == 1)
                $Event["attended"] = "Confirmed";
            else
                $Event["attended"] = "UnConfirmed";
                 

           

            foreach($event_name  as $name){                    
            $Event["event_name"] = $name['event_name'];
            }

            foreach($tickets_details  as $detail){                    
                $Event["ticket_type"] = $detail['ticket_type'];
                $Event["no_of_tickets"] = $detail['no_of_tickets'];
                $Event["ticket_price"] = $detail['ticket_price'];
                }
    
             

            array_push($Events, $Event);              
        } 
        $response_data['Events'] = $Events;
    }
}
echo json_encode($response_data);