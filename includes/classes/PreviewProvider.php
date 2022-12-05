<?php
    require_once("Entity.php");
    require_once("EntityProvider.php");

    class PreviewProvider {

        private $conn, $username;
        // Create a constructor
        public function __construct($con, $username) {
            $this -> conn = $con;
            $this -> username = $username;
        }

        public function createPreviewVideo($entity) { // This function takes an entity object as the parameter
            if($entity == null){ // If no entity object is assigned, create a random entity object to preview
                $entity = $this -> getRandomEntity();
            }

            // Get the name, id, preview, thumbnail of the entity
            $name = $entity->getEntityName();
            $id = $entity->getEntityID();
            $preview = $entity->getEntityPreview();
            $thumbnail = $entity->getEntityThumbnail();

            // Add the subtitle


            $videoId = VideoProvider::getEntityVideoForUser($this->conn, $id, $this->username);
            $video = new Video($this->conn, $videoId);

            $isInProgress = $video->isInProgress($this->username);
            $playBtnText = $isInProgress ? "Continue Watching" : "Play";
            $SeasonAndEpisode = $video->getSeasonAndEpisode();

            if($video->getIsMovie()) // Check if this video is a movie
            {
                $subTitle = "";
            } else {
                $subTitle = "<h4 class='preview-subtitle'>$SeasonAndEpisode</h4>";
            }
            

            return "<div class='preview-container'>
                        <img src='../$thumbnail' class='preview-image' hidden>
                        <video autoplay muted class='preview-video' onended='previewVideoEnded()'>
                            <source src='../$preview' type='video/mp4'>
                        </video>
                        <div class='preview-overlay'>
                            
                            
                            <div class='main-details'>
                                <h3 class='overlay-title'>$name</h3>
                                $subTitle
                                <div class='buttons'>
                                    <button onclick='playNextVideo($videoId)'><i class='fa-solid fa-play'></i>$playBtnText</button>
                                    <button class='mute-button' onClick='toggleVolume()'><i class='fa-solid fa-volume-xmark'></i>Volume</button>
                                </div>
                            </div>
                        </div>               
                    </div>";
            
        }

        // Get a random entity name
        private function getRandomEntity(){
            // Call the function to get the entity from Entity Provider class
            $entity = EntityProvider::getEntities($this->conn, null, 1); // Limit only one output is shown
            return $entity[0];
        }

        //Get the Entity show in the category row
        public function createEntityPreviewSquare($entity) {
            $id = $entity -> getEntityID();
            $thumbnail = $entity -> getEntityThumbnail();
            $name = $entity -> getEntityname();

            return "<a href='entity.php?id=$id'>
                        <div class='preview-container small'>
                            <img src='../$thumbnail' title='$name'>
                        </div>
                    </a>";
        }

        public function createTVShowPreviewVideo(){
            $entityArray = EntityProvider::getTVShowsEntities($this->conn, null, 1);

            if(sizeof($entityArray) == 0){
                ErrorMessage::showError("No TV shows to display");
            }

            return $this->createPreviewVideo($entityArray[0]);
        }

        public function createMoviePreviewVideo(){
            $entityArray = EntityProvider::getMovieEntities($this->conn, null, 1);

            if(sizeof($entityArray) == 0){
                ErrorMessage::showError("No Movies to display");
            }

            return $this->createPreviewVideo($entityArray[0]);
        }

        public function createCategoryPreviewVideo($categoryId){
            $entityArray = EntityProvider::getEntities($this->conn, $categoryId, 1);

            if(sizeof($entityArray) == 0){
                ErrorMessage::showError("No videos to display");
            }

            return $this->createPreviewVideo($entityArray[0]);
        }
    }

?>