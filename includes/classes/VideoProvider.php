<?php

class VideoProvider {

    public static function getUpNext ($conn, $currentVideo){
        // These functions come from the Video Class
        $videoId = $currentVideo->getId();
        $entityId = $currentVideo->getEntityId();
        $querySeason = $currentVideo->getSeasonNumber();
        $queryEpisode = $currentVideo->getEpisodeNumber();

        // return $videoId . " " . $entityId . " " . $querySeason . " " . $queryEpisode;
        $sql = "SELECT * FROM videos WHERE entityId = $entityId AND id != $videoId
                AND (
                    (season = $querySeason AND episode > $queryEpisode) OR season > $querySeason
                )
                ORDER BY season, episode ASC LIMIT 1";
        $result = mysqli_query($conn, $sql);
    
        // if we have no episode left of the current entity, then replace $sql and $result with the value below
        if(mysqli_num_rows($result) == 0){
            $sql = "SELECT * FROM videos
                    WHERE season <= 1 AND episode <= 1
                    AND id != $videoId
                    ORDER BY views DESC LIMIT 1";

            $result = mysqli_query($conn, $sql);
            
        }

        while ($row = mysqli_fetch_assoc($result)){
            return new Video($conn, $row); // Return the Video object
        }

    }

    // Get the next video when user click the PLAY button at preview
    public static function getEntityVideoForUser($conn, $entityId, $username){
        $sql = "SELECT * FROM videoprogress INNER JOIN videos
        ON videoprogress.videoId = videos.id
        WHERE videos.entityId = $entityId
        AND videoprogress.username = '$username'
        ORDER BY videoprogress.dateModified LIMIT 1;";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 0) { // If user has not watched this movie before
            $sql = "SELECT * FROM videos WHERE entityId = $entityId ORDER BY season, episode ASC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)){
                return $row["id"];
            }
        } else { // User has watched this movie
            while ($row = mysqli_fetch_assoc($result)){
                return $row["videoId"];
            }
        }
    }
}

?>