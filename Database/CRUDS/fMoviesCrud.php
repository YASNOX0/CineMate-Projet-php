<?php

require_once(__DIR__ ."/../fProjectDB.php");
require_once(__DIR__ ."/../../Models/Movie.php");

function createMovie(Movie $movie) {
    $conn = connectToDatabase();

    $mId = $movie->getMovieID();
    $mPosterURI = $movie->getPosterURI();
    $mTitle = $movie->getTitle();
    $mOverview = $conn->real_escape_string($movie->getOverview());
    $mReleaseDate = $movie->getReleaseDate();
    $mGenres = $movie->getGenres();
    $mRating = $movie->getRating();

    $sql = "INSERT INTO ProjectDB.movies (Id, posterURI, title, overview, releaseDate, genre, rating) VALUES ('$mId', '$mPosterURI', '$mTitle', '$mOverview', '$mReleaseDate', '$mGenres', '$mRating')";
    
    return $conn->query($sql);
    $conn->close();
}

function getMovieById($movieID){
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.movies WHERE id = '$movieID'";
    $result = $conn->query($sql);

    $movies = [];

    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        return new Movie($movies[0]['id'],$movies[0]['posterURI'],$movies[0]['title'],$movies[0]['overview'],$movies[0]['releaseDate'],$movies[0]['genre'],$movies[0]['rating']);
    }else{
        return false;
    } 
    $conn->close();
}

function readMovies() {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.movies";
    $result = $conn->query($sql);

    $movies = null;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
    }

    return $movies;

    $conn->close();
}


function deleteMovie($id) {
    $conn = connectToDatabase();

    $sql = "DELETE FROM ProjectDB.movies WHERE id=$id";

    return $conn->query($sql);

    $conn->close();
}

?>
