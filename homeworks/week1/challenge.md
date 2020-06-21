## shell script
* shell script 是一個程式化腳本，也就是可以用 shell 寫一個程式，簡單來說就是在純文字的腳本內寫一些邏輯達成你想做的事情
* shell script 可以是批次檔
* 鳥哥說 shell script 可以幫助我們每日自動化管理，我想就是類似 cronjob 吧
* 追蹤與管理系統的重要工作，這裡應該是說開機的各種參數，或是測試機的參數，原來我們公司 DevOps 超級會這種東西XD
* 簡單入侵偵測功能，可以利用登錄的檔案去看是否有人入侵
  鳥哥這邊有說：當該封包嘗試幾次還是連線失敗之後，就予以抵擋住該 IP之類的舉動
我的看法：大概就像是在 Linux 作業系統上你想要利用 shell script 寫程式管理 server 的程式，且支援跨平台
例如：記錄一些登入的人，build 了哪些檔案、有哪些惡意攻擊、執行每日要做的...事情等等

### 換一個方式寫 for
* 以往在公司都是執行或用別人寫好的 script ，我也不知道他叫 shell script ，軟體這行水真深～
* huli 給的 `chmod +x` 代表給予執行權限
```shell script
#!/bin/bash

for number in $(seq 1 $1);
do
        touch $number.js;
        echo "檔案建立完成$number";
done
```

![cmd畫面](https://cdn-images-1.medium.com/max/1000/1*JHpMp1p12R02j29RxiWwag.png)