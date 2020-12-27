<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (empty($_POST['edit_name'])) {
        $failure = [
            'status' => 'edit_name empty'
        ];
        header('Content-Type: application/json');
        echo json_encode($failure);
        return;
    }
    // 拿取 username
    session_start();
    $newNickname = $_POST['edit_name'];
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    // update
    $stmt = $conn->prepare("UPDATE Jamie_users SET nickname = ?
    WHERE username = ?");
    $stmt->bind_param("ss", $newNickname, $username);
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
        'msg' => 'post edit_name is empty'
    ];
    header('Content-Type: application/json');
    echo json_encode($failure);

