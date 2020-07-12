/*
    現在有一個排序好的陣列 arr，裡面的元素都是正整數而且保證不會重複。
    給你一個數字 n，請寫出一個函式 search 回傳 n 在這個陣列裡面的 index，沒有的話請回傳 -1。
    範例：
    search([1, 3, 10, 14, 39], 14) => 3
    search([1, 3, 10, 14, 39], 299) => -1
    這題之所以放在挑戰題，是因為這一題的解法要比這個更快：
    第一行為為一組用空白分隔的正整數 N 與 M
*/
var readline = require('readline');
var rl = readline.createInterface({
    input: process.stdin
});

var lines = [];

rl.on('line', function (line) {
    lines.push(line);
});

rl.on('close', function() {
    solve(lines); // 執行 solve function
});

// 因為是排旭好的陣列且不重複
// 感覺起來要用 binary search ?
function solve(lines) {
    var range =  lines[0].split(' ');
    var n = Number(range[0]);
    var m = Number(range[1]);
    var arr = lines.slice(1, 1+n);
    var findVal = lines.slice(1+n);
    // search 回傳 index or -1
    for (let i=0; i<=findVal.length-1; i++) {
        var searchNum = findVal[i];
        console.log(search(arr, searchNum));
    }
}

function search(arr, searchNum) {
    var left = 0;
    var right = arr.length-1;
    var mid;
    while (left <= right) {
        mid = Math.floor((left + right) / 2);
        if (Number(arr[mid]) < Number(searchNum)) {
            left = mid + 1;
        }
        if (Number(arr[mid]) > Number(searchNum)) {
            right = mid - 1;
        }
        if (Number(arr[mid]) == Number(searchNum)) {
            return mid;
        }
    }
    return -1;
}