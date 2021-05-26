<?php
class ORM
{
    private $con = null;
    private $query = null;
    public function __construct($con,$query)
    {
        $this->con = $con;
        $this->query = $query;
    }
    static function query($con)
    {
        return new Query($con);
    }    
    public function execute(){
        try{
            return $this->query->execute();            
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    public function fetchAll($type){        
        try{                 
            return $this->query->fetchAll($type);            
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}
