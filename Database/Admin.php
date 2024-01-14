<?php

require_once('CRUDS/fUsersCrud.php');

session_start();

isset($_POST['id']) ? $userId  = $_POST['id'] : null;
isset($_POST['username']) ? $userName = $_POST['username'] : null;
isset($_POST['email']) ? $userEmail = $_POST['email'] : null;
isset($_POST['password']) ? $userPassword = $_POST['password'] : null;
isset($_POST['age']) ? $userAge = $_POST['age'] : 0;
isset($_POST['avatarUrl']) ? $userAvatarUrl = $_POST['avatarUrl'] : null;
isset($_POST['watchList']) ? $userWatchList = $_POST['watchList'] : null;

if (isset($_POST['btn_edit'])){
    updateUser($userId, $userName, $userEmail, $userPassword, $userAge, $userAvatarUrl, $userWatchList);
} elseif (isset($_POST['btn_delete'])) {
    deleteUser($userId);
}

if (isset($_POST['uncheck']) && $_POST['uncheck'] == 'false') {
    $_SESSION = array();
    session_destroy();   
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Users list</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/Admin.js" defer></script>
</head>

<body>
    <div class="container my-5 ">
        <h1 class="text-info text-center">Users list</h1><br>

        <table class="table table-hover table-sm">
            <thead class="table-dark">
                <tr>
                    <th class="text-info text-center" scope="col">#</th>
                    <th class="text-info text-center" scope="col">ID</th>
                    <th class="text-info text-center" scope="col">Username</th>
                    <th class="text-info text-center" scope="col">Email</th>
                    <th class="text-info text-center" scope="col">Password</th>
                    <th class="text-info text-center" scope="col">Age</th>
                    <th class="text-info text-center" scope="col">Avatar URL</th>
                    <th class="text-info text-center" scope="col">Watch list</th>
                    <th class="text-info text-center" scope="col">Status</th>
                    <th class="text-info text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count(readUsers()); $i++) {
                    $users = readUsers()[$i];
                    $isChecked = isset($_SESSION['username']) && $_SESSION['username'] == $users['username'] ? 'checked' : '';
                ?>
                    <tr>
                        <th scope="row"><?php echo $i + 1
                                        ?></th>
                        <td class="id"><?php echo $users['id'];
                                        ?></td>
                        <td class="username"><?php echo $users['username'];
                            ?></td>
                        <td><?php echo $users['email'];
                            ?></td>
                        <td><?php echo $users['password'];
                            ?></td>
                        <td><?php echo $users['age'];
                            ?></td>
                        <td><?php echo $users['avatarUrl'];
                            ?></td>
                        <td><?php echo $users['watchList'];
                            ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" id="connectedCheckbox" type="checkbox" role="Check if user connected" <?php echo $isChecked ?> onclick="updateState()">
                            </div>
                        </td> 
                        <td>
                            <input type="button" class="btn btn-success" name="edit" value="Edit" onclick="editUser('<?php echo $users['id']; ?>', '<?php echo $users['username']; ?>', '<?php echo $users['email']; ?>', '<?php echo $users['password']; ?>' , '<?php echo $users['age']; ?>' , '<?php echo $users['avatarUrl']; ?>' , '<?php echo $users['watchList']; ?>')">
                            <input type="button" class="btn btn-danger" name="delete" value="Delete" onclick="deleteUser(<?php echo $users['id']; ?>)">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</body>

</html>