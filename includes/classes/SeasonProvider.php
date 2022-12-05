<?php

class SeasonProvider {
    private $conn, $username;

    public function __construct($con, $username){
        $this -> conn = $con;
        $this -> username = $username;
    }

    public function createSeason($entity){
        // Get the list of seasons of this entity
        $seasons = $entity->getSeasons();

        if($seasons == null){
            return;
        }

        $seasonsHTML = "";
        foreach ($seasons as $season){
            $seasonNumber = $season->getSeasonNumber();

            $videosHTML = "";
            $videos = $season->getVideos();

            foreach ($videos as $video){
                $videosHTML .= $this->createVideoSquare($video);
            }

            $seasonsHTML .= "<div class='season'>
                                <h3> Season $seasonNumber</h3>
                                <div class='entities'>
                                    $videosHTML
                                </div>
                            </div>";
        }
        return $seasonsHTML;
    }

    private function createVideoSquare ($video){
        $id = $video->getId();
        $title = $video->getTitle();
        $thumbnail = $video->getThumbnail();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();
        $haveSeen = $video->haveSeenMovie($this->username);
        $iconSeen = "";
        if($haveSeen){
            $iconSeen = "<div class='seen-container'><i class='fa-solid fa-circle-check seen-icon'></i><p class='seen-text'>Watched<p></div>";
        }

        return "<a class='watch-link' href='watch.php?id=$id'>
                    <div class='episode-container'>
                        <div class='contents'>
                            <img src='../$thumbnail'>
                            <div class='video-info'>
                                <h4>$episodeNumber. $title </h4>
                                <p>$description</p>
                            </div>
                            $iconSeen
                        </div>
                    </div>
                </a>";
    }
}

?>