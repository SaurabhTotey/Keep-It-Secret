<?php
  class Database{

    protected static $connection;

    public function connect(){
      if(!isset(self::$connection)){
        $config = parse_ini_file('../config.ini');
        self::$connection = new mysqli($config['connectionURL'], $config['username'], $config['password'], $config['databaseName']);
      }elseif(self::$connection === false){
        //TODO
        return false;
      }
      return self::$connection;
    }

    public function query($query){
      $connection = $this -> connect();
      return $connection -> query($query);
    }

    public function select($query){
      $rows = array();
      $result = $this -> query($query);
      if($result === false){
        return false;
      }
      while ($row = $result -> fetch_assoc()){
        $rows[] = $row;
      }
      return $rows;
    }

    public function error(){
      $connection = $this -> connect();
      return $connection -> error;
    }

    public function quote($value){
      $connection = $this -> connect();
      return "'" . $connection -> real_escape_string($value) . "'";
    }

  }

  $database = new Database();
  $database -> connect();

  if(isset($_POST["publicKey"]) && isset($_POST["privateKey"])){
    $keys = array($_POST["publicKey"], $_POST["privateKey"]);
    $result = $database -> query("INSERT INTO userKeys (publicKey, privateKey, forceExpire) VALUES (" . $database -> quote($keys[0]) . ", " . $database -> quote($keys[1]) . ", FALSE);");
  }
?>
