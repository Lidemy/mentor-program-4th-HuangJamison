<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
    // 利用分頁去做
    $type = 'insert';
    if (!empty($_GET['type'])) {
        $type = $_GET['type'];
    }
    if ($type == 'update' && $_GET['article_id']) {
      $stmt = $conn->prepare('
        SELECT title, content FROM Jamie_articles WHERE id = ? 
      ');
      $stmt->bind_param('i', $_GET['article_id']);
      $stmt->execute();
      $result = $stmt->get_result();
      $articleRow = $result->fetch_assoc();
    }
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
          <li><a href="admin.php">管理後台</a></li>
          <li><a href="logout.php">登出</a></li>
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
      <div class="edit-post">
        <form action="handle_upsert.php" method="POST">
          <div class="edit-post__title">
            發表文章：
          </div>
          <?php if ($type == 'update'): ?> 
            <input type="hidden" name="article_id" value="<?= $_GET['article_id']; ?>"/>
          <?php endif; ?>
          <input type="hidden" name="action_type" value="<?= $type; ?>"/>
          <input type="hidden" name="author_id" value="<?= $userInfo['id']; ?>"/>
          <div class="edit-post__input-wrapper">
            <?php if ($type == 'update'): ?>
              <input class="edit-post__input" placeholder="請輸入文章標題" name="title" value="<?= $articleRow['title'];?>"/>
            <?php else: ?>
              <input class="edit-post__input" placeholder="請輸入文章標題" name="title" value=""/>
            <?php endif;?>
          </div>
          <div class="edit-post__input-wrapper">
            <?php if ($type == 'update'): ?>
              <textarea rows="20" class="edit-post__content" name="content"><?= $articleRow['content'];?></textarea>
            <?php else: ?>
              <textarea rows="20" class="edit-post__content" name="content"></textarea>
            <?php endif;?>
          </div>
          <div class="edit-post__btn-wrapper">
            <input class="edit-post__btn" type="submit" value="送出"/>
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>