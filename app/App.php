<?php

declare(strict_types=1);

require_once '../app/Constants.php';

echo '<body style="background-color: black; color: blueviolet"></body>';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $user_description = $_POST['user_description'];
    if(count(scandir(USER_FILES_PATH)) > 2) {
        $id = checkForOtherUsers(USER_FILES_PATH);
        file_put_contents(
            '../user_files/' . $_POST['user_name'] . '.txt',
            "id: $id\nusername: $user_name\ndescription: $user_description"
        );
    } else {
        file_put_contents(
            '../user_files/' . $_POST['user_name'] . '.txt',
            "id: 1\nusername: $user_name\ndescription: $user_description"
        );
    }
    echo 'file created successfully';
}

function getUsers(string $dirPath): array {
    $users = [];
    foreach(scandir($dirPath) as $user) {
        if (is_dir($user)) {
            continue;
        }
        $users[] = $dirPath . $user;
    }
    return $users;
}

function getUserInfo(string $userFile): array {
    if(! file_exists($userFile)) {
        trigger_error('File "' . $userFile . '" does not exist.', E_USER_ERROR);
    }
    $file = fopen($userFile, 'r');
    $usersInfo = [];
    while(($line = fgets($file)) !== false) {
        $usersInfo[] = $line;
    }
    return $usersInfo;
}

function checkForOtherUsers(string $user_id): int {
    $files = scandir($user_id, SCANDIR_SORT_DESCENDING);
    $newest_file = $user_id . $files[0];
    $file = fopen($newest_file, 'r');
    $line = fgets($file);
    $id = filter_var($line, FILTER_SANITIZE_NUMBER_INT);
    return $id + 1;
}

