<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    // 利用分頁去做
    $page = 1;
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    $stmt = $conn->prepare('SELECT COUNT(c.id) as count_num FROM Jamie_comments c JOIN Jamie_users u ON c.username = u.username WHERE c.is_deleted = 0');
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    $totalNum = 0;
    if (!empty($result['count_num'])) {
        $totalNum = $result['count_num'];
    }
    $numPerPage = 5;
    $totalPage = ceil($totalNum / $numPerPage);
    $offset = ($page - 1) * $numPerPage;
    $stmt = $conn->prepare('
        SELECT c.id as comment_id, c.username, c.content, c.created_at, u.nickname
        FROM Jamie_comments c JOIN Jamie_users u
        ON c.username = u.username
        WHERE c.is_deleted = 0
        ORDER BY c.id DESC
        LIMIT ? OFFSET ?
    ');
    $stmt->bind_param('ii', $numPerPage, $offset);
    $result = $stmt->execute();
    if (!$result) {
        echo 'Error:' . $conn->error;
    }
    $result = $stmt->get_result();
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            'comment_id' => $row['comment_id'],
            'username' => $row['username'],
            'nickname' => $row['nickname'],
            'comment' => $row['content'],
            'ts' => $row['created_at']
        ];
    }

    $response = json_encode($comments);
    header('Content-Type: application/json; charset=utf-8');
    echo $response;
?>