<?php 

	class DbOperations{

		private $con; 

		function __construct(){

			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

		}

		/*CRUD -> C -> CREATE */

		

		public function userLogin($email){		
			 
			$stmt = $this->con->prepare("SELECT passcode FROM tic_users WHERE email = ?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->bind_result($passcode);
            $stmt->fetch(); 
            return $passcode;			 
		}

		public function isEmailExist($email){
            $stmt = $this->con->prepare("SELECT id FROM tic_users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

		public function getUserByUsername($email){
			$stmt = $this->con->prepare("SELECT id,first_name,last_name,phone,email FROM tic_users WHERE email = ?");
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->bind_result($id, $first_name,$last_name,$phone,$email);	
			$tickets = array();              
                 while ($stmt->fetch()) {
                     $ticket = array();
                     $ticket['id'] = $id;
                     $ticket['first_name'] = $first_name;
					 $ticket['last_name'] = $last_name;
					 $ticket['phone'] = $phone;
					 $ticket['email'] = $email;
					  
                     
                 }                   
            return $ticket; 
		}
			 
		 
	 

		public function getAllTicket(){
            $stmt = $this->con->prepare("SELECT id,ticket_code, qr_code,event_code,client_code,attended FROM tic_tickets ");
            $stmt->execute(); 
			$stmt->bind_result($id,$ticket_code,$qr_code, $event_code, $client_code,$attended);
			 
            $tickets = array(); 
            while($stmt->fetch()){ 
                $ticket = array(); 
				$ticket['id'] = $id; 
				$ticket['ticket_code']=$ticket_code; 
                $ticket['qr_code']=$qr_code; 
                $ticket['event_code'] = $event_code; 
				$ticket['client_code'] = $client_code; 
				$ticket['attended'] = $attended; 
                array_push($tickets, $ticket);
			}             
			return $tickets; 
		 
		}
		
		

		public function getTicketStatus($qr_code){
			$stmt = $this->con->prepare("SELECT attended FROM tic_tickets WHERE qr_code = ? ");
			$stmt->bind_param("s",$qr_code);
            $stmt->execute(); 
			$stmt->bind_result($attended);			 
            $tickets = array(); 
            while($stmt->fetch()){ 
                $ticket = array();                  
				$ticket['attended'] = $attended; 
                array_push($tickets, $ticket);
			}             
			return $tickets; 
		 
		}

		
		public function getevents(){
			$stmt = $this->con->prepare("SELECT id,event_code FROM tic_events");	
			$stmt->execute();
			$stmt->bind_result( $id, $event_code);				 		 
			$events = array();              
                 while ($stmt->fetch()) {
					 $event = array();
					 $event['id'] = $id;
					 $event['event_code'] = $event_code; 
					 array_push($events, $event);					
					}					 
            return $events;
		}


		public function getevent($event_code){
			$stmt = $this->con->prepare("SELECT event_name FROM tic_events WHERE event_code =?");			 
			$stmt->bind_param("s",$event_code);
			$stmt->execute();
			$stmt->bind_result( $event_name);				 		 
			$tickets = array();              
                 while ($stmt->fetch()) {
                     $ticket = array();
					 $ticket['event_name'] = $event_name; 
					 array_push($tickets, $ticket);
					
					}		  
				 
				 
            return $tickets;
		}

		public function getTicketType($event_code){
			$stmt = $this->con->prepare("SELECT ticket_type,no_of_tickets,ticket_price FROM tic_ticket_types WHERE event_code =?");	
			$stmt->bind_param("s",$event_code);			 
			$stmt->execute();
			$stmt->bind_result($ticket_type,$no_of_tickets,$ticket_price);				 		 
			$tickets = array();              
                 while ($stmt->fetch()) {
                     $ticket = array();
					 $ticket['ticket_type'] = $ticket_type; 
					 $ticket['no_of_tickets'] = $no_of_tickets; 
					 $ticket['ticket_price'] = $ticket_price; 					 

					 array_push($tickets, $ticket);					
					}		 
				 
            return $tickets;
		}

		
		public function getClientName($event_code){
			$stmt = $this->con->prepare("SELECT ticket_type,no_of_tickets,ticket_price FROM tic_ticket_types WHERE event_code =?");	
			$stmt->bind_param("s",$event_code);			 
			$stmt->execute();
			$stmt->bind_result($ticket_type,$no_of_tickets,$ticket_price);				 		 
			$tickets = array();              
                 while ($stmt->fetch()) {
                     $ticket = array();
					 $ticket['ticket_type'] = $ticket_type; 
					 $ticket['no_of_tickets'] = $no_of_tickets; 
					 $ticket['ticket_price'] = $ticket_price; 					 

					 array_push($tickets, $ticket);					
					}		 
				 
            return $tickets;
		}


      
		    
		public function getAllUnconfirmedTickets($event_code){			 
			$stmt = $this->con->prepare("SELECT * FROM tic_tickets WHERE attended = '0' AND event_code=? ");
			$stmt->bind_param("s",$event_code);		 
			$stmt->execute();
			$stmt->store_result();  		 
			return $stmt->num_rows;
			  
		}

		public function getAllconfirmedTickets($event_code){			 
			$stmt = $this->con->prepare("SELECT * FROM tic_tickets WHERE attended = '1' AND event_code=? ");
			$stmt->bind_param("s",$event_code);		 
			$stmt->execute();
			$stmt->store_result();  		 
			return $stmt->num_rows;
			  
		}
	  
		public function updateTicket($qr_code){
            $stmt = $this->con->prepare("UPDATE tic_tickets SET attended = '1' WHERE qr_code = ?");
            $stmt->bind_param("s",$qr_code);
            if($stmt->execute())
                return "confirmed"; 
            return "not confirmed"; 
        }


		
		public function updateTicketByCode($ticket_code){
            $stmt = $this->con->prepare("UPDATE tic_tickets SET attended = '1' WHERE ticket_code = ?");
            $stmt->bind_param("s",$ticket_code);
            if($stmt->execute())
                return "confirmed"; 
            return "not confirmed"; 
        }





		public function geteventsNames(){
			$stmt = $this->con->prepare("SELECT id,event_name FROM tic_events");	
			$stmt->execute();
			$stmt->bind_result( $id, $event_code);				 		 
			$events = array();              
                 while ($stmt->fetch()) {
					 $event = array();
					 $event['id'] = $id;
					 $event['event_code'] = $event_code; 
					 array_push($events, $event);					
					}					 
            return $events;
		}


		public function getTicketTypeX(){
			$stmt = $this->con->prepare("SELECT id,event_code, ticket_type,available_tickets,ticket_price FROM tic_ticket_types ");	
			$stmt->execute();
			$stmt->bind_result($id,$event_code,$ticket_type,$available_tickets,$ticket_price);				 		 
			$tickets = array();              
                 while ($stmt->fetch()) {
					 $ticket = array();
					 $ticket['id'] = $id; 
					 $ticket['ticket_type'] = $ticket_type; 
					 $ticket['available_tickets'] = $available_tickets; 
					 $ticket['ticket_price'] = $ticket_price; 	
					 $ticket['event_code'] = $event_code; 
					 array_push($tickets, $ticket);					
					}		 
				return $tickets;
		}




        public function makeSales($event, $ticket_type, $phone,$email,$code){
             
                $stmt = $this->con->prepare("INSERT INTO `tic_mobile_sales` (`id`, `event`, `ticket_type`, `phone`,`email`,`code`) VALUES (NULL,?,?,?,?,?);");
                $stmt->bind_param("sssss",$event,$ticket_type,$phone,$email,$code); 
                if($stmt->execute()){
                    return "SuccessFul"; 
                }else{
                    return "Failed!!"; 
                }
            
        }
 
	}