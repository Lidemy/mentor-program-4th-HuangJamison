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
    $content = $_POST['content'];
    // insert
    $stmt = $conn->prepare("INSERT INTO Jamie_comments(username,content)
    values(?,?)");
    $stmt->bind_param("ss", $username, $content);
    $stmt->execute();
    if (!$stmt->affected_rows) {
        die($conn->error);
    }
    // 成功直接返回
    // header('Location: index.php');

    $success = [
        'status' => 'success'
    ];
    header('Content-Type: application/json');
    echo json_encode($success);