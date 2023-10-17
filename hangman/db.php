<?php
class Database
{

    private $dsn = "mysql:host=localhost; dbname=hangman";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo 'Connection Failed' . $e->getMessage();
        }
    }

    public  function registerPlayer($username, $password, $name){
        $sql = "INSERT INTO players (username, password, name, score) VALUES (:username, :password, :name , 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password, 'name' => $name]);
        return true;
    }
    public function findUserByUsername($username){
        $sql = "SELECT username FROM players WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function loginPlayer($username, $password){

        try {
            $sql = "SELECT * FROM players WHERE username = :username";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['username' => $username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result && password_verify($password, $result['password'])){
                return $result;
            }
            return false;

        } catch (PDOException $e) {
            // Handle any errors that occurred during the database query
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getWords($difficulty) {
        $sql = "SELECT * FROM words WHERE level = :difficulty ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['difficulty' => $difficulty]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }
    public function updateScore($score, $username){
        $sql = "UPDATE players SET score = :score WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['score'=>$score, 'username'=>$username]);
        return true;
    }
    public function getScore($username){
        $sql = "SELECT score FROM players WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetchColumn();
        return $result;
    }
    public function getPlayers(){
        $sql = "SELECT * FROM players ORDER BY score DESC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}

?>