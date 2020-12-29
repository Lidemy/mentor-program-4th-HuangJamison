<?php
    // 載入 conn.php
    require_once('conn.php');
    session_start();
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    $userAuth = '';
    if ($username) {
        $stmt = $conn->prepare('SELECT auth FROM Jamie_users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $userAuth = $stmt->get_result();
        $userAuth = $userAuth->fetch_assoc();
        $userAuth = $userAuth['auth'];
    }
    if (!in_array($userAuth, ['admin', 'manager'])) {
        echo '壞孩子，你的權限不足以看這個頁面';
        die();
    }
    $stmt = $conn->prepare('SELECT id, username, nickname, auth FROM Jamie_users');
    $stmt->execute();
    $result = $stmt->get_result();
    $authReferer = [
        'admin' => '掌管權力的辣個人',
        'manager' => '高官',
        'normal' => '一介平民',
        'forbidden' => '褫奪公權'
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>權限大表</title>
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
        max-width: 800px;
        background-color: white;
        margin: 15px auto;
        padding: 20px;
    }
    .title {
        font-size: 30px;
        font-weight: lighter;
        margin: 15px 0;
    }
    .form-title {
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 10px;
    }
    .form__register {
        margin: 0 auto;
    }
    .form-area {
        display: flex;
        flex-direction: column;
    }
    .form-input {
        border: 1.5px solid #FFE4E1;
        width: 20%;
        height: 25px;
        margin: 10px 0;
    }
    .form-btn {
        border: 2px solid #FFE4E1;
        padding: 10px;
        background-color: white;
        height: 40px;
        width: 50%;
        margin-top: 20px;
        margin: 0 auto;
    }
    .nav__btn {
        text-decoration: none;
        border: 2px solid #FFE4E1;
        padding: 10px;
        color: black;
        margin: 20px;
        margin: 0 auto;
    }
    .userlist {
        margin: 0 auto;
    }
    .userlist th,td {
        padding: 10px 15px;
    }
</style>
<script src="jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
      $('.change_auth_area').click((e) => {
        e.preventDefault();
        const id = e.target.dataset.id;
        const auth = e.target.dataset.auth;
        console.log('auth:', auth)
        if (!id || !auth) {
            alert('改變不了權限');
            return;
        }
        const url = './handle_update_auth.php';
        $.ajax({
            url : url,
            data: {
                'id': id,
                'auth': auth
            },
            method : 'POST',
            success : function (data) {
                if (data && data.status == 'success') {
                    alert('改變權限成功');
                } else {
                    alert('你改變權限失敗');
                }
                location.reload();
            },
            error : function (error) {
                alert('你改變失敗...');
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
    <a class="nav__btn" href="index.php">首頁</a>
    <a class="nav__btn" href="logout.php">登出</a>
    <h1 class="title">使用者權限列表</h1>
    <hr>
    <div class="description">
        <li>
            admin 為主管生殺大權的人
        </li>
        <li>
            只有高官以上才能進入後台管理權限
        </li>
        <li>
            剛註冊的人都是平民
        </li>
    </div>
    <table class="userlist">
        <tr>
            <th>username</th>
            <th>nickname</th>
            <th>authorization</th>
            <th>auth change</th>
        </tr>
        <?php if (!empty($result)): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= escape($row['username']); ?></td>
                    <td><?= escape($row['nickname']); ?></td>
                    <td><?= escape($authReferer[$row['auth']]); ?></td>
                    <?php if ($row['auth'] != 'admin'): ?>
                    <td class="change_auth_area">
                        <?php foreach ($authReferer as $key => $value): ?>
                            <?php if ($row['auth'] == $key) : ?>
                                <a style="text-decoration: none"><?=escape($value);?></a>
                            <?php elseif ($key != 'admin'): ?>
                                <a href="./handle_update_auth.php" data-id="<?= $row['id'];?>" data-auth="<?= $key;?>"><?=escape($value);?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <?php endif; ?>
                </td>
            <?php endwhile; ?>
        <?php else: ?>
            無任何使用者資料
        <?php endif; ?>
    </table>
  </main>
  
</body>
</html>