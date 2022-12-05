<?php
    $hideNav = false;
    require_once("../includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::showError("No ID has been passed into the page..."); // Stop executing anymore codes below this line
    }
    
    // Current video to be played
    $video = new Video($conn, $_GET["id"]);
    $video->incrementViews();

    // Create the next uploaded video
    $upNextVideo = VideoProvider::getUpNext($conn, $video);
?>
<div class="watch-container">
    <div class="video-controls watch-nav">
        <button onclick="goBack(<?php echo $video->getEntityId();?>)" class="transparent"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="watch-nav-title">
            <h1><?php echo $video->getTitle();?></h1>
            <h4><?php  echo $video->getSeasonAndEpisode();?></h4>
        </div>
        
    </div>

    <div class="video-controls up-next">
        <button onclick="replayVideo()" class="redo-btn"><i class="fa-solid fa-redo"></i></button>
        <div class="upNext-container">
            <h2>Up Next: </h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>
            <button class="play-next-btn" onclick="playNextVideo(<?php echo $upNextVideo->getId(); ?>)">
                <i class="fa-solid fa-play"></i> Play
            </button>
        </div>
    </div>

    <video controls autoplay>
        <source src="<?php echo '../'.$video->getFilePath(); ?>" type="video/mp4">
    </video>
</div>
<script>
    initVideo("<?php echo $video->getId();?>", "<?php echo $userLoggedIn;?>");
</script>