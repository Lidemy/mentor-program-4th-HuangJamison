<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (
        empty($_POST['id'])
        || empty($_POST['auth'])
    ) {
        $failure = [
            'status' => 'parms lack'
        ];
        header('Content-Type: application/json');
        echo json_encode($failure);
        return;
    }
    // 拿取 username
    session_start();
    if (empty($_SESSION['username'])) {
        die('您尚未登入哦');
    }
    if ($_SESSION['username'] != 'admin') {
        die('只有最高權限才能改');
    }
    // update
    $stmt = $conn->prepare("UPDATE Jamie_users SET auth = ?
    WHERE id = ?");
    $stmt->bind_param("si", $_POST['auth'], $_POST['id']);
    $result = $stmt->execute();
    if (!empty($result)) {
        $success = [
            'status' => 'success'
        ];
        header('Content-Type: application/json');
        echo json_encode($success);
        return;
    }
    $failure = [
        'status' => 'failure',
        'msg' => 'sql error'
    ];
    header('Content-Type: application/json');
    echo json_encode($failure);