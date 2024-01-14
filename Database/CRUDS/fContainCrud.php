<?php

require_once(__DIR__ ."/../fProjectDB.php");
require_once(__DIR__ ."/../../Models/Contain.php");
require_once(__DIR__ ."/../CRUDS/fMoviesCrud.php");

function createContain(Contain $contain) {
    $conn = connectToDatabase();

    $cMovieId = $contain->getMovie()->getMovieID();
    $cGenreId = $contain->getGenre()->getId();

    $sql = "INSERT INTO ProjectDB.contain (movie_id, genre_id) VALUES ('$cMovieId', '$cGenreId')";
    
    return $conn->query($sql);
    $conn->close();
}

function checkIfMovieWithGenresExists($cMovieId , $cGenreId) {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.contain WHERE movie_id = '$cMovieId' AND genre_id = '$cGenreId'";
    $result = $conn->query($sql);

    $flag = false;
    if ($result->num_rows === 1) {
        $flag = true;
    }

    return $flag;
    $conn->close();
}

function getMoviesbyGenre($cGenreId) {
    $conn = connectToDatabase();

    $sql = "SELECT movie_id FROM ProjectDB.contain WHERE genre_id = '$cGenreId'";
    $result = $conn->query($sql);

    $contain = [];
    $movies = [];
    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $contain[] = $row;
            $movie = getMovieById($contain['movie_id']);
            array_push($movies , $movie);
        }
        return $movies;
    }else{
        return false;
    }
    
    $conn->close();
}

?>
