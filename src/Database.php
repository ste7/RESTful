<?php

class Database extends PDO{
    private $pdo;

    public function __construct(){
        try{
            $this->pdo = new PDO('mysql:host=localhost;dbname=restfuldb', 'root', '');
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function get($id){
        $stm = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stm->execute(array(
            ':id' => $id
        ));
        $results = $stm->fetchAll(PDO::FETCH_OBJ);
        $error = '{"error": {"message": "nothing found"}}';

        return $results ? json_encode($results) : $error;
    }

    public function create($first_name, $last_name, $city){
        $stm = $this->pdo->prepare('INSERT INTO users (first_name, last_name, city) VALUES (:first_name, :last_name, :city)');
        try{
            $stm->execute(array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'city' => $city,
            ));

            echo '{"message:": "success"}';
        } catch(PDOException $e){
            echo '{"error": ' . $e->getMessage() . '}';
        }
    }
    
    public function delete($id){
        echo $id;
        $stm = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        try{
            $stm->execute(array(
                'id' => $id,
            ));

            echo '{"message": "success"}';
        } catch(PDOException $e){
            echo '{"error": ' . $e->getMessage() . '}';
        }
    }
    
    public function update($first_name, $last_name, $city, $id){
        $stm = $this->pdo->prepare("UPDATE users SET
                                                     first_name = :first_name,
                                                     last_name = :last_name,
                                                     city = :city WHERE id = :id");
        try{
            $stm->execute(array(
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':city' => $city,
                ':id' => $id
            ));

            echo '{"message": "success"}';
        } catch(PDOException $e){
            echo '{"error": ' . $e->getMessage() . '}';
        }
    }
}