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
        self::$connection = pg_connect(getenv('DATABASE_URL'));
      }
      return self::$connection;
    }

    /*
     *  This function makes a query into the database
     *  Queries the database with the given query string, but doesn't sanitize the inputs
     */
    public function query($query){
      return pg_query($this -> connect(), $query);
    }

    /*
     *  This function returns a query call as an array of associative arrays for easy data access
     *  This doesn't escape the query
     */
    public function select($query){
      $rows = array();
      $result = $this -> query($query);
      if($result === false){
        return false;
      }
      return pg_fetch_all($result);
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
