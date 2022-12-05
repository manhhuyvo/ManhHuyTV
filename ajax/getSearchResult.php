<?php

require_once("../includes/config/config.php");
require_once("../includes/classes/SearchResultProvider.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");
require_once("../includes/classes/PreviewProvider.php");

if(isset($_POST["search"]) && isset($_POST["username"])){
    $search = $_POST["search"];
    $username = $_POST["username"];

    $searchResultProvider = new SearchResultProvider($conn, $username);
    echo "<h1 class='search-header'>Your search result for: ''$search''</h1>".$searchResultProvider->getSearchResult($search);
} else {
    echo "No term or username have been added to the file";
}

?>