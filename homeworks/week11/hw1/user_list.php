<?php
    // 載入 conn.php
    require_once('conn.php');
    $stmt = $conn->prepare('SELECT username, nickname FROM Jamie_users');
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者列表</title>
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
<body>
  <header>
      注意！本站為練習留言板，請勿使用敏感資訊!
  </header>
  <main>
    <a class="nav__btn" href="index.php">首頁</a>
    <a class="nav__btn" href="logout.php">登出</a>
    <h1 class="title">所有註冊使用者</h1>
    <table class="userlist">
        <tr>
            <th>username</th>
            <th>nickname</th>
        </tr>
        <?php if (!empty($result)): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['username']; ?></th>
                    <td><?= $row['nickname']; ?></th>
                </td>
            <?php endwhile; ?>
        <?php else: ?>
            無任何使用者資料
        <?php endif; ?>
    </table>
  </main>
  
</body>
</html>