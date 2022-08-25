<?php

Class Database 
{
    /** Instance de PDO */
    private $_PDO;

    /** Instance de Database */
    private static $_instance = null;



    private function __construct()
    {
        try
        {
        $options=
        [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_EMULATE_PREPARES => false 
        
        ];
          
        $this->_PDO=new PDO('mysql:host=localhost;dbname=jason','root','', $options);
        

        }
        catch(PDOException $e)
        {

            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {  
        if(is_null(self::$_instance))
            self::$_instance = new Database();

        return self::$_instance;
    }

    public function request(string $sql,array $fields)
    {

        $req= $this->_PDO->prepare($sql);
        $req->execute($fields);
        $result=$req->fetch(PDO::FETCH_ASSOC);
        $req->closecursor();
        return $result;
    }

    public function execute(string $sql,array $fields)
    {

        $req= $this->_PDO->prepare($sql);
        $req->execute($fields);
        return $req;
    }

}