<?php  

function connectToDatabase()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbName = "ProjectDB";

    $conn = new mysqli($hostname, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $createDbSql = "CREATE DATABASE IF NOT EXISTS $dbName";
    if (!$conn->query($createDbSql)) {
        echo "Error creating database: " . $conn->error;
        $conn->close();
        exit;
    }

    $conn->select_db($dbName);

    return $conn;
}

    $conn = connectToDatabase();


    $sql = "CREATE TABLE IF NOT EXISTS ProjectDB.users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        age INT NOT NULL , 
        avatarUrl VARCHAR(255), 
        watchList VARCHAR(255),
        favorit_genres VARCHAR(255) NOT NULL,
        CONSTRAINT unique_user UNIQUE (username)
    )";

    if (!$conn->query($sql)) {
        echo "Error while creating table <<Users>> : " . $conn->error;
    }
    $sql = "CREATE TABLE IF NOT EXISTS ProjectDB.movies (
        id INT PRIMARY KEY,
        posterURI VARCHAR(255) NOT NULL,
        title VARCHAR(255) NOT NULL,
        overview VARCHAR(255) NOT NULL,
        releaseDate VARCHAR(255) NOT NULL,
        genre VARCHAR(255) NOT NULL,
        rating DOUBLE PRECISION(10, 2) NOT NULL
    )";

    if (!$conn->query($sql)) {
        echo "Error while creating table <<Movies>> : " . $conn->error;
    }

    $sql = "CREATE TABLE IF NOT EXISTS ProjectDB.reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        movie_id INT NOT NULL,
        rating INT NOT NULL,
        comment TEXT NOT NULL,
        review_date TEXT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (!$conn->query($sql)) {
        echo "Error while creating table <<reviews>> : " . $conn->error;
    }

    $sql = "CREATE TABLE IF NOT EXISTS ProjectDB.genres (
        id INT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    if (!$conn->query($sql)) {
        echo "Error while creating table <<genres>> : " . $conn->error;
    }

    $sql = "CREATE TABLE IF NOT EXISTS ProjectDB.contain (
        movie_id INT,
        genre_id INT,
        PRIMARY KEY (movie_id, genre_id),
        FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    if (!$conn->query($sql)) {
        echo "Error while creating table <<genres>> : " . $conn->error;
    }

    $conn->close();
?>