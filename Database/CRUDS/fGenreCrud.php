<?php

require_once(__DIR__ ."/../fProjectDB.php");
require_once(__DIR__ ."/../../Models/Genre.php");

function createGenre(Genre $genre) {
    $conn = connectToDatabase();

    $gId = $genre->getId();
    $gName = $genre->getName();

    $sql = "INSERT INTO ProjectDB.genres (Id, name) VALUES ('$gId', '$gName')";
    
    return $conn->query($sql);
    $conn->close();
}

function getGenreById($genreID){
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.genres WHERE id = '$genreID'";
    $result = $conn->query($sql);

    $genres = [];

    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }
    }

    $flag = false;
    if(!empty($genres)){
        $genre = new Genre($genres[0]['id'] , $genres[0]['name']);
        $flag = true;
    }
    if($flag){
        return $genre;
    }else{
        return false;
    }
    
    $conn->close();
}

function readGenres() {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.genres";
    $result = $conn->query($sql);

    $genres = null;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }
    }

    return $genres;

    $conn->close();
}


function deleteGenre($id) {
    $conn = connectToDatabase();

    $sql = "DELETE FROM ProjectDB.genres WHERE id=$id";

    return $conn->query($sql);

    $conn->close();
}

?>
