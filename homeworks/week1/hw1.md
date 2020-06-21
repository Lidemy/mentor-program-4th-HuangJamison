## 交作業流程
1. 首先老師已經幫我們做好 fork 的事情
2. 我先從遠端複製一份到 local 端 : 
   `git clone git@github.com:Lidemy/mentor-program-4th-HuangJamison.git`
3. 目前所在位置為 master 
4. 新開一個 branch week1 為寫作業的好所在: `git branch week1`
5. 切換至 branch week1
   `git checkout week1`
6. 寫作業中 ...
7. 寫完作業後，確認一些改動
   `git diff 檔案`
8. 把作業加入 staged 區
   `git add 檔案`
9. 把作業從 staged 區交付於 commit，更改 week1 branch 的變動
    `git commit -m "week1 finish"`
10. 自我檢討，如有錯誤先自己修正
    `git add 修正檔案`
    `git commit -m "week1 自我檢討"`
11. 將 local 寫完的作業同步於遠端 repo
    `git push origin week1`
12. 發送 PR 前，自己先檢查程式碼，以及 PR 細節
13. 發送 PR 與跟助教說明此次作業遇到的狀況
14. 交作業後看參考解答
15. 等待助教 merge 以及助教會刪除線上 branch
16. 最後，刪除本地端 branch 
    `git branch -d week1`