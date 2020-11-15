<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (empty($_POST['content'])) {
        header('Location: index.php?error=1');
        exit();
    }
    // 拿取 username
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    $sql_select = sprintf("SELECT nickname FROM Jamie_users 
    WHERE username = '%s'", $username);
    $result = $conn->query($sql_select);
    $row = $result->fetch_assoc();
    $nickname = $row['nickname'];
    $content = $_POST['content'];
    $sql = sprintf("INSERT INTO Jamie_comments(nickname,content) 
    values('%s', '%s')", $nickname, $content);
    $result = $conn->query($sql);
    if (empty($result)) {
        die($conn->error);
    }
    // 成功直接返回
    // header('Location: index.php');

    $success = [
        'status' => 'success'
    ];
    // header('Content-Type: application/json');
    // echo json_encode($success);