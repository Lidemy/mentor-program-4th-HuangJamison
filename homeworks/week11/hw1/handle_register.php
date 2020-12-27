<?php
    require_once('./conn.php');
    if (
        empty($_POST['nickname']) ||
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        header('Location: index.php?error=1');
        exit();
    }
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 加密


    $stmt = $conn->prepare("INSERT INTO Jamie_users(nickname,username,password) 
    values(?,?,?)");
    $stmt->bind_param("sss", $nickname, $username, $password);
    $stmt->execute();
    if (!$stmt->affected_rows) {
        $fail = [
            'status' => 'fail',
            'reason' => 'sql reason',
        ];
        if ($conn->errno == 1062) {
            $fail['reason'] = 'duplicate key!!';
        }
        header('Content-Type: application/json');
        echo json_encode($fail);
        exit();
    }
    // 改用 php 內建 session 寫入 cookie
    session_start();
    $_SESSION['username'] = $username;
    $success = [
        'status' => 'success'
    ];
    header('Content-Type: application/json');
    echo json_encode($success);