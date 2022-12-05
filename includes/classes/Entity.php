<?php

class Entity {

    private $conn, $sqlData;

    // Input can be entity ID
    public function __construct ($con, $input){
        $this -> conn = $con;

        if(is_array($input)){ // We already get the results from Preview Provider
            $this -> sqlData = $input;
        } else { // Get the entity ID as an input for the function
            $sql = "SELECT * FROM entities WHERE id = $input";

            $result = mysqli_query($this->conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $this -> sqlData = $row; // Bind the output into the input variable
                    // The result will always be ONE row only
                }
                
            }
        }
    }

    // Return the entity ID that we got from the constructor
    public function getEntityID(){
        return $this -> sqlData["id"];
    }

    public function getEntityName(){
        return $this -> sqlData["name"];
    }

    public function getEntityThumbnail(){
        return $this -> sqlData["thumbnail"];
    }

    public function getEntityPreview(){
        return $this -> sqlData["preview"];
    }

    public function getCategoryId(){
        return $this -> sqlData["categoryId"];
    }

    public function getSeasons(){
        // Create arrays to store the seasons and videos accrodingly
        $seasons = array();
        $videos = array();

        // Get the entity ID from the entity passed to this function
        $id = $this->getEntityID();

        // Choose the videos match the entity ID which are TV shows and order by the season ascending, then each episode ascending
        $sql = "SELECT * FROM videos WHERE entityId = $id AND isMovie=0 ORDER BY season, episode ASC";
        $result = mysqli_query($this->conn, $sql);

        $currentSeason = null;
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                
                // Means that this is not the first time looping through, and also when looping through a new season
                if($currentSeason != null && $currentSeason != $row["season"])
                {   
                    // Add the new element into the next available space of the array
                    $seasons[] = new Season($currentSeason, $videos); // After looping through a season, we already have a list of videos from the last season
                    $videos = array (); // Empty the videos array
                }
                $currentSeason = $row["season"]; // Set the $currentSeason to be the season that we got from the sql query
                $videos[] = new Video($this -> conn, $row); // Get the list of videos by passing $row (sqlData) to the constructor of Video class
                // store the videos of each currentSeason into the array
                // This will store only the list of videos in this season. Every time we have a new season, the Videos [] will be emtpied again

            }

            // This is for the very last season, when we exit the while loop above
            if (sizeof($videos) != 0){
                $seasons[] = new Season($currentSeason, $videos);
            }

            return $seasons; // Finally we return the array of seasons of the entity
        }
    }
}

?>