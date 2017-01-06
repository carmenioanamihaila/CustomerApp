<?php
  class Customer {
      
    public $id;
    public $title;
    public $firstname;
    public $lastname;
    public $customertype_id;
    public $queuetime;
    public $service_id;

    public function __construct($id, $title, $firstname, $lastname, $customertype_id, $queuetime, $service_id) {
      $this->id               = $id;
      $this->title            = $title;
      $this->firstname        = $firstname;
      $this->lastname         = $lastname;
      $this->customertype_id  = $customertype_id;
      $this->queuetime        = $queuetime;
      $this->service_id       = $service_id;
    }
    
    public static function getLastCustomerQueueTime() {
      $db = Db::getInstance();
      $req = $db->query('SELECT queuetime FROM customers ORDER BY queuetime DESC LIMIT 1');
      $customer = $req->fetch(); 
      if ($customer) {
        return $customer['queuetime'];
      } else {
        return date("Y-m-d H:i:s"); 
      }
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM customers ORDER BY id');

      foreach($req->fetchAll() as $customer) {
        $list[] = new Customer($customer['id'], $customer['title'], $customer['firstname'], $customer['lastname'], 
                               $customer['customertype_id'], $customer['queuetime'], $customer['service_id']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      //make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM customers WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $customer = $req->fetch();

      return new Customer($customer['id'], $customer['title'], $customer['firstname'], $customer['lastname'], 
                          $customer['customertype_id'], $customer['queuetime'], $customer['service_id']);
    }
    
    public static function add($title, $firstname, $lastname, $serviceId, $customerId, $newTime) {
      $db = Db::getInstance();
      $req = $db->prepare("INSERT INTO customers(title, firstname, lastname, service_id, customertype_id, queueTime) "
                        . "VALUES ('$title', '$firstname', '$lastname', $serviceId, $customerId, '$newTime')");
      $req->execute();
    }
    
    public function getServiceName()
    {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT s.name FROM customers c INNER JOIN services s ON c.service_id=s.id WHERE c.id = :id');
      $req->execute(array('id' => $this->id));
      $service = $req->fetch();

      return $service['name'];
    }
    
    public function getCustomerType()
    {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT ct.type FROM customers c INNER JOIN customertype ct ON c.customertype_id=ct.id WHERE c.id = :id');
      $req->execute(array('id' => $this->id));
      $customertype = $req->fetch();

      return $customertype['type'];
    }
    
    public function getName()
    {
        switch($this->customertype_id)
        {
            case Customertype::CITIZEN:
                return $this->title . " " . $this->firstname . " " . $this->lastname;
            case Customertype::ORGANIZATION:
                return $this->firstname;
            case Customertype::ANONYMOUS:
                return "Anonymous";
        }
    }
    
    public function getQueueTime()
    {
        $date = new DateTime($this->queuetime);
        return $date->format('H:i');
    }
  }
?>