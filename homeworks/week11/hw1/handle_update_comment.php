<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (empty($_POST['content']) || empty($_POST['id'])) {
        $failure = [
            'status' => 'content or id empty'
        ];
        header('Content-Type: application/json');
        echo json_encode($failure);
        return;
    }
    $newContent = $_POST['content'];
    $commentId = $_POST['id'];
    // 多加入 session 機制
    session_start();
    $username = $_SESSION['username'];
    // update
    $stmt = $conn->prepare("UPDATE Jamie_comments SET content = ?
    WHERE id = ? AND username = ?");
    $stmt->bind_param("sis", $newContent, $commentId, $username);
    $result = $stmt->execute();
    if ($stmt->affected_rows) {
        $success = [
            'status' => 'success'
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($success);
        return;
    }
    $failure = ['status' => 'failure', 'msg' => 'update error'];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($failure);
    return;

