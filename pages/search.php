<?php
require_once("../includes/header.php");


?>
<div class="search-input-container">
    <input type="text" id="search-textbox" class="search-input" placeholder="Search what you are thinking of right now...">
</div>
<div class="search-results">

</div>

<script>

    var username="<?php echo $userLoggedIn; ?>";
    var timer;

    $(".search-input").keyup(function(){
        clearTimeout(timer);

        // Wait for 0.5 sec to do the request
        timer = setTimeout(function(){
            var searchValue = $(".search-input").val();

            // Make AJAX call
            if(searchValue != ""){
                $.post("../ajax/getSearchResult.php",
                {
                    search: searchValue,
                    username: username
                }, function (data){
                    $(".search-results").html(data);
                });
            } else {
                $(".search-results").html("");
            }
        }, 500);
    })
    
</script>