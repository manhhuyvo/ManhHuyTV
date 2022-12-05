// Function to toggle mute the video
function toggleVolume(){
    var isMuted = $(".preview-video").prop("muted"); // get the current mute property of the video as isMuted variable (TRUE or FALSE)
    $(".preview-video").prop("muted", !isMuted); // Change the mute property of the video to the opposite

    if(isMuted){ // Change the icon of the mute button
        $(".mute-button").find("i").attr("class","fa-solid fa-volume-high");
    } else {
        $(".mute-button").find("i").attr("class","fa-solid fa-volume-xmark");
    }
}

// Display the preview image once the video has ended
function previewVideoEnded(){
    $(".preview-video").hide();
    $(".preview-image").show();

}

// The back function for BACK buttons
function goBack(entityId){
    window.location.href = "../pages/entity.php?id="+entityId;
}

// Function to hide or show the BACK panel
function startHideTimer() {
    var timeout = null;

    // When the user moves the mouse anywhere in the page, we reset the timeout and show the watch nav
    $(document).on("mousemove", function() {
        clearTimeout(timeout);
        $(".watch-nav").fadeIn();

        // Set a new timer, after 2 secs without moving, we hide the watch nav
        timeout = setTimeout(function(){
            $(".watch-nav").fadeOut();
        }, 2000);
    });
}

// Functions to be called when the video is loaded
function initVideo(videoId, username) {
    startHideTimer();
    updateProgressTimer(videoId, username);
    resumePlaying (videoId, username);
}


function updateProgressTimer(videoId, username){
    $(".up-next").hide();
    addDuration(videoId, username);
    var timer;
    // When the video is playing, call the function inside
    $("video").on("playing", function(event){
        window.clearInterval(timer);
        timer = window.setInterval(function(){
            var progress = event.target.currentTime;
            updateProgress(videoId, username, progress);
        }, 3000);
    });

    // When the video is paused, stop updating the progress
    $("video").on("pause", function(){
        window.clearInterval(timer);
    })

    // When the video is finished playing, update finished in the database and reset the progress again
    $("video").on("ended", function(){
        setFinished(videoId, username);
        $(".up-next").fadeIn();
    })
}

function addDuration(videoId, username) {
    // Make ajax call to the addDuration
    $.post("../ajax/addDuration.php", 
        {
            videoId: videoId,
            username: username
        },
        function(data){
            if (data !== null && data !== ""){
                alert(data);
            }
        }
    );
}

// Update new progress of the video that user is watching
function updateProgress (videoId, username, progress){
    // Make ajax call to the updateDuration.php
    $.post("../ajax/updateDuration.php", 
        {
            videoId: videoId,
            username: username,
            progress: progress
        },
        function(data){
            if (data !== null && data !== ""){
                alert(data);
            }
        }
    );
}

// Update if theuser has finished watching the movie
function setFinished (videoId, username){
    // Make ajax call to the setFinished.php
    $.post("../ajax/setFinished.php", 
        {
            videoId: videoId,
            username: username
        },
        function(data){
            if (data !== null && data !== ""){
                alert(data);
            }
        }
    );
}

// Resume the video at where the user left it
function resumePlaying (videoId, username){
    // Make ajax call to the getProgress.php
    $.post("../ajax/getProgress.php", 
        {
            videoId: videoId,
            username: username
        },
        function(data){

            if(isNaN(data)){ // If data is Not a Number (isNaN)
                alert (data);
                return;
            } else {
                $("video").on("canplay", function(){
                    this.currentTime = data;
                    $("video").off("canplay");
                    
                    $(".up-next").hide();
                })
            }
        }
    );
}

// Replay button
function replayVideo() {
    $(".up-next").hide();
    $("video")[0].currentTime = 0;
    $("video").trigger("play");
}

function playNextVideo(videoId) {
    // navigate to the watch page with the videoId
    window.location.href = "watch.php?id=" + videoId;
}