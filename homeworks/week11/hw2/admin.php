<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    $stmt = $conn->prepare('
      SELECT a.id as article_id, a.author_id, a.title, a.content, a.created_ts, a.updated_ts
      FROM Jamie_articles a JOIN Jamie_users u
      ON a.author_id = u.id
      WHERE a.is_deleted = 0
      ORDER BY a.id DESC
    ');
    $stmt->execute();
    $result = $stmt->get_result();
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
          <li><a href="upsert_page.php?type=insert">新增文章</a></li>
          <li><a href="#">登出</a></li>
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
    <div class="container">
      <div class="admin-posts">
        <?php while($row = $result->fetch_assoc()): ?> 
          <div class="admin-post">
            <div class="admin-post__title">
                <?= escape($row['title']); ?>
            </div>
            <div class="admin-post__info">
              <div class="admin-post__created-at">
                <?= $row['created_ts']; ?>
              </div>
              <a class="admin-post__btn" href="upsert_page.php?type=update&article_id=<?=$row['article_id'];?>">
                編輯
              </a>
              <a class="admin-post__btn" href="handle_delete.php?article_id=<?=$row['article_id'];?>">
                刪除
              </a>
            </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>