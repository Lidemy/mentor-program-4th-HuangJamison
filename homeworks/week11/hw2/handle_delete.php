<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    if (empty($_GET['article_id'])) {
        die('沒傳入刪除文章號碼');
    }
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    if ($username !== 'admin') {
        die('沒有權限刪除文章');
    }
    $stmt = $conn->prepare('UPDATE Jamie_articles SET is_deleted=? WHERE id=?');
    $is_deleted = 1;
    $article_id = intval($_GET['article_id']);
    $stmt->bind_param('ii', $is_deleted, $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($stmt->affected_rows) {
        header('Location: admin.php');
    }
?>