<?php
class User {
    private $conn, $sqlData;

    public function __construct($con, $username)
    {
        $this->conn = $con;
        $sql="SELECT * FROM users WHERE username = '$username'";
        $query = mysqli_query($con, $sql);

        while($row = mysqli_fetch_assoc($query)){
            $this->sqlData = $row;
        }
    }

    public function getFirstName() {
        return $this->sqlData["firstName"];
    }

    public function getLastName() {
        return $this->sqlData["lastName"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }
}
?>