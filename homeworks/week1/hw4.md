## 跟你朋友介紹 Git
### 題目
因為你的人實在是太好，時不時就會有朋友跑來找你來幫忙。

這次來的是一個叫做菜哥的朋友，會叫做菜哥是因為家裡賣菜，跟你認識的其他人同名的話純屬巧合。

菜哥：「就是啊，我最近有一個煩惱。因為我的笑話太多了，所以我目前都用文字檔記錄在電腦裡，可是變得越來越多之後很難紀錄，而且我的笑話是會演進的。會有版本一、版本二甚至到版本十，這樣我就要建立好多個不同的檔案，弄得我頭很痛，聽說你們工程師都會用一種程式叫做 Git 來做版本控制，可以教我一下嗎？」

『好吧，我試試看』

菜哥：「謝啦，話說你來參加這個計畫學程式真的選對了欸，之後就不會有貧血的困擾了」

『為什麼』

「因為你會寫程式」

『...』

「喔...原來是血乘四的部分啊（拍手）」

就是這樣，在一陣尬聊之中你答應了菜哥的要求，要教他怎麼使用 Git 來管理他的笑話。

因此，你必須教他 Git 的基本概念以及基礎的使用，例如說 add 跟 commit，若是還有時間的話可以連 push 或是 pull 都講，菜哥能不能順利成為電視笑話冠軍，就靠你了！

### 教學香腸
哎！我以為會是正妹，又是一個問不用錢的
J米： 蔡哥，你就直講，你又什麼不會的拉！一秒鐘幾十萬上下！

蔡哥：J米，你教會我，我約泱泱出來！

J米：OK！你可以把笑話用版本控制啊！來哦！認真講

蔡哥：翻臉比翻書還快

* GIT 是一個版本控制的程式，我們都知道一個檔案有不同版本，**但我們利用git把不同版本的檔案搭配記錄起來**，就是版本控制，通常團隊專案會有個 master，但我們不直接修改這份，我們會 fork 一份到我們 github ，然後也會複製一份到我們本機，現在我們有個完美的鐵三角，就像你、我、泱泱一樣。

1. 如果你看到別人笑話不錯，你想要如法炮製，首先，先 fork 一份到你的 github

2. 然後你看到那個 ssh 有沒有，先 `ctrl+c` ，進入 cmd ， `cd desktop` & `git clone (ssh url)`，這是在你的終端機建立一份一模一樣的檔案，這份 folder ，我們稱為本機，我們所有修改，先對本機做編輯。
   
3. 通常我們會 `git init`加入 `.git`檔案，但現在這份檔案裡已經有 `.git`了，代表我們有了版本控制的概念在這裡面

4. 來 `git status` 就是查看我們現在檔案的狀態，可以看到非常乾淨，因為我們還未改動，首先，我會把本機端的 master 當作是同步自己遠端的 branch，當我確認這個 branch 已經同步自己遠端 github上最新的資訊時，我們就可以開始開發了!

5. 因為我不想要污染 master ，所以第一步我們先 `git branch dev`，創立新的 branch
   
   備註：雖然平常上班我是反過來會有一個 upstream 去 track 協同合作的專案，master 主要開發，如要多個開發則會再切 branch

6. 接下來，我們可以在 dev 這邊改動檔案，先假設我們改動好了，`git status` 可以看到許多改動過的檔案，如下圖。
   ![git status](https://cdn-images-1.medium.com/max/1000/1*qz5OlHSM0Gn5vnQMuk0VIA.png)

7. 這時候我們會把檔案移交到 staged 區，用 `git add homeworks/week1/hw1.md`，加入版控
   ![git add](https://cdn-images-1.medium.com/max/1000/1*NaQSN737C5xN5eXdoZPjQw.png)

8. 這時候這些檔案還未變成一個版本，只是加入版本控制，我們要變成一個版本就是，`git commit -m "hw1 finish"`
   
9. 用 `git log --oneline` 可以看一下目前本機的版本紀錄
    
10. 你想把本機的檔案推上去雲端 `git push origin dev` origin 是本機遠端的名字 master ， dev 是本機 branch，就是代表你要把本機 dev 推上去自己遠端 github 上。
    
11. 如果你覺得你很有自信，想挑戰原作的笑話，可以發出 PR (pull request)
    PR 我的解讀就是在 github 上做 merge 

12. 如果幸運的，對方願意 merge ，且對方近期也有些改動可以將其變動同步於我的本機端
    `git pull (原作ssh url) master`

13. 將其變動推上自己遠端
    `git push origin master`

蔡哥：太好了！我可以去教泱泱了

J米： 這個叛徒... 可惡...

J米： 沒關係！有一次我去買手搖杯，正妹店員問我要不要袋子，我說我要袋子，女店員對我說：再一塊吧
     於是，我跟女店員就在一起了！
J米＆蔡哥：（％％％％拍手) 原來是再一塊的部分呢....
### 補充
我的作法
通常我們會做兩條
1. 第一條是為了自己本地 master 這一條對應到自己 github repo 的 master
2. 會先 fork，然後 git clone 自己 github repo，所以會做下面這些
3. git remote add origin 自己 github ssh url (因此 origin 就是自己 github repo 遠端的名字)
4. git push origin master (將本地第一次改動推上 origin 也就是自己 github repo)
因此本地 master 是對應自己 github repo master
5. 第二條是為了自己本地 upstream 這一條對應到共同開發 github repo 的 master，用來追蹤共同開發最新的改動，會做以下這些
6. git remote add work-repo ssh url (因此 work-repo 就是遠端共同開發 github repo 的名字)
7. git fetch work-repo (用來載入遠端的所有版本)
8. git branch --track upstream work-repo/master (這裡創建一個 branch 叫 upstream，並把 upstream 去追蹤遠端共同開發 github repo (work-repo))
9. 也就是說，當我切到 upstream 這個 branch，我會 git pull work-repo master) 這個意思就是把遠端的最新版本變動抓到 upstream
10. 通常我做新功能，會在本地新開一個 branch，暫時叫 local-dev 等我開發完，我會把 local-dev stash 後，在 local-dev 將其 merge 第二條 upstream ，確保是最新的版本，再把剛剛 stash 的開發拿進來
總而言之，要確認自己本地端要 push 上去前，是否為共同開發的最新版本，再進行 push
