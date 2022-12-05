<?php

class CategoryContainers {
    private $conn, $username;

    public function __construct($con, $username){
        $this -> conn = $con;
        $this -> username = $username;
    }

    public function showAllCategory (){
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($this->conn, $sql);

        $html = "<div class='preview-categories'>";

        // In this function, we have received the list of all categories such as Action, thriller,... Each of them is a row
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            // and then for each category, we call the function to get the category content
                $html = $html . $this -> getCategoryContent($row, null, true, true); // Append each row of the category into the $html
                //$html = $html . $row["id"] . "<br>";
            }
        }

        return $html . "</div>"; // Return this $html variable eventually
    }

    public function showCategory($categoryID, $title = null){ // we can not specify $title if we dont need to
        $sql = "SELECT * FROM categories WHERE id = $categoryID";
        $result = mysqli_query($this->conn, $sql);

        $html = "<div class='preview-categories no-scroll'>";

        // In this function, we have received the list of all categories such as Action, thriller,... Each of them is a row
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            // and then for each category, we call the function to get the category content
                $html = $html . $this -> getCategoryContent($row, $title, true, true); // Append each row of the category into the $html
                //$html = $html . $row["id"] . "<br>";
            }
        }

        return $html . "</div>"; // Return this $html variable eventually
    }

    // Get the category content base on the following parameters
    /* 
    $sqlOutput: the categories that we have output from the SQL query in showAllCategory()
    $title: the category name that can be assigned from the SQL query output above or a specific value that we give in
    $tvshows: boolean parameter which declares if we want to show the TV shows
    $movies: boolean parameter which declares if we want to show the Movies
    When $tvshows and/or $movies are TRUE, we show the type of videos accordingly (or we can show both types)
    */
    private function getCategoryContent($sqlOutput, $title, $tvShows, $movies){
        $categoryID = $sqlOutput["id"];

        if($title == null){ // If no title is assigned, we use the title from the SQL output
            $title = $sqlOutput["name"];
        }

        if ($tvShows && $movies){ // We want to show both TV Shows and Movies
            // Call the function to get entities by the according categoryID fetch from above and limit with 25 entities
            $entities = EntityProvider::getEntities($this->conn, $categoryID, 25);
        } else if ($tvShows) {
            // Get TV Shows Entities
            $entities = EntityProvider::getTVShowsEntities($this->conn, $categoryID, 25);
        } else {
            // Get Movies Entities
            $entities = EntityProvider::getMovieEntities($this->conn, $categoryID, 25);
        }

        // This if statement is to prevent showing the category that has no movies in it
        if (sizeof($entities) == 0){
            return ;
        }

        $entitiesHTML = "";

        $previewProvider = new PreviewProvider($this->conn, $this->username);

        foreach ($entities as $entity){
            $entitiesHTML = $entitiesHTML . $previewProvider->createEntityPreviewSquare($entity);
        }

        //Return the category name in the link and list of entities insde the div
        return "<div class='category'>
                    <a href='category.php?id=$categoryID'>
                        <h3>$title</h3>
                    </a>
                    <div class='entities'>".$entitiesHTML."
                    </div>
                </div>";
    }

    public function showTVShowsCategory (){
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($this->conn, $sql);

        $html = "<div class='preview-categories'>
                <h1>TV Shows</h1>";

        // In this function, we have received the list of all categories such as Action, thriller,... Each of them is a row
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            // and then for each category, we call the function to get the category content
                $html = $html . $this -> getCategoryContent($row, null, true, false); // Append each row of the category into the $html
                //$html = $html . $row["id"] . "<br>";
            }
        }

        return $html . "</div>"; // Return this $html variable eventually
    }

    public function showMovieCategory (){
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($this->conn, $sql);

        $html = "<div class='preview-categories'>
                <h1>Movies</h1>";

        // In this function, we have received the list of all categories such as Action, thriller,... Each of them is a row
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            // and then for each category, we call the function to get the category content
                $html = $html . $this -> getCategoryContent($row, null, false, true); // Append each row of the category into the $html
                //$html = $html . $row["id"] . "<br>";
            }
        }

        return $html . "</div>"; // Return this $html variable eventually
    }
}

?>