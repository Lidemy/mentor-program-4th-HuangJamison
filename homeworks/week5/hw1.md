## 前四週心得與解題心得
1. 解題的心得(挑幾題比較有趣或卡住的)
### 1005 相親數
這題蠻浪漫的，也不難解，就是把輸入數字，稱作A，把A的因數加起來，扣除自己後，得到相親數，再將相親數的因數素加起來後扣除自己，姑且成為B，如果 A===B，就是相親數
```js
function loveNumber(num) {
    num = Number(num);
    let loopLength = Math.floor(num/2);
    let love = 0;
    for (let i=0; i<=loopLength; i++) {
        if (num % i === 0) {
            love += i;
        }
    }
    loopLength = Math.floor(love/2);
    let prove = 0;
    for (let j=0; j<=loopLength; j++) {
        if (love % j === 0) {
            prove += j;
        }
    }
    if (prove === num) {
        console.log(love);
        return;
    }
    console.log('QQ');
}
```
### 1006 座位
一開始蠻沒有頭緒的，想說沒有規律啊(雙手一攤)XDD
但後來，用一個很爛的規律，就是奇數會有兩種聯誼座位(自己與自己+1 & 自己與自己+2)ex: 3&4, 3&5，但偶數只有一種(自己與自己+2) ex: 4&6，然後去看可入座的陣列有沒有這個座位這樣，然後還真的可以過
也蠻想看看別人的做法的，有點像 Leetcode，如果有程式執行速度前 10%的可以讓後面的人改進他的寫法。
```js
var readline = require('readline');
var rl = readline.createInterface({
    input: process.stdin
});

var lines = [];

rl.on('line', function (line) {
    lines.push(line);
});

rl.on('close', function() {
    // ctrl+D
    solve(lines); // 執行 solve function
});

// 解題 聯誼作法
function solve(lines) {
    const chair = lines[0];
    const chairAry = [];
    const removed = lines[1];
    const removeNum = lines.slice(2).map((num) => Number(num));
    for (let i=1; i<=chair; i++) {
        if (!removeNum.includes(i)) {
            chairAry.push(i);
        }
    }
    let outcome = 0;
    for (let i=0; i<=chairAry.length-1; i++) {
        if (chairAry[i] % 2) {
            if (chairAry.includes(chairAry[i]+1)) {
                outcome +=1;
            }
            if (chairAry.includes(chairAry[i]+2)) {
                outcome +=1;
            }
            continue;
        }
        if (chairAry.includes(chairAry[i]+2)) {
            outcome +=1;
        }
    }
    console.log(outcome)
}
```
### httpGame lv3
練習 POST ，也看了一些 HTTP 的資料，先用 post 用 form 去包要 post 的資料
```js
// lv3
const request = require('request');
const url = 'https://lidemy-http-challenge.herokuapp.com/api';
try {
    const options = {
        'url': `${url}/books`,
        'Content-Type': 'application/x-www-form-urlencoded',
        'form': {
            'name': '大腦喜歡這樣學',
            'ISBN': '9789863594475'
        }
    }
    request.post(options, (err, res, body) => {
        console.log(res);
        console.log(body);
    })
} catch (err) {
    console.log(err);
}
```
### httpGame lv4
當傳入為中文字時，要記得 encode
```js
const request = require('request');
const parms = process.argv.slice(2);
const url = 'https://lidemy-http-challenge.herokuapp.com/api';
try {
    const query = encodeURIComponent('世界');
    request(`${url}/books?q=${query}`, (err, res, body) => {
        console.log(body);
    });
} catch (err) {
    console.log(err);
}
```
### httpGame lv6
這邊卡了一下，因為不知道題目的意思，要帶上 Authorization，於是看了 HTTP的資料要放在 headers 內。
```js
const request = require('request');
const buffer = require('buffer').Buffer.alloc;
const url = 'https://lidemy-http-challenge.herokuapp.com/api/v2';
try {
    const pass = 'admin:admin123'
    const base64pass = Buffer.from(pass).toString('base64');
    console.log(base64pass);
    const options = {
        url: `${url}/me`,
        headers: {
            Authorization: `Basic ${base64pass}`
        }
    };
    request(options, (err, res, body) => {
        console.log(res);
        console.log(body);
    });
} catch (err) {
    console.log(err);
}
```
### httpGame lv8
前面很順利，後面犯傻忘記 slice(開頭index, 結尾index)搞錯，還跑去煩老師 @_@
練習用 async await 去取得資料後帶回去，拿到通關密碼
```js
const request = require('request');
const buffer = require('buffer').Buffer.alloc;
const params = process.argv.slice(2);
const url = 'https://lidemy-http-challenge.herokuapp.com/api/v2';
const pass = 'admin:admin123'
const base64pass = Buffer.from(pass).toString('base64');
try {
    const options = {
        url: `${url}/books`,
        headers: {
            Authorization: `Basic ${base64pass}`
        }
    };
    let errorBook = {};
    let data = [];
    let updateOptions = {};
    function findErrorBook() {
        return new Promise((resolve, reject) => {
            request(options, (err, res, body) => {
                data = JSON.parse(body);
                for (let i=0; i<=data.length-1; i++) {
                    if (data[i].name.indexOf("我") >=0 && data[i].author.length == 4 && data[i].ISBN[data[i].ISBN.length - 1] == 7) {
                        errorBook = data[i];
                        break;
                    }
                }
                if (errorBook) {
                    let revised =  errorBook['ISBN'].slice(0, errorBook['ISBN'].length - 1) + '3';
                    errorBook['ISBN'] = revised;
                    resolve(errorBook);
                }
            });
        });
    }
    function updateBook(bookInfo) {
        return new Promise((resolve, reject) => {
            const updateOptions = {
                url: `https://lidemy-http-challenge.herokuapp.com/api/v2/books/${bookInfo.id}`,
                headers: {
                    Authorization: `Basic YWRtaW46YWRtaW4xMjM=`
                },
                contentType: 'application/x-www-form-urlencoded',
                form: {
                    name: '日日好日：茶道教我的幸福15味【電影書腰版】',
                    ISBN: bookInfo.ISBN
                }
            };
            request.patch(updateOptions, (err, res, body) => {
                if (body) {
                    console.log(JSON.parse(body));
                    resolve(body);
                }
            });
        });
    }
    async function fixErrorBook() {
        let bookInfo = await findErrorBook();
        let result = await updateBook(bookInfo);
        console.log(result);
    }
    fixErrorBook()
} catch (err) {
    console.log(err);
}
```

2. 心得與心境上的度過
之前會發現這個計畫，是去年離職時，大約自己自學兩個月後，發現自己的學習計畫有點亂，當時的我想過兩條路要走，
(1) data analysis
(2) 前後端
考慮到現實以及成功機率，選擇前後端，也發現到這個導師計畫，更看了 Huli 的學習之路，發現這跟我之前的學習方式截然不同，過去我的方式是
(1) 以前我都是等老師給我整理好的知識，我只要吸收起來就好
(2) 考試去驗證輸入，這裡指的是用考試表示你到底會不會這些知識
但程式是有點翻轉這個概念，也讓我的腦袋更加活化
(1) 當面對一個問題時，你必須將抽象的問題，先寫在在紙上，了解問題本身，再去查詢相關資料，等完全理解後，再去解題，當然解題也會遇到跟你想像中不一樣的事情，你必須再回去找資料，並利用資料整理成資訊找尋答案，解出問題
(2) 用作品當作驗證你的輸入，這點我蠻認同的，做出一個小作品，可以讓你知道從無到有，並複習一下你所學的知識，並試著用自己的話講出來。
其實蠻感謝有這個計畫的，有一個 guideline 帶我一步一步走，目前我是白天有工作，所以我在 week3 後，會選擇挑比較不熟的單元才看影片，熟的單元看之前做過的筆記，並將筆記轉化成自己的知識。

老實說，目前有一些些力不從心，不是課程太難，是我自己心態上會害怕跟不上課程，或是在現實世界中誘惑的取捨，例如：朋友約出去打球跟在家 coding，但跟朋友出去打完球後會約吃飯、回家洗澡又會想放鬆一下，造成自己要進入心流又需要一些時間，但其實要勇敢拒絕一些誘惑，做好時間管理與目標訂定，是我8月與9月必須做到的事情，共勉之。