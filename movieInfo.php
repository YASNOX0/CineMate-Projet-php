<?php

require_once('Models/Review.php');
require_once('Models/Movie.php');
require_once('Models/User.php');

require_once('Database/CRUDS/fUsersCrud.php');
require_once('Database/CRUDS/fMoviesCrud.php');
require_once('Database/CRUDS/fReviewCRUD.php');

session_start();

if(isset($_POST['deleteReview']) && $_POST['deleteReview'] == 'true') {
    deleteReview($_POST['reviewId']);
}

if (isset($_SESSION['state'])) {
    if (isset($_POST['addReview']) && $_POST['addReview'] == 'true') {
        if (isset($_POST['movieId'])) {
            $movieId = $_POST['movieId'];
            if (!getMovieById($_POST['movieId'])) {
                $createdMovie = createMovie(new Movie($_POST['movieId'], $_POST['moviePosterPath'], $_POST['movieTitle'], $_POST['movieOverview'], $_POST['movieReleaseDate'], "testGr", $_POST['movieVoteAverage']));
                if (!$createdMovie) {
                    echo "Error creating movie !!!";
                }
            }
            $movie = getMovieById($_POST['movieId']);
            $user = getUserByUsername($_SESSION['username']);
            $createdReview = createReview(new Review($user, $movie, (float) $_POST['reviewRating'], $_POST['reviewComment'], new DateTime('now', new DateTimeZone('Africa/Casablanca'))));

            if (!$createdReview) {
                echo "Error creating review !!!";
            }
        }
    }
} else {
    $connectionMsg = "Please sign in to give your review !!!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lemon&family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--Box icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/stylebook.css">
    <link rel="stylesheet" href="css/book.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/movieInfo.js" defer></script>
    <title>Movie Info</title>
</head>

<body>
    <!--Navbar-->
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
            <li><a href="index.php">NewsLetteer</a></li>
        </ul>
        <a href="log_reg.html" class="btn">
            Sign in <i class='bx bxs-user'></i>
        </a>
        <div id="profile-dropdown">
            <ul>
                <li><a href="userInfos.php">Profile</a></li>
                <li><a href="#" id="signout-btn">Sign Out</a></li>
            </ul>
        </div>
    </header>

    <section class="movie-booking">
        <div class="movie-information">
            <div class="movie-image">
                <img id="movie-poster" src="" alt="">
            </div>
            <div class="movie-content">
                <div class="movie-trailer">
                    <h1 id="movie-title"></h1>
                    <div class="movie-type">
                        <p>Crime</p>
                        <div class="line"></div>
                        <p>Drama</p>
                        <div class="line"></div>
                        <p>Thriller</p>
                    </div>
                </div>
                <div class="imdb">
                    <p id="movie-rating">Imdb : </p>
                    <p id="movie-release-date"></p>
                </div>
                <div class="trailer">
                    <button id="btn-add-movie-to-watch-list" class="btn-trailer" style="padding : 5px; background-color:red; border:none">
                        Add movie to watch list
                    </button>
                    <button class="btn-trailer">
                        Watch Trailer
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="movie-description">
        <h2>Description</h2>
        <p id="movie-overview"></p>
    </section>
    <section class="comments">
        <h4 style="color:red;"><?php echo isset($connectionMsg) ? $connectionMsg : ""; ?></h4><br>
        <h2>Comments</h2>
        <div class="comment-box">
            <input type="text" id="movie-id" hidden>
            <input type="range" min="0" max="10" id="review-rating">
            <input type="text" placeholder="Leave a Comment" id="review-comment"><br><br>
            <input type="button" value="Comment" id="btn-comment">
        </div>

        <?php
        $reviews = readReviews();
        if ($reviews !== null) {
            foreach ($reviews as $review) {
                if ($review['movie_id'] === $_GET['movieId']) {
                    $user = getUserById($review['user_id']);
        ?>
                    <div class="users">
                        <div class="user">
                            <div class="profile">
                                <img src="<?php echo $user->getAvatarUrl(); ?>" alt="<?php echo $user->getUsername(); ?>" style="width: 80px;height: 80px;border:1px solid red;border-radius: 50px;">
                            </div>
                            <div class="user-com">
                                <div class="info">
                                    <div class="name">
                                        <h4><?php echo $user->getUsername(); ?></h4>
                                    </div>
                                    <div class="date">
                                        <p><?php echo $review['review_date']; ?></p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <p><?php echo $review['comment']; ?></p>
                                </div>
                                <div class="rating">
                                    <p><?php echo $review['rating']; ?>/10</p>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['state'])) {
                                if ($review['user_id'] == getUserByUsername($_SESSION['username'])->getId()) {
                            ?>
                                    <div>
                                        <button onclick="deleteReview(<?php echo $review['id']; ?>)">Delete review</button>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>

        <?php }
            }
        }
        ?>
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


</body>

</html>