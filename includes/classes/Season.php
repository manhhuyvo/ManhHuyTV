<?php

class Season {

    private $seasonNumber, $videos;

    public function __construct($season, $videoList){
        $this->seasonNumber = $season;
        $this->videos = $videoList;
    }

    public function getSeasonNumber() {
        return $this->seasonNumber;
    }

    public function getVideos() {
        return $this->videos;
    }
}

?>