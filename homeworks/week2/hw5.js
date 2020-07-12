function join(arr, concatStr) {
    // 想法為把陣列裡的東西拿出來，如果陣列為最後一個數則不串連
    if (arr.length == 0) {
        return;
    }
    var res = '';
    for (let i=0; i<=arr.length-1; i++) {
        if (i == arr.length-1) {
            res += arr[i];
            return res;
        }
        res += arr[i];
        res += concatStr;
    }
}

function repeat(str, times) {
    // times 作為 for 內 i 的次數
    var res = '';
    if (Number(times) < 1) {
        return;
    }
    for (let i=1; i<=times; i++) {
        res += str;
    }
    return res;
}

console.log(join(["aaa", "bb", "c", "dddd"], ',,'));
console.log(repeat('jamie', 5));
