<?php

  class Database{

    //The connection of the database
    //This is used so that the connection isn't redone every time a connection is attempted
    protected static $connection;

    /*
     *  This function connects to the database
     *  if the database had already been connected to, another connection isn't made
     */
    public function connect(){
      if(!isset(self::$connection)){
        self::$connection = new pg_connect(getenv('DATABASE_URL'));
      }
      return self::$connection;
    }

    /*
     *  This function makes a query into the database
     *  Queries the database with the given query string, but doesn't sanitize the inputs
     */
    public function query($query){
      return $this -> connect() -> query($query);
    }

    /*
     *  This function returns a query call as an array for easy data access
     *  This doesn't escape the query
     */
    public function select($query){
      $rows = array();
      $result = $this -> query($query);
      if($result === false){
        return false;
      }
      while ($row = $result -> pg_fetch_assoc()){
        $rows[] = $row;
      }
      return $rows;
    }

    /*
     *  Turns any string into a safe string to enter into the database
     */
    public function quote($value){
      $connection = $this -> connect();
      return pg_escape_literal($value);
    }

  }

?>
