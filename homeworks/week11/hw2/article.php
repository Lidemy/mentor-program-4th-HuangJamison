<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    $article_id = intval($_GET['id']);
    $stmt = $conn->prepare('
        SELECT a.id as article_id, a.author_id, a.title, a.content, a.created_ts, a.updated_ts
        FROM Jamie_articles a JOIN Jamie_users u
        ON a.author_id = u.id
        WHERE a.is_deleted = 0
        AND a.id = ?
    ');
    $stmt->bind_param('i', $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result->num_rows) {
      die('拿不到此文章');
    }
    $articleRow = $result->fetch_assoc();
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
          <li><a href="index.php">文章列表</a></li>
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
      <article class="post">
        <div class="post__header">
          <div><?= escape($articleRow['title']);?></div>
          <div class="post__actions">
            <a class="post__action" href="upsert_page.php?type=update&article_id=<?=$articleRow['article_id'];?>">編輯</a>
          </div>
        </div>
        <div class="post__info">
          <?= $articleRow['created_ts'];?>
        </div>
        <div class="post__content">
          <?= escape($articleRow['content']);?>
        </div>
      </article>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>
