<?php 
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

    require_once '../env/hashkey.php';
    $password = md5($key.$password);
    
    require_once '../sql/db.php';
    $sql = 'SELECT id FROM users WHERE name = ? AND password = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$username, $password]);

    if ($query->rowCount() == 0) {
        echo "User doesn't exist";
    }
    else {
        setcookie('showUsername', $username, time() + 3600 * 24 * 30, "/");
        header('Location: ../notes/notes.php');
    }