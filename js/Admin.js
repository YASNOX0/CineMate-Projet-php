function editUser(id , username, email , password , age , avatarUrl , watchList) {
let newName = prompt("Enter new username :", username);
let newEmail = prompt("Enter new email :", email);
let newPassword = prompt("Enter new password :", password);
let newAge = prompt("Enter new age :", age);
let newAvatarUrl = prompt("Enter new avatarUrl :", avatarUrl);
let newWatchList = prompt("Enter new watchList :", watchList);
let btn_edit = document.getElementsByName("edit")[0];

let xhr = new XMLHttpRequest();
xhr.open("POST", "Admin.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
        alert("User edited !!!");
        location.reload(); 
    }
};
xhr.send(`id=${encodeURIComponent(id)}&username=${encodeURIComponent(newName)}&email=${encodeURIComponent(newEmail)}&password=${encodeURIComponent(newPassword)}&age=${encodeURIComponent(parseInt(newAge))}&avatarUrl=${encodeURIComponent(newAvatarUrl)}&watchList=${encodeURIComponent(newWatchList)}&btn_edit=${encodeURIComponent(btn_edit.value)}`);
}

function deleteUser(id) {
let btn_delete = document.getElementsByName("delete")[0];

let xhr = new XMLHttpRequest();
xhr.open("POST", "Admin.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
        alert("User deleted !!!");
        location.reload(); 
    }
};
xhr.send(`id=${encodeURIComponent(id)}&btn_delete=${encodeURIComponent(btn_delete.value)}`);
}

function updateState() {
    let connectedCheckbox = document.getElementById('connectedCheckbox');
    let isChecked = connectedCheckbox.checked;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "Admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.reload();
        }
    };

    xhr.send(`uncheck=${encodeURIComponent(isChecked)}`);
}

