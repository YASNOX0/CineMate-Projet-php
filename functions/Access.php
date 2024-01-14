<?php
require_once(__DIR__ . '/../Database/CRUDS/fUsersCrud.php');

function checkIfUserExists(string $username , string $password): bool
{
    $users = readUsers();

    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            return true;
        }
    }

    return false;
}


// function forgottenPassword(string $email, $age, $newPassword = ""): bool
// {
//     $user = getUserByEmail($email);

//     if ($user !== null) {
//         if ($user->getAge() == $age) {
//             $user->setPassword($newPassword);
//         }
//         return true;
//     }
//     return false;
// }
