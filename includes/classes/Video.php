<?php

class Video {
    // The constructor is similar to Entity PHP because we can choose to get the video base on the SQLdata input or base on the video ID
    private $conn, $sqlData, $entity;

    // Input can be entity ID
    public function __construct ($con, $input){
        $this -> conn = $con;

        if(is_array($input)){ // We already get the results from Preview Provider
            $this -> sqlData = $input;
        } else { // Get the entity ID as an input for the function
            $sql = "SELECT * FROM videos WHERE id = $input";

            $result = mysqli_query($this->conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $this -> sqlData = $row; // Bind the output into the input variable
                    // The result will always be ONE row only
                }
                
            }
            
        }
        $this -> entity = new Entity($this->conn, $this ->sqlData["entityId"]);
    }

    public function getId () {
        return $this -> sqlData["id"];
    }

    public function getTitle () {
        return $this -> sqlData["title"];
    }

    public function getDescription () {
        return $this -> sqlData["description"];
    }

    public function getFilePath () {
        return $this -> sqlData["filePath"];
    }

    public function getThumbnail () {
        $entityThumbnail = $this->entity->getEntityThumbnail();
        return $entityThumbnail;
    }

    public function getEpisodeNumber () {
        return $this -> sqlData["episode"];
    }
    
    public function getSeasonNumber () {
        return $this -> sqlData["season"];
    }

    public function getEntityId () {
        return $this -> sqlData["entityId"];
    }
    
    public function incrementViews() {
        $id = $this->getId();
        $sql="UPDATE videos SET views = views+1 WHERE id=$id";

        $query = mysqli_query($this->conn, $sql); 
        if ($query){
            return "Views updated successfully";
        } else {
            return "Views updated unsuccessful.";
        }
    }

    public function getSeasonAndEpisode() {
        $isMovie = $this->getIsMovie();
        if($isMovie) {
            return ;
        }

        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        return "Season $season, Episode $episode";
    }

    public function getIsMovie() {
        return $this->sqlData["isMovie"] == 1;
    }

    public function isInProgress($username){
        $videoId = $this->getId();
        $sql = "SELECT * FROM videoprogress WHERE username = '$username' AND videoId = $videoId";
        $query = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($query) == 0){
            return false;
        } else {
            return true;
        }
    }

    public function haveSeenMovie($username){
        $videoId = $this->getId();
        $sql="SELECT * FROM videoprogress WHERE username = '$username' AND videoId = $videoId AND finished = 1";
        $query = mysqli_query($this->conn, $sql);

        if(mysqli_num_rows($query) == 0){
            return false;
        } else {
            return true;
        }
    }
}

?>