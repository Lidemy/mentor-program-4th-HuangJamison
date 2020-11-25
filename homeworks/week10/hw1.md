## 六到十週心得與解題心得
* 來回顧一下第六週到第十週做了哪些事情? XD 但其實我應該用了 10 週的時間，有點怠惰，但總比在原地踏步好吧? 
### 第六週
1. 首先先過一下 HTML & CSS，這部分應該算是蠻熟的，花了2~3個晚上的時間，之後就開始作業。
2. 作業讓我更熟悉使用 flex 的技巧，並且學會如何將網頁切成一個又一個的 box
3. 複習 box model 與 position 
    * inline: 並非 block，無法自成一行，也就是會擠在同一行，不能設定 margin 的上下，只能調左右 margin，** 沒有 width & height **，元素因沒寬高，因此要由內容撐開
    * static: 預設為 staic，就是一列一列排下來
    * relative: 只會針對本身作位移，不會影響其他元素位置，可使用 top 、 bottom、 left 、 right 的屬性來定義它的位置，常用於父層搭配子層 absoulte
```css
  /* 從原本位置下移動 50px 向右邊移動 30px */
  .relative_object {
     position:relative;
     top:50px;
     left:30px;
  }
```
    * absolute: 根據上層位置，找到上層為 relative 的父層做為參考點，參考點的設置就是以設置 absolute 的位置往上找不是 static 的元素，做為參考點，通常以relative 作為定位點，如無上層定位點則以body作為定位點
### 第七週
1. 複習 DOM 物件，如何檢查表單
2. 用 class 去控制 html
3. todo list 製作：如果監聽做好做在父層
* 簡而言之是在複習一次 js DOM 的一週
### 第八週
* 困難的一週，我去年也是這麼困難 T^T
1. 跟第四週不同在於之前是用 nodejs 去發 request，現在藉由 browser 去發 req
2. 然而在認識一次 ajax ，其實就是非同步去取得資料，讓使用者有更好的瀏覽體驗
3. 用瀏覽器發跟 Nodejs 發差別在於瀏覽器發送請求，請求發出去了，但瀏覽器基於安全性會先把 response 卡住，不讓我們拿到，因此，要符合瀏覽器的限制，並熟知瀏覽器與網路協定，才能
迎刃而解。
4. 練習用 XMLHttpRequest 做非同步取得資料顯示抽獎結果
5. twitch 串接 API ，先獲得前五名熱門遊戲，再去抓出熱門遊戲熱門實況並用 js 渲染到網頁上
6. 發現 await 如果要接回傳值，則後面的 function 需要是 promise，否則會回傳 undefined
   這點想請教助教與老師，如果 getTopFiveGame 不是 promise，應該topFive 就是 undefined
```js 
const topFive = await getTopFiveGame();
function getTopFiveGame() {
  return new Promise((resolve, reject) => {
    xhr.open('GET', `${url}/games/top?limit=6`, true);
    xhr.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
    xhr.setRequestHeader('Client-ID', clientID);
    xhr.send();
    xhr.onload = () => {
        ...省略
    };
  });
}
```
### 第九週
1. php 訓練週，熟悉 php & db
2. 用 cookie 實作 session 機制
* cookie 是一個小型文字檔案，當瀏覽器發送 request 會把 cookie 帶上去 Server 端，常用於驗證身份、購物車、留言板。 cookie 之所以重要是因為瀏覽器與 Server 之間的 session 機制會利用 cookie 實作，cookie 內有時間、網域等設定，且不能在其他網域設定不是該網域的 cookie，因此可以利用 cookie 表示一段時間的狀態，去實作 seesion機制。
* 登入機制大致上流程： 瀏覽器發送 request 給 server， 確認過資料後，Server 叫 browser 設置 cookie ，browser 把cookie 資料存在 cookie header 上，待下次登入，browser 帶上 cookie 發 request ，Server 根據 cookie 的內容，決定回傳狀態與內容
### 第十週
1. 訓練利用 browser 找各種資訊的敏感度，如何用 source 內的 css 與 php & html 找尋失蹤的資料
* lv1 轉成 18 進位 給予 2 進位 100101001001100001110

```js
let normalNum = parseInt('100101001001100001110', 2); // 將2進位轉回 10 進位 首個參數為 string
let num18 = normalNum.toString(18); // 轉成 18 進位
console.log(num18)
```

* lv7 用 decodeURI 去解碼
* lv8 要看 response Header headshot
* lv9 破關要看程式碼 ord ascii 反正就是讓他除起來整除就好
```php
function isTokenValid($token) {
    if (strlen($token) !== 8) return false;
    for($i = 1; $i <= 7; $i+=2) {
        echo ord($token[$i]) * ord($token[$i - 1]) . '<br/>';
        if ((ord($token[$i]) * ord($token[$i - 1])) % $i !== 0) {
            return false;
        }
    }
    return true;
}
var_dump(isTokenValid('aaccddbb'));
var_dump(ord('c'));
```
* lv10 sosdan post 要注意 CORS ，因為 browser 限制，所以利用 nodeJS 去拿
```js
const axios = require('axios');
axios.post('https://glacial-everglades-11859.herokuapp.com/api.php')
    .then((res) => {
        console.log(res);
    })
    .catch((err) => {
        console.log('err:', err)
    })
```