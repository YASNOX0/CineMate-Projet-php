<?php
require_once('Database/CRUDS/fUsersCrud.php');
require_once('Database/CRUDS/fMoviesCrud.php');

session_start();

if (isset($_SESSION['state'])) {
    $authentificatedUser = getUserByUsername($_SESSION['username']);
    if (isset($_POST['addMovie']) && $_POST['addMovie'] == 'true') {
        $movieId = $_POST['movieId'];
        $movieTitle = $_POST['movieTitle'];
        $moviePosterPath = $_POST['moviePosterPath'];
        $movieRating = $_POST['movieVoteAverage'];
        $movieReleaseDate = $_POST['movieReleaseDate'];
        $movieOverview = $_POST['movieOverview'];

        $movie = new Movie($movieId, $moviePosterPath, $movieTitle, $movieOverview, $movieReleaseDate, "testGrs", $movieRating);
        $authentificatedUser->addMovieToWatchlist($movie);
        echo "Movie added successfully!";
    }

    if (isset($_POST['removeMovie']) && $_POST['removeMovie'] == 'true') {
        $authentificatedUser->removeMovieFromWatchlist($_POST['movieId']);
    }
} else {
    header("Location: log_reg.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user.css">
    <script src="js/main.js" defer></script>
</head>

<body>
    <header>
        <a href="#" class="logo">
            <i class='bx bxs-movie'></i>CineMate
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!--Menu-->
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php">Movies</a></li>
            <li><a href="index.php">Coming</a></li>
            <li><a href="index.php">Newsletter</a></li>
        </ul>
        <a href="signOut.php" class="btn">
            Sign Out
        </a>
        
    </header>

    <!-- Nouvelle section -->
    <section class="user-info">
        <h2>Information</h2>
        <div>
            <!-- Avatar à gauche -->
            <div id="avatar">
                <img src="<?php echo $authentificatedUser->getAvatarUrl(); ?>" alt="Avatar">
            </div>
            <!-- Infos de l'utilisateur à droite -->
            <div id="info">
                <h3>Name: <span id="user-name"><?php echo $authentificatedUser->getUsername(); ?></span></h3>
                <h3>Email: <span id="user-email"><?php echo $authentificatedUser->getEmail(); ?></span></h3>
                <h3>Age: <span id="user-age"><?php echo $authentificatedUser->getAge(); ?></span></h3>
            </div>
        </div>
    </section>
    <section class="movies">
        <h2 class="heading">Watch List</h2>
        <!-- Movies Conatiner-->
        <div class="movies-container">
            <!--BOX-->

            <?php
            $moviesID = $authentificatedUser->getWatchlist();
            for ($i = 0; $i < count($moviesID); $i++) {
                $movie = getMovieById($moviesID[$i]);
                if (isset($movie)) {
            ?>
                    <div class="swiper-slide box">
                        <div class="box-img">
                            <img src="https://image.tmdb.org/t/p/w500/<?php echo $movie->getPosterURI(); ?>" alt="<?php echo $movie->getTitle(); ?>">
                        </div>
                        <div class="overlay">
                            <div class="read-more">
                                <p><?php echo substr($movie->getOverview(), 0, 50) . "..." ?></p>
                                <a class="btn" href="/MoviesProject/movieInfo.php?movieId=<?php echo $movie->getMovieID(); ?>&movieTitle=<?php echo $movie->getTitle(); ?>&moviePosterPath=<?php echo $movie->getPosterURI(); ?>&movieOverview=<?php echo $movie->getOverview(); ?>&movieVoteAverage=<?php echo $movie->getRating(); ?>&movieReleaseDate=<?php echo $movie->getReleaseDate(); ?>">Book in</a>
                                <button id="toggleButton" onclick="removeMovieFromWatchList(<?php echo $movie->getMovieID(); ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>

        </div>
    </section>
    <!-- NewsLetter -->
    <section class="newsletter" id="newsletter">
        <h2>Subscribe To Get <br>Newsletter</h2>
        <form action="">
            <input type="email" class="email" placeholder="Enter Email ..." required>
            <input type="submit" value="Subscribe" class="btn">
        </form>
    </section>
    <!-- Footer -->
    <section class="footer">
        <a href="#" class="logo">
            <i class='bx bxs-movie'></i>CineMate
        </a>
        <div class="social">
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-tiktok'></i></a>
        </div>
    </section>
    <!-- Copyright -->
    <div class="copyright">
        <p>&#169; CineMate 2023</p>
    </div>

    <script>
        function removeMovieFromWatchList(movieId) {
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `movieId=${movieId}&removeMovie=true`,
            };

            fetch('userInfos.php', options)
                .then(response => response.text())
                .then(message => {
                    location.reload();
                    console.log(message);
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>