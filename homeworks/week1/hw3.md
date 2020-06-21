## 教你朋友 CLI

### 首先什麼是 CLI
使用者與電腦溝通，通常靠兩種方式，第一種是 GUI (graphical user interface)，使用者依靠圖形介面對電腦溝通，這也是平常我們最熟悉的方式。
另一種是 CLI (command line interface)，使用者對下電腦下指令
### 常見電腦指令，如下：
1. `ls` 
   
   代表列出 list 
   -a 代表把隱藏的檔案列出來
   -l 就列出比較 detail 資訊，，包含權限、擁有者、修改日期資訊
2. `cd`
   
   開啟的意思
   `cd ..` 回上一層
   `cd ~` 使用者根目錄
3. `man (填入不懂的指令)`

   懶人求救包，把不懂的指令丟進去
   ex: `man ls`
4. `touch` 
   建檔或是更改檔案時間
5. `rm` 刪檔案
    `rmdir & rm -r` 刪 folder
    `rm -f` 強制刪除拉
6. `mkdir` 建立folder
7. `mv` 
   可當成移動或是改名
   ex: `mv test123.txt folder` 把txt 移到 folder
   `mv test123.txt test5566.txt` 把 檔名改成 test5566
8. `cp test123.txt copytest123.txt` 複製檔案
   `cp -r folder ` 複製資料夾
9. vim 
    軟體必備的小書
    i 編輯
    esc 回 read 模式
    q! 不存離開
    wq 存檔離開
10. `cat 檔案` => 抓內容
11. `grep abc test123.txt` 在 test123.txt 抓關鍵字 abc
    自己工作上是用 `ack 'abc' test123.txt`
    * 找特定檔案
    `find . -name 'test123.txt'`
    `ack -g test123.txt`
12. `curl (url)`
    這個我之前沒學過，可以打需求到某網站
    可用來測 api
    拿 header
    `curl -I (url)` 
13. 重新導向 redirection
    類似寫入或新增某資訊到某處
    * 把 ls-al 資訊寫入(覆蓋) txt
    `ls -al > test123.txt`
    * 把 ls-al 新增資訊 txt
    `ls -al >> test123.txt`
### 動手試試看
剛剛看同學都是用新增資料夾跟移動檔案，我試試看講解別的
有一天 J米想炫耀某些技能給女性友人

正妹：我電腦有個檔案不知道放在哪裡耶!

Ｊ米：什麼檔案？

正妹：統計學_final.ppt 不知道放到哪，我忘記了

J米：真是不小心，我常常也把我女朋友給弄丟，OS(修電腦就可以講一些爛梗，反正她有求於我)

J米：我先幫你安裝 brew，以後很多功能可以自己試試看
`/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"`

`brew install ack`
J米：利用 ack -g 可全域搜尋
`ack -g '統計學_final.ppt'`

正妹：太帥了吧！

J米：你就放在桌面的雜物資料夾啊！不能把這麼重要檔案亂放!

正妹：謝謝你救了我的統計期末

太多幻想XD end~
### 補真正教學，剛剛才看到
學了一項東西之後若是想驗證自己是不是真的懂，教別人是最快的方法。

有天，你的麻吉 h0w 哥跑來找你說：「欸！能不能教我 command line 到底是什麼，然後怎麼用啊？我想用 command line 建立一個叫做 wifi 的資料夾，並且在裡面建立一個叫 afu.js 的檔案。就交給你了，教學寫好記得傳給我，ㄅㄅ」

可...可惡，居然這樣子就跑走了。但因為他是你的麻吉，所以你也沒辦法拒絕。

因此這個作業要請你寫一篇簡短的文章，試圖教會 h0w 哥什麼是 command line 以及如何使用，並且要教他如何達成他想要的功能。
現實總是這樣，以為是正妹請你幫忙，結果是好麻吉
h0w: 怎麼建立資料夾啊? 教一下啊～工具人

Ｊ米：伸手牌哦～你先 `mkdir wifi`

h0w: 真的噎！後來哩～

J米：給你問不用錢的哦，然後，就 `cd wifi`，進入資料夾內

J米：趕快教一教，等等還要幫正妹上課，`touch afu.js` 就是建立檔案囉

h0w:你真的會噎，趕快教這個給阿福

J米：艮，我被背叛了...可惡