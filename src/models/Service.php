<?php
  class Service {

    public $id;
    public $name;

    public function __construct($id, $name) {
      $this->id    = $id;
      $this->name  = $name;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM services ORDER BY id');

      foreach($req->fetchAll() as $service) {
        $list[] = new Service($service['id'], $service['name']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM services WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $service = $req->fetch();

      return new Service($service['id'], $service['name']);
    }
  }
?>