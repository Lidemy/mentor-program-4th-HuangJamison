<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (empty($_POST['id'])) {
        $failure = [
            'status' => 'id empty'
        ];
        header('Content-Type: application/json');
        echo json_encode($failure);
        return;
    }
    $commentId = $_POST['id'];
    // update
    $is_deleted = 1;
    // 多加入 session 機制
    session_start();
    $username = $_SESSION['username'];
    // 確認為此 username 才給刪
    $stmt = $conn->prepare("UPDATE Jamie_comments SET is_deleted = ?
    WHERE id = ? AND username = ?");
    $stmt->bind_param("iis", $is_deleted, $commentId, $username);
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

