<?php
    // 載入 conn.php
    require_once('conn.php');
    require_once('utils.php');
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
<script src="jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
      $('.form-btn').click((e) => {
        console.log('http')
        e.preventDefault();
        const username = $('input[name=username]').val();
        const password = $('input[name=password]').val();
        if (!username || !password) {
            alert('資料不齊全');
            return;
        }
        const url = './handle_login.php';
        $.ajax({
            url : url,
            data: {
                'username': username,
                'password': password
            },
            method : 'POST',
            success : function (data) {
                console.log('data:', data)
                if (data && data.status == 'success') {
                    alert('登入成功');
                    location.href = 'index.php'; // 不是 window.location
                }
                if (data && data.status == 'fail') {
                    alert(data.reason);
                    location.href = 'login.php'; // 不是 window.location
                }
            },
            error : function (error) {
                console.log(error)
            }
        })
      });
    });
</script>
<body>
  <nav class="navbar">
    <div class="wrapper navbar__wrapper">
      <div class="navbar__site-name">
        <a href='index.html'>Who's Blog</a>
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
  <div class="login-wrapper">
    <h2>Login</h2>
    <form action="" method="POST">
      <div class="input__wrapper">
        <div class="input__label">USERNAME</div>
        <input class="input__field" type="text" name="username" />
      </div>
      
      <div class="input__wrapper">
        <div class="input__label">PASSWORD</div>
        <input class="input__field" type="password" name="password" />
      </div>
      <input class="form-btn" type='submit' value="登入" />
    </form>
     
  </div>
</body>
</html>
