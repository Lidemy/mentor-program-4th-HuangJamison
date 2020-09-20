## 什麼是 DOM？
* DOM 算是一個橋樑，連接 js & html，將 html 的 tag 轉換成 object，可以讓開發者可以抓到這個物件，並操作或改變這個物件， 因此我們可以在瀏覽器載入完 DOM 後，改變畫面中的元素的特性(css)，或是設立一個監聽者去看是否有使用者動作，要觸發哪些事件(js 等資料操作)。

## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？
先捕獲後冒泡是一個口訣，但第一次看到也是霧煞煞。
* 事件傳播流程分成捕獲、元素本身、冒泡
* 事件傳到 target 本身，沒有分捕獲跟冒泡
* 由上至下捕獲，由下往上冒泡
* addEventListener 預設為false 冒泡，True則為捕獲
想像我們有 inner_btn 、 inner div、 outer div
當有觸發事件 click
1. 點擊事件
2. window 接收到
3. 捕獲 .outer
4. 捕獲 .inner
5. 捕獲 .inner_btn
6. target .inner_btn
7. 冒泡 .inner_btn
8. 冒泡 .inner
9. 冒泡 .outer
* 當使用 `e.stopPropagation()` 會造成接續的捕獲及冒泡停止
* 補充自我檢討
    事件機制也是這樣的，捕獲跟冒泡這個流程永遠都在，但如果你沒有加監聽器，你是察覺不到的。所以 addEventListener 的第三個參數只是覺得你要在「哪邊」加上這個監聽器，而不是改變原本事件傳遞的流程。
## 什麼是 event delegation，為什麼我們需要它？
我的答案是 
1. 避免重複的 code 
* 如果我們沒偵測父元素下相同的 `class name` 要做什麼事情，你會需要宣告許多DOM 物件，去說明此 DOM 物件觸發事件後要做什麼事情，但因為有捕獲與冒泡，可以省事許多，舉上面例子，當 outer 內有許多 inner_btn，當按鍵事件觸發，外圍的 outer 也會捕獲的此事件，我們可以用 if 去判斷是否含有 `class name`，進而做一些操作，而不用每個物件都寫相同的觸發事件。
2. 新增的 DOM 也可以抓到
* 之前 coding 時有遇到，當你是新增 DOM 時，你事件代理如果不是父層，你會抓不到此元素，我在猜是因為 js 已經載入，如果不在父層底下，你新增的 DOM 不會被 js 抓到。
## event.preventDefault() 跟 event.stopPropagation() 差在哪裡，可以舉個範例嗎？
1. event.preventDefault()
   只是單純阻止預設事件的產生，例如：表單送出等
* form 的 submit - 阻止送出表單
    (1)可以在form 內用onsubmit="return function()"
    然後在fun寫好判斷式怎樣是false 怎樣是true
    用DOM.input的class.value 去確認輸入框
    (2) form 有監聽，觸發為click，如果input框為什麼值了時候，e.preventDefault() 否則return true
* a的 click 事件 - 阻止跳網址
* input 的 keypress 事件 - 阻止輸入按鍵
```javascript
// 設定y按鍵失靈
const account = document.querySelector("input[name=account]");
account.addEventListener("keypress",function (e) {
    if(e.key == 'y'){
        console.log('這個鍵壞了喔');
        e.preventDefault();
    }
})
```
2. e.stopPropagation()
跟上面不一樣，其是阻止事件傳遞，阻止向上與向下傳播，如果在捕獲階段停止傳遞，連冒泡也不會發生。
```javascript
window.addEventListener('click', function (e) {
  e.preventDefault(); // 停止預設功能
  e.stopPropagation(); // 停止後續傳遞
}, true) // 指定為從捕獲階段開始監聽
```
* e.stopProagation() 同層還是會觸發
* e.stopImmediatePropagation() 立即當下阻止事件傳播