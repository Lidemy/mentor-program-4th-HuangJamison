## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫
加密與雜湊不一樣，不同點在於hash 不行解密，因為其是亂碼造成，所以有極低的機率會產生碰撞，也就是說有可能有多個密碼指向同一個雜揍後的密碼。
通常網站忘記密碼不是告訴你的原始密碼，而是叫你重新在設定一個，因為網站DB存的是 hash ，也根本不知道你的原始密碼
常見有: SHA, MD, BLAKE
但加密是可以解密的，也就是說還是有機率是可以破解密碼的，加密需要密鑰，因此獲得密鑰是可以逆向解出 input

## `include`、`require`、`include_once`、`require_once` 的差別
* include: 通常用於 if, else, while 等，include 引入動態程式碼，反正要有判斷引入檔案要用 include 比較合適
* require: 引入靜態內容，一開始載入時，會引入檔案，我常用於 require_once
* require_once、include_once: 在引入檔案前，會先檢查檔案是否已經在其他地方被引入過了，若有，就不會再重複引入。
* 重點在於 require 會噴錯，讓程式不再往下執行，但 include 如果引入檔案有錯，則發生警告，會繼續進行
## 請說明 SQL Injection 的攻擊原理以及防範方法
SQL Injection 是 hacker 利用程式漏洞，去利用填字的方式組出資料庫語法，不當拿出使用者資料。
* 原先撈出使用者資料
```sql
SELECT * from users where username = 'aa'  and password = 'bbb'
```
* 下面這句基本上根本不管 Session 使用者是誰、密碼是多少，填入`' or 1=1#`，因為 `'`封起來，且 or 1=1 代表全部取出， # 又註解了後面密碼
```sql
SELECT * from users where username = '' or 1=1# and password = 'bbb'
```
解決方式為 prepare statement
   * 第一步驟： 用 ? 去代替 %s
   * 第二步驟： 用 prepare 去預處理
   * 第三步驟： 用 bind_params()
   * 第四步驟： 執行 excute()
   * 第五步驟： 當沒錯時，用 get_result() 拿回結果
```sql
$stmt = $conn->prepare("SELECT nickname FROM Jamie_users 
    WHERE username = ?");
$stmt->bind_param("s", $username);
$result = $stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
```
##  請說明 XSS 的攻擊原理以及防範方法
XSS 原理是在拿取使用者網域的敏感資料，將網域的資料利用 script 傳到
hacker 要竊取的地方，或是在剛開啟網頁時，導至釣魚網站
* 舉例:
    通常會放在一張隱藏圖片 <img> (因為不受同源政策影響)，然後在 src 裡面發送一個 帶著 cookie 資訊的 reqeust，傳送到自己的 Server，這樣就可以拿到點此網址的使用者 cookie 了
* 解法在任何輸出資料時都 escape，php 跳脫字元的內建函式 htmlspecialchars，這樣輸出皆為純文字不會被解析為程式碼
## 請說明 CSRF 的攻擊原理以及防範方法
原理是透過圖片或是連結方式，讓使用者在不經意的情況下把 A 網域的敏感資訊帶去 B 網域。
CSRF 成立點在於使用者登入狀態，因此可以設計一些陷阱(表單、圖片)，讓使用者發出 A 網域的 cookie ，發出 request 即可以。
* 加上圖形驗證碼、簡訊去確認是本人操作等
* 利用 csrf token 因為是在 A 網域發出的 token， Server 端可以去比對 session 等。
* 可以利用 sameSite cookie 將 cookie 加一層驗證，絕對不允許跨站請求，等於是在通行證上再加上一層電子鎖
* SameSite 有兩種模式：Strict 、Lax
    * strict 嚴格
        <a href=""></a>, <form>, new XMLHttpRequest… 等標籤，只要不同 domain 都不會帶上此 Cookie
    * Lax 寬鬆
        上述標籤可以帶上 cookie
        除了 Get 方法，其他的 POST、DELETE、PUT… 都不會帶上 Cookie
        意思是 Lax 模式之下就沒辦法擋掉 GET 形式的 CSRF
        所以某些網站會準備兩種 cookie，一般瀏覽網頁時、帶上沒有 samesite 的 Cookie。

    * 當使用者有敏感操作（如：購買、帳戶…等），會帶上 SameSite=strict 的 Cookie，所以如果從外部網站發 B 網站的 request 就會要求重新登入，讓攻擊者無法 CSRF