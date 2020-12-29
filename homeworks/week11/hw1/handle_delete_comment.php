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
    // 多加入 session 機制
    if (empty($_SESSION['username'])) {
        die('尚未登入哦');
    }
    session_start();
    $username = $_SESSION['username'];
    // 確認為此 username 才給刪
    $stmt = $conn->prepare("UPDATE Jamie_comments SET is_deleted = 1
    WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $commentId, $username);
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

