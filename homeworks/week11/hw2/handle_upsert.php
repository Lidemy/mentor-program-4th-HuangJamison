<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    if (!in_array($_POST['action_type'], ['insert', 'update'])) {
        die('不是新增也不是修改文章');
    }
    if (empty($_POST['title']) || empty($_POST['content'])) {
        $errorMsg = '';
        $errorMsg .= $_POST['action_type'] == 'insert' ? '新增文章時，' : '修改文章時，';
        die($errorMsg . '標題與文章不得為空值');
    }
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    if ($username !== 'admin') {
        die('沒有權限新增修改文章' . $username);
    }
    if ($_POST['action_type'] == 'insert') {
        $author_id = intval($_POST['author_id']);
        $stmt = $conn->prepare('INSERT INTO Jamie_articles(author_id, title, content) values(?,?,?)');
        $stmt->bind_param('iss', $author_id, $_POST['title'], $_POST['content']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($stmt->affected_rows) {
            header('Location: admin.php');
        }
    }
    $author_id = intval($_POST['author_id']);
    $article_id = intval($_POST['article_id']);
    $stmt = $conn->prepare('UPDATE Jamie_articles SET author_id=?, title=?, content=? WHERE id=?');
    $stmt->bind_param('issi', $author_id, $_POST['title'], $_POST['content'], $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($stmt->affected_rows) {
        header('Location: admin.php');
    }
?>