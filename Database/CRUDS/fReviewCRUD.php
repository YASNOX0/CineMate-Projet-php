<?php

require_once(__DIR__ ."/../fProjectDB.php");
require_once(__DIR__ ."/../../Models/Review.php");
require_once(__DIR__ ."/../../Models/User.php");
require_once(__DIR__ ."/../../Models/Movie.php");

function createReview(Review $review) {
    $conn = connectToDatabase();

    $user_id = $review->getUser()->getId();
    $movie_id = $review->getMovie()->getMovieID();
    $rating = $review->getRating();
    $comment = $review->getComment();
    $reviewDate = $review->getReviewDate(); 
    $strDate = $reviewDate->format('Y-m-d H:i:s');

    $sql = "INSERT INTO ProjectDB.reviews (user_id, movie_id, rating, comment, review_date) VALUES ('$user_id','$movie_id','$rating','$comment','$strDate')";
    
    return $conn->query($sql);
    $conn->close();
}

function updateReview($id, 
int $user_id = 0, 
int $movie_id = 0, 
float $rating = 0.0 , 
?string $comment = null)
{
    $conn = connectToDatabase();

    $sql = "UPDATE ProjectDB.reviews SET ";

    if ($user_id !== 0) {
        $sql .= "user_id = '$user_id', ";
    }

    if ($movie_id !== 0) {
        $sql .= "movie_id = '$movie_id', ";
    }

    if ($rating !== 0.0) {
        $sql .= "rating = '$rating', ";
    }

    if ($comment !== null) {
        $sql .= "comment = '$comment'";
    }

    $sql = rtrim($sql, ', ') . " WHERE id = $id";

    return $conn->query($sql);

    $conn->close();
}

function readReviews() {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.reviews";
    $result = $conn->query($sql);

    $reviews = null;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }

    return $reviews;

    $conn->close();
}

function getReviewByUserIDAndMovieID($user_id , $movie_id) {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.reviews WHERE user_id = $user_id AND movie_id = $movie_id";
    $result = $conn->query($sql);

    $review = null;

    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $review[] = $row;
        }
    }

    $review = new Review(getUserById($review['user_id']) , getMovieById($review['movie_id']) , $review['rating'] , $review['comment'] , $review['review_date']);
    return $review;

    $conn->close();
}


function deleteReview($id) {
    $conn = connectToDatabase();

    $sql = "DELETE FROM ProjectDB.reviews WHERE id=$id";

    return $conn->query($sql);

    $conn->close();
}

?>
