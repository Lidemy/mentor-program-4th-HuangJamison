<?php
    // 載入 conn.php
    require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
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
</style>
<script src="jquery-3.5.1.js"></script>
<script>
    $(document).ready(function() {
      $('.form-btn').click((e) => {
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
  <header>
      注意！本站為練習留言板，請勿使用敏感資訊!
  </header>
  <main>
    <a class="nav__btn" href="register.php">註冊</a>
    <a class="nav__btn" href="index.php">首頁</a>
    <h1 class="title">Login</h1>
    <form class="form__register" method="POST" action="">
        <div class="form-area">
            username：<input type="text" name="username" class="form-input"/>
            password：<input type="password" name="password" class="form-input"/>
            <input type="submit" value="登入" class="form-btn"/>
        </div>
    </form>
  </main>
  
</body>
</html>