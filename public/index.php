<?php

declare(strict_types=1);

require "../app/App.php";
include_once '../views/users.php';


// get all files with users
$users = getUsers(USER_FILES_PATH);

// create our array to store our array of lines from each user file
$usersInfo = [];

// loop over each user file
foreach($users as $user) {
    // add lines from user files to our usersInfo array
    $usersInfo = array_merge($usersInfo, getUserInfo($user));
}


