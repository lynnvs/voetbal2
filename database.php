<?php

class database{
    private $host;
    private $user;
    private $password;
    private $database;
    private $db;

    function __construct(){
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->database = 'tennis';

        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->db = new PDO($dsn, $this->user, $this->password, $options);
            //echo "connected";
        }catch(PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function select($sql, $placeholders = []){
        $stmt = $this->db->prepare($sql);
        $stmt->execute($placeholders);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($result)){
            return $result;
        }return;
    }

    public function insert($statement, $placeholders, $location=NULL){
        try{
            print_r($statement);
            print_r($placeholders);
            print_r($location);

            $this->db->beginTransaction();

            $stmt = $this->db->prepare($statement);
            $stmt->execute($placeholders);

            $this->db->commit();

            if(!is_null($location)){
                header("location: $location.php");
            }else{
                return $this->db->lastInsertID();
            }
        }catch(PDOException $e){
            $this->db->rollback();
            throw $e;
        }
    }

    public function update_or_delete($sql, $placeholders, $location=[]){
        try{
            $stmt = $this->db->prepare($sql);
            if($stmt->execute($placeholders) && !empty($location)){
                header("location: $location.php");
            }
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }
}


?>