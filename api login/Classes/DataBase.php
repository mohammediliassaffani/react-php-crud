<?php

    class DataBase{

        private $db_host = 'localhost';
        private $db_name = 'react_php_crud';
        private $db_username = 'root';
        private $db_password = 'iliass1@';

        public function Connection(){
            try{
                $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }catch(PDOException $ex){
                echo "Connection Error ! ".$ex->getMessage();
                exit;
            }
        }
    }

?>