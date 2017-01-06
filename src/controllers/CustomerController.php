<?php
  require_once('models/Customer.php');
  require_once('models/Service.php');
  require_once('models/Customertype.php');

  class CustomerController {
    //this function will bring all the data necessary for the view and show the view 
    public function index() {
      $services = Service::all();
      $customers = Customer::all();
      $customertypes = Customertype::all();
      require_once('views/layout.php');
    }
    
    //this function will prepare the data for an insert in the DB
    public function add() {
        $lastQueueTime = Customer::getLastCustomerQueueTime();
        $date = new DateTime($lastQueueTime);
        //add 15 min to the last customer queue time
        $date->add(new DateInterval('PT0H15M'));
        $now = new DateTime();
        //check if the date is in the past, and if so, set the queuetime as now
        if ($date < $now) {
            $date = $now;
        } 
        $newTime = date ("Y-m-d H:i:s", $date->getTimestamp());
        $firstname = $lastName = $title = "";
        if ($_POST['customertype'] == Customertype::CITIZEN) {
            $firstname = $_POST['firstname'];
            $lastName = $_POST['lastname'];
            $title = $_POST['title'];
        } elseif($_POST['customertype'] == Customertype::ORGANIZATION) {
            $firstname = $_POST['organizationname'];  
        }  
        Customer::add($title, $firstname, $lastName, $_POST['service'], $_POST['customertype'], $newTime); 
        $this->index();
        
    }
    
    public function error()
    {
        require_once('views/error.php');
    }
  }
?>

