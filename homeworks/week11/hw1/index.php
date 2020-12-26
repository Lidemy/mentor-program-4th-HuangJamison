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
    $stmt->execute();
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
    $stmt->execute();
    $result = $stmt->get_result();
    // 改為用 session 判斷
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
    .comment__author, .comment__time, .comment__update {
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
    .comment__update, .comment__revised-btn, .comment__deleted {
        margin-left: 5px;
        border: 2px solid #FFE4E1;
        padding: 8px;
        background-color: white;
    }
    .comment_content, .comment__revised-content {
        margin-top: 5px;
        padding: 5px 0;
        word-break: break-word;
        white-space: pre-line;
    }
    .comment__revised {
        border: 2px solid #FFE4E1;
        width: 80%;
        height: 30px;
        margin-right: 10px;
    }
    .comment__revised-btn, .comment__revised {
        display: inline-block;
    }
    .warning {
        color: red;
        font-size: 18px;
        text-decoration: bold;
        margin: 5px 0;
    }
    .form__edit-name {
        margin-left: 10px;
        border: 2px solid #FFE4E1;
        padding: 10px;
        background-color: white;
    }
    .edit-name-submit {
        margin-left: 10px;
        border: 2px solid #FFE4E1;
        padding: 10px;
        background-color: white;
    }
    .hide {
        display: none;
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
      $('.form__edit-name').click((e) => {
        $('.update-name-area').toggleClass('hide');
      });
      $('.edit-name-submit').click((e) => {
        // 確認是否為空
        const editName = $('input[name=edit-name]').val();
        if (!editName) {
            alert('改的暱稱為空哦!!!');
            return;
        }
        const id = $('input[name=edit-name]').attr('data-id');
        const url = './handle_update.php';
        $.ajax({
            url : url,
            data: {
                'edit_name': editName
            },
            method : 'POST',
            success : function (data) {
                if (data && data.status == 'success') {
                    alert(`更新暱稱成功`);
                } else if(data && data.msg){
                    alert(`data: ${data.msg}`);
                }
                location.href = 'index.php'; // 不是 window.location
            },
            error : function (error) {
                alert('error:', error);
            }
        })
      });
      $('.comment__update').click((e) => {
        e.target.parentNode.querySelector('.comment__revised-content').classList.toggle('hide');
        e.target.parentNode.querySelector('.comment_content').classList.toggle('hide');
        e.target.value = '編輯';
        console.log(e.target.parentNode.querySelector('.comment_content').classList.contains('hide'))
        if (e.target.parentNode.querySelector('.comment_content').classList.contains('hide')) {
            e.target.value = '取消編輯';
        }
      });
      $('.comment__revised-btn').click((e) => {
        if (e.target.parentNode.querySelector('.comment__revised').value == '') {
            alert('留言不能為空');
            return;
        }
        const newComment = e.target.parentNode.querySelector('.comment__revised').value
        const url = './handle_update_comment.php';
        const commentId = e.target.parentNode.querySelector('.comment__revised').dataset.id;
        $.ajax({
            url : url,
            data: {
                'id': commentId,
                'content': newComment,
            },
            method : 'POST',
            success : function (data) {
                if (data && data.status == 'success') {
                    console.log(data.status)
                    alert('修改留言成功');
                    location.reload();
                    return;
                    // location.href = 'index.php'; // 不是 window.location
                }
                alert(data.msg);
                location.reload();
            },
            error : function (error) {
                alert('修改留言失敗...');
            }
        });
      });
      $('.comment__deleted').click((e) => {
        const url = './handle_delete_comment.php';
        const commentId = e.target.parentNode.querySelector('.comment__deleted').dataset.id;
        $.ajax({
            url : url,
            data: {
                'id': commentId,
            },
            method : 'POST',
            success : function (data) {
                console.log('data:', data)
                if (data && data.status == 'success') {
                    alert('刪除留言成功');
                }
                location.href = 'index.php'; // 不是 window.location
            },
            error : function (error) {
                alert('刪除留言失敗...');
            }
        })
      })
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
            <?php if (in_array($userInfo['auth'], ['admin', 'manager'])): ?>
                <a href="authorization.php".php"><input type="button" value="權限大表" class="nav-btn"/></a>
            <?php else: ?>
                <a href="user_list.php"><input type="button" value="使用者列表" class="nav-btn"/></a>
            <?php endif; ?>
        <?php else: ?>
            <a href="register.php"><input type="button" value="註冊" class="nav-btn"/></a>
            <a href="login.php"><input type="button" value="登入" class="nav-btn"/></a>
        <?php endif; ?>
    </div>
    <h1 class="title">Comments</h1>
    <?php if ($username): ?>
        <?php if (!empty($userInfo['auth']) && $userInfo['auth'] != 'forbidden'): ?>
            <form class="form__add-comments" method="POST" action="handle_add.php">
                <h2 class="form-title">有什麼想說的嗎?
                    <?= escape($userInfo['nickname']);?><input class="form__edit-name" type="button" value="編輯暱稱"/>
                </h2>
                <div class="hide update-name-area">
                    <input type="text" name="edit-name" data-id="<?= !empty($userInfo) ? $userInfo['id'] : 0 ;?>" placeholder="填入要更換暱稱"/>
                    <input class="edit-name-submit" type="button" value="更改暱稱"/>
                </div>
                <div class="warning">
                    <?= !empty($_GET['error']) && $_GET['error'] == 1 ? '送出資料不齊全' : '';?>
                </div>
                <div class="form-area">
                    <textarea rows="4" class="form-textarea" name="content"></textarea>
                    <input type="submit" value="送出" class="form-btn"/>
                </div>
            </form>
        <?php else:?>
            <div>你被褫奪公權無法新增留言，請洽管理員</div>
        <?php endif; ?>
    <?php else: ?>
        <div>請先登入後再留言</div>
    <?php endif; ?>
    <div class="line"></div>
    <?= '總共有' . $totalNum . '筆留言'; ?>
    <div class="comments">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="comment">
                <div class="comment__avatar"></div>
                <div class="comment__right">
                    <div class="comment__author"><?= escape($row['nickname']); ?> <?= '(@' . escape($row['username']) . ')'; ?></div>
                    <div class="comment__time"><?= escape($row['created_at']); ?></div>
                    <?php if (!empty($userInfo) && $row['username'] == $userInfo['username']): ?>
                        <input class="comment__update" data-id="<?= $row['comment_id'];?>" type="button" value="編輯"/>
                    <?php endif;?>
                    <?php if (!empty($userInfo) && $row['username'] == $userInfo['username']): ?>
                        <input class="comment__deleted" data-id="<?= $row['comment_id'];?>" type="button" value="刪除"/>
                    <?php endif;?>
                    <div class="comment_content"><?= escape($row['content']); ?></div>
                    <div class="hide comment__revised-content">
                        <input name="comment__revised" data-id="<?= $row['comment_id'];?>" class="comment__revised" type="text" value="<?= escape($row['content']); ?>"/><input class="comment__revised-btn" type="button" value="送出"/>
                    </div>
                </div>
            </div>
        <?php } ?>
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
    </div>
  </main>
  
</body>
</html>