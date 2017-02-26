<?php
  class Database{

    //The connection of the databaseName
    //This is used so that the connection isn't redone every time a connection is attempted
    protected static $connection;

    /*
     *  This function connects to the database
     *  if the database had already been connected to, another connection isn't made
     */
    public function connect(){
      if(!isset(self::$connection)){
        $config = parse_ini_file('config.ini');
        self::$connection = new mysqli($config['connectionURL'], $config['username'], $config['password'], $config['databaseName']);
      }elseif(self::$connection === false){
        //TODO
        return false;
      }
      return self::$connection;
    }

    /*
     *  This function makes a query into the database
     *  NOT SAFE
     */
    public function query($query){
      $connection = $this -> connect();
      return $connection -> query($query);
    }

    /*
     *  This function returns a query call as an array for easy data access
     *  NOT SAFE
     */
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

    /*
     *  Turns any string into a safe string to enter into the database
     */
    public function quote($value){
      $connection = $this -> connect();
      return "'" . $connection -> real_escape_string($value) . "'";
    }

  }

?>
