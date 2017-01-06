<?php
  class Customertype {

    CONST CITIZEN      = 1;
    CONST ORGANIZATION = 2;
    CONST ANONYMOUS    = 3;  
    
    public $id;
    public $type;

    public function __construct($id, $type) {
      $this->id   = $id;
      $this->type = $type;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM customertype ORDER BY id');

      foreach($req->fetchAll() as $customertype) {
        $list[] = new Customertype($customertype['id'], $customertype['type']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      //make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM customertype WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $customertype = $req->fetch();

      return new Customertype($customertype['id'], $customertype['type']);
    }
  }
?>