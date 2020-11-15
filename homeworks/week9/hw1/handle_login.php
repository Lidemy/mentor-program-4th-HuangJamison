<?php
    require_once('./conn.php');
    require_once('./utils.php');
    if (
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        $fail = [
            'status' => 'fail',
            'reason' => '登入資料不齊全',
        ];
        header('Content-Type: application/json');
        echo json_encode($fail);
        exit();
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = sprintf("SELECT * FROM Jamie_users 
    WHERE username='%s' AND password='%s'", $username, $password);
    $result = $conn->query($sql);
    if (!$result->num_rows) {
        $fail = [
            'status' => 'fail',
            'reason' => '未找到登入帳號與密碼',
        ];
        header('Content-Type: application/json');
        echo json_encode($fail);
        exit();
    }
    // 改用 php 內建 session
    session_start();
    $_SESSION['username'] = $username;

    $success = [
        'status' => 'success'
    ];
    header('Content-Type: application/json');
    echo json_encode($success);