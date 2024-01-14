<?php

require_once(__DIR__ . "/../fProjectDB.php");
require_once(__DIR__ . "/../../Models/User.php");

function createUser(User $user) 
{
    $conn = connectToDatabase();
    
    $uName = $user->getUsername();
    $uPassword = $user->getPassword();
    $uEmail = $user->getEmail();
    $uAge = $user->getAge();
    $uAvatarUrl = $user->getAvatarUrl();
    $uWatchList = $user->getWatchList();
    $uFavoriteGenres = $user->getFavoriteGenres();

    $hashedPassoword = password_hash($uPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO ProjectDB.users (username, password , email , age , avatarUrl , watchList , favorit_genres) VALUES ('$uName','$hashedPassoword','$uEmail','$uAge','$uAvatarUrl','$uWatchList','$uFavoriteGenres')";

    return $conn->query($sql);
    $conn->close();
}

function readUsers() 
{
    $conn = connectToDatabase();

    $sql = "SELECT * FROM ProjectDB.users";
    $result = $conn->query($sql);

    $users = null;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;

    $conn->close();
}

function updateUser(int $id, 
?string $username = null, 
?string $email = null, 
?string $password = null, 
int $age = 0, 
?string $avatarUrl = null, 
?string $watchList = null)
{
    $conn = connectToDatabase();

    $sql = "UPDATE ProjectDB.users SET ";

    if ($username !== null) {
        $sql .= "username = '$username', ";
    }

    if ($email !== null) {
        $sql .= "email = '$email', ";
    }

    if ($password !== null) {
        if ($password != getUserById($id)->getPassword()) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql .= "password = '$hashedPassword', ";
        }
    }

    if ($age !== 0) {
        $sql .= "age = '$age', ";
    }

    if ($avatarUrl !== null) {
        $sql .= "avatarUrl = '$avatarUrl', ";
    }

    if ($watchList !== null) {
        $sql .= "watchList = '$watchList'";
    }

    $sql = rtrim($sql, ', ') . " WHERE id = $id";

    return $conn->query($sql);

    $conn->close();
}

function getUserById($id)
{
    $conn = connectToDatabase();
    $sql = "SELECT * FROM ProjectDB.users WHERE id = $id";
    $result = $conn->query($sql);

    $users = null;

    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    $watchList = explode("," , $users[0]['watchList']);
    return new User($users[0]['username'] , $users[0]['password'] , $users[0]['email'] , $users[0]['age'], $users[0]['avatarUrl'],$watchList);

    $conn->close();
}

function getUserByUsername($username)
{
    $conn = connectToDatabase();
    $sql = "SELECT * FROM ProjectDB.users WHERE username = '$username'";
    $result = $conn->query($sql);

    $users = null;

    if ($result->num_rows === 1) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    $watchList = explode("," , $users[0]['watchList']);
    $user = new User($users[0]['username'] , $users[0]['password'] , $users[0]['email'] , $users[0]['age'] , $users[0]['avatarUrl'] , $watchList);
    $user->setId($users[0]['id']);
    return $user;

    $conn->close();
}

function deleteUser($id) 
{
    $conn = connectToDatabase();

    $sql = "DELETE FROM ProjectDB.users WHERE id=$id";

    return $conn->query($sql);

    $conn->close();
}

?>
