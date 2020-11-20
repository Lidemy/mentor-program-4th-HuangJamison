## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼
* varchar 可以設定最大長度，是用在文字量確定的時候，可有預設值
* text 不可預設長度，當文字量不確定時，才使用，不可有預設值
varchar 查詢速度優於 text

## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？
cookie 是一個小型文字檔案，當瀏覽器發送 request 會把 cookie 帶上去 Server 端，常用於驗證身份、購物車、留言板。 cookie 之所以重要是因為瀏覽器與 Server 之間的 session 機制會利用 cookie 實作，cookie 內有時間、網域等設定，且不能在其他網域設定不是該網域的 cookie，因此可以利用 cookie 表示一段時間的狀態，去實作 seesion機制。
登入機制大致上流程： 瀏覽器發送 request 給 server， 確認過資料後，Server 叫 browser 設置 cookie ，browser 把cookie 資料存在 cookie header 上，待下次登入，browser 帶上 cookie 發 request ，Server 根據 cookie 的內容，決定回傳狀態與內容

HTTP 如何實作 cookie? 
1. 利用 setcookie & db
   當 token 與 db 一樣時才取 username
```php
// 設定 cookie
setcookie('token', $token, time() + 3600*8);
// 比對 cookie & db
$token = 0;
if (!empty($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
}
$username = getUsernameFromCookie($token);
// 刪除 cookie 讓他到期
setcookie('token', '', time() - 3600*8);
```
1. php 內建設置 cookie 
```php
```php
// 寫入 cookie
session_start();
$_SESSION['username'] = $username;
// 驗證
// 改為用 session 判斷
session_start();
$username = '';
if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
// 清除 cookie
session_start();
session_destroy();
```


## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？
1. 如果 cookie 只是存 username, account 很容易被盜用，因為可以讓駭客假冒身份。
2. 另外密碼部分，在 Server 端也不應該知道使用者的密碼，為了安全性需要加密處理
3. 帳號密碼可以增加一些格式設定，增加安全性。大小寫等等
4. 沒防範寫入 js 或是 html，如果故意寫 `alert` 好像也不好 
5. 我覺得前端也可以防範一下惡意寫入的帳號密碼，避免有意之人
