<?php
    require_once 'classes/userHandler.php';
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

    $regexp = "/^[a-zA-Z_а-яёА-ЯЁ][0-9a-zA-Z_а-яёА-ЯЁ]+$/u";
    if (!preg_match($regexp, $username, $matches) || strlen($username) < 2) {
        echo "Username error";
        exit;
    };
    if(strlen($password) < 1) {
        echo "Password error";
        exit;
    }
    $uh = new UserHandler();

    if (!$uh->login($username, $password)) {
        echo "Wrong name or password";
    }
    else {
        setcookie('showUsername', $username, time() + 3600 * 24 * 30, "/app");
        header('Location: ../notes/notes.php');
    }