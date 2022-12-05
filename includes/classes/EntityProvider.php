<?php
    require_once("../includes/classes/Entity.php");

    class EntityProvider {

        // Get the list of entities base on the category ID (if we need a specific output) or just randomly output $limit number of entities
        public static function getEntities($conn, $categoryID, $limit){
            $sql = "SELECT * FROM entities "; // Make sure to add a space in here

            if($categoryID != null) { // If category ID is assigned to the function, then generate the sql statement as below
                $sql = $sql . "WHERE categoryId = $categoryID";
            }

            $sql = $sql . " ORDER BY RAND() LIMIT $limit"; // Assign the limit for random call
            // IMPORTANT: Always be mindful with the space between the SQL statement
            
            $result = mysqli_query($conn, $sql); // Execute the query

            $output = array(); // Create an array to store the output of the SQL

            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $output[] = new Entity($conn, $row); // Assign each row into the output array
                }
            }
            return $output; // Return the list of entities
        }

        public static function getTVShowsEntities($conn, $categoryID, $limit){
            $sql = "SELECT DISTINCT (entities.id) FROM entities
                    INNER JOIN videos on entities.id = videos.entityId
                    WHERE videos.isMovie = 0 "; // Make sure to add a space in here

            if($categoryID != null) { // If category ID is assigned to the function, then generate the sql statement as below
                $sql = $sql . "AND categoryId = $categoryID";
            }

            $sql = $sql . " ORDER BY RAND() LIMIT $limit"; // Assign the limit for random call
            // IMPORTANT: Always be mindful with the space between the SQL statement
            
            $result = mysqli_query($conn, $sql); // Execute the query

            $output = array(); // Create an array to store the output of the SQL

            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $output[] = new Entity($conn, $row["id"]); // Assign each row into the output array
                }
            }
            return $output; // Return the list of entities
        }

        public static function getMovieEntities($conn, $categoryID, $limit){
            $sql = "SELECT DISTINCT (entities.id) FROM entities
                    INNER JOIN videos on entities.id = videos.entityId
                    WHERE videos.isMovie = 1 "; // Make sure to add a space in here

            if($categoryID != null) { // If category ID is assigned to the function, then generate the sql statement as below
                $sql = $sql . "AND categoryId = $categoryID";
            }

            $sql = $sql . " ORDER BY RAND() LIMIT $limit"; // Assign the limit for random call
            // IMPORTANT: Always be mindful with the space between the SQL statement
            
            $result = mysqli_query($conn, $sql); // Execute the query

            $output = array(); // Create an array to store the output of the SQL

            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $output[] = new Entity($conn, $row["id"]); // Assign each row into the output array
                }
            }
            return $output; // Return the list of entities
        }

        public static function getSearchEntities($conn, $searchValue, $limit){
            $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', '$searchValue', '%') LIMIT $limit"; // Make sure to add a space in here
            
            $result = mysqli_query($conn, $sql); // Execute the query

            $output = array(); // Create an array to store the output of the SQL

            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $output[] = new Entity($conn, $row); // Assign each row into the output array
                }
            }
            return $output; // Return the list of entities
        }
    }

?>