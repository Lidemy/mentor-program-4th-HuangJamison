<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    // 利用分頁去做
    $page = 1;
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    $stmt = $conn->prepare('SELECT COUNT(a.id) as article_num FROM Jamie_articles a JOIN Jamie_users u ON a.author_id = u.id WHERE a.is_deleted = 0');
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    $totalNum = 0;
    if (!empty($result['article_num'])) {
        $totalNum = $result['article_num'];
    }
    $numPerPage = 5;
    $totalPage = ceil($totalNum / $numPerPage);
    $offset = ($page - 1) * $numPerPage;
    $stmt = $conn->prepare('
        SELECT a.id as article_id, a.author_id, a.title, a.content, a.created_ts, a.updated_ts
        FROM Jamie_articles a JOIN Jamie_users u
        ON a.author_id = u.id
        WHERE a.is_deleted = 0
        ORDER BY a.id DESC
        LIMIT ? OFFSET ?
    ');
    $stmt->bind_param('ii', $numPerPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    if (!empty($username)) {
        $stmtUser = $conn->prepare('SELECT * FROM Jamie_users WHERE username = ?');
        $stmtUser->bind_param('s', $username);
        $stmtUser->execute();
        $userInfo = $stmtUser->get_result();
        if (!$userInfo->num_rows) {
            echo 'Error:' . $conn->error;
        }
        $userInfo = $userInfo->fetch_assoc();
    }
?>
<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">

  <title>部落格</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="normalize.css" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <nav class="navbar">
    <div class="wrapper navbar__wrapper">
      <div class="navbar__site-name">
        <a href='index.php'>Jamie's Blog</a>
      </div>
      <ul class="navbar__list">
        <div>
          <li><a href="#">文章列表</a></li>
          <li><a href="#">分類專區</a></li>
          <li><a href="#">關於我</a></li>
        </div>
        <div>
          <?php if (!empty($userInfo)): ?>
            <li><a href="admin.php">管理後台</a></li>
            <li><a href="logout.php">登出</a></li>
          <?php else: ?>
            <li><a href="login.php">登入</a></li>
          <?php endif; ?>
        </div>
      </ul>
    </div>
  </nav>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="posts">
    <?php while($row = $result->fetch_assoc()): ?>
      <article class="post">
        <div class="post__header">
          <div><?= escape($row['title']);?></div>
          <div class="post__actions">
            <?php if ($username == 'admin'): ?>
            <a class="post__action" href="upsert_page.php?type=update&article_id=<?=$row['article_id'];?>">編輯</a>
            <?php endif; ?>
          </div>
        </div>
        <div class="post__info">
          <?= $row['created_ts'];?>
        </div>
        <div class="post__content">
          <?= escape(mb_substr($row['content'], 0, 50) . '...');?>
        </div>
        <a class="btn-read-more" href="article.php?id=<?= $row['article_id']; ?>">READ MORE</a>
      </article>
    <?php endwhile; ?>
    </div>
  </div>
  <div class="pagination">
      <?php if ($page > 1): ?>
          <a href="index.php?page=<?= $page - 1; ?>">上一頁</a>
          <a href="index.php?page=1">第一頁</a>
      <?php endif; ?>
      <span>
          目前在第 <?= $page; ?> 頁
      </span>
      <?php if ($page < $totalPage): ?>
          <a href="index.php?page=<?= $page + 1; ?>">下一頁</a>
          <a href="index.php?page=<?= $totalPage; ?>">最後一頁</a>
      <?php endif; ?>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>
