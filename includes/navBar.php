<div class="top-navbar">
    <div class="logo-container">
        <a href="../pages/index.php">
            <img src="../assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="../pages/index.php">Home</a></li>
        <li><a href="../pages/shows.php">TV Shows</a></li>
        <li><a href="../pages/movies.php">Movies</a></li>
    </ul>
    <div class="right-items-container">
        <a href="search.php">
            <i class="fa-solid fa-magnifying-glass"></i>Search
        </a>
        <a href="profile.php">
            <i class="fa-solid fa-user"></i><?php echo $userLoggedIn;?>
        </a>
        <a href="../backend/logoutBackend.php" class="logout-btn">
            LOG OUT
        </a>
    </div>
</div>