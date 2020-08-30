## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
1. `<cite>`
   可以用來表示一個作品或論文的引用
```html
<footer>
    Jamie Thesis in <cite><a href="http://www.google.com">reporter</a>
</footer>
```
2. `map`
   看了 MDN 好像是表示圖形中的某個區域，可以在圖上強調某些重點
```html
<map name="primary">
  <area shape="circle" coords="75,75,75" href="left.html">
  <area shape="circle" coords="275,75,75" href="right.html">
</map>
<img usemap="#primary" src="https://placehold.it/350x150" alt="350 x 150 pic">
```
3. `video` and `source` and `track`
   track 通常是 vtt 檔案，也可以是 video or 音訊檔， video 可以支援 .mp4, webm
```html
<video controls width="250">

    <source src="sample.mp4" type="video/mp4">
   <source src="sample.ogv" type="video/ogv">
   <track kind="captions" src="sampleCaptions.vtt" srclang="en">
   <track kind="descriptions"
     src="sampleDescriptions.vtt" srclang="en">
</video>
```

## 請問什麼是盒模型（box modal）
如果想了解的人手邊有電腦，我會跟他說，來 f12 打開開發者工具，你可以想像物件是一個盒子，你可以設定
box model 就是每個物件都有個大小。
一般來說，我們預設 `box-sizing: content-box` ，也就是說，我的 width & height 只定義這個物件的大小，不包含 padding 內文間距，也可以說不包含內物件與 border 距離，也不含 border，當然也不含 margin 距離。
但如果我們想要更簡易的設定盒子大小，可以用 `box-sizing: border-box`，這時候的 width & height 是 width(content width) + padding(內距) + border(邊框)，希望你可以全部吸收。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
1. inline: 並非 block，無法自成一行，也就是會擠在同一行，不能設定 margin 的上下，只能調左右 margin，** 沒有 width & height **，元素因沒寬高，因此要由內容撐開
   常見: `span`, `a`, `input`, `img`
2. block: 可以設定 margin, padding & width & height，佔滿一整行
   常見: `div`, `h1~h6`, `ul, li`, `p`
3. inline-block: inline & block 結合，可讓元素可以併排，但又有 `block`，可以控制 width & height，也可設定 margin, padding & width & height

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
1. static: 預設為 staic，就是一列一列排下來
2. relative: 只會針對本身作位移，不會影響其他元素位置，可使用 top 、 bottom、 left 、 right 的屬性來定義它的位置，常用於父層搭配子層 absoulte
```css
  /* 從原本位置下移動 50px 向右邊移動 30px */
  .relative_object {
     position:relative;
     top:50px;
     left:30px;
  }
```
3. absolute: 根據上層位置，找到上層為 relative 的父層做為參考點，參考點的設置就是以設置 absolute 的位置往上找不是 static 的元素，做為參考點，通常以relative 作為定位點，如無上層定位點則以body作為定位點，下面`class absolute_object` 就是根據 `class relative_object` 做定位
```css
.relative_object {
  position: relative;
  width: 600px;
  height: 400px;
}
.absolute_object {
  position: absolute;
  top: 120px;
  right: 0;
  width: 300px;
  height: 200px;
}
```
4. fixed: 固定的位置，你不管如何捲動或滑動都固定在同一個位置，在看謎片時廣告都是用這個方法，非常的煩，Oops，希望不會是女生助教看到 @_@
5. postion:stricky 也放在導覽列 跨越某特定值前為relative，跨越後為固定定位(fixed)，解決 fixed 滑動後仍保持原地，會跟隨畫面固定在某位置