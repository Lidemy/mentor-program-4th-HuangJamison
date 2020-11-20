<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');

    $result = $conn->query('SELECT * FROM Jamie_comments ORDER BY id DESC');
    if (!$result) {
        echo 'Error:' . $conn->error;
    }
    // 改為用 session 判斷
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
</head>
<style>
    * {
        box-sizing: border-box;
        margin: 0 ;
    }
    body {
        background-color: whitesmoke;
    }
    header {
        background-color: pink;
        color: red;
        font-weight: bold;
        height: 50px;
        width: 100%;
        margin: 0 auto;
        padding: 12px 0;
        text-align: center;
    }
    main {
        margin: 10px;
        width:  100%;
        max-width: 600px;
        background-color: white;
        margin: 15px auto;
        padding: 20px;
    }
    .title {
        font-size: 30px;
        font-weight: lighter;
        margin-bottom: 15px;
    }
    .form-title {
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 10px;
    }
    .form-area {
        display: flex;
    }
    .form-textarea {
        border: 2px solid #FFE4E1;
        width: 80%;
        height: 60px;
        margin-right: 10px;
    }
    .form-nickname {
        border: 1.5px solid #FFE4E1;
        width: 20%;
        height: 25px;
        margin-bottom: 10px;
    }
    .form-btn {
        border: 2px solid #FFE4E1;
        padding: 10px;
        background-color: white;
        height: 40px;
        margin-top: 20px;
    }
    .nav-btn {
        border: 2px solid #FFE4E1;
        padding: 10px;
        background-color: white;
        height: 40px;
    }
    .line {
        background-color: #FFE4E1;
        height: 1px;
        margin: 30px 0;
    }
    .comment {
        display: flex;
        margin: 15px 0;
    }
    .comment__avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: grey;
        margin: 10px 15px;
    }
    .comment__right {
        width: 80%;
    }
    .comment__author, .comment__time {
        display: inline-block;
    }
    .comment__author {
        color: blue;
        font-weight: bold;
    }
    .comment__time {
        color: grey;
        font-weight: lighter;
        font-size: 14px;
        margin-left: 5px;
    }
    .comment_content {
        margin-top: 5px;
        padding: 5px 0;
        word-break: break-word;
        white-space: pre-line;
    }
    .warning {
        color: red;
        font-size: 18px;
        text-decoration: bold;
        margin: 5px 0;
    }
</style>
<script src="jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
      $('.form-btn').click((e) => {
        e.preventDefault();
        const content = $('.form-textarea').val();
        if (!content) {
            alert('資料不齊全');
            return;
        }
        const url = './handle_add.php';
        $.ajax({
            url : url,
            data: {
                'content': content
            },
            method : 'POST',
            success : function (data) {
                console.log('data:', data)
                if (data && data.status == 'success') {
                    alert('新增成功');
                }
                location.href = 'index.php'; // 不是 window.location
            },
            error : function (error) {
                alert('新增失敗...');
            }
        })
      });
    });
</script>
<body>
  <header>
      注意！本站為練習留言板，請勿使用敏感資訊!
  </header>
  <main>
    <div class="nav">
        <?php if ($username): ?>
            <a href="logout.php".php"><input type="button" value="登出" class="nav-btn"/></a>
        <?php else: ?>
            <a href="register.php"><input type="button" value="註冊" class="nav-btn"/></a>
            <a href="login.php"><input type="button" value="登入" class="nav-btn"/></a>
        <?php endif; ?>
    </div>
    <h1 class="title">Comments</h1>
    <?php if ($username): ?>
        <form class="form__add-comments" method="POST" action="handle_add.php">
            <h2 class="form-title">有什麼想說的嗎? <?= $username;?></h2>
            <div class="warning">
                <?= !empty($_GET['error']) && $_GET['error'] == 1 ? '送出資料不齊全' : '';?>
            </div>
            <div class="form-area">
                <textarea rows="4" class="form-textarea" name="content"></textarea>
                <input type="submit" value="送出" class="form-btn"/>
            </div>
        </form>
    <?php else: ?>
        <div>請先登入後再留言</div>
    <?php endif; ?>
    <div class="line"></div>
    <div class="comments">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="comment">
                <div class="comment__avatar"></div>
                <div class="comment__right">
                    <div class="comment__author"><?= $row['nickname']; ?></div>
                    <div class="comment__time"><?= $row['created_at']; ?></div>
                    <div class="comment_content"><?= $row['content']; ?></div>
                </div>
            </div>
        <?php } ?>
    </div>
  </main>
  
</body>
</html>