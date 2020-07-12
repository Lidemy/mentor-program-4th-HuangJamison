function capitalize(str) {
    var res = str;
    if (str[0] >= 'a' && str[0] <= 'z') {
        var char = String.fromCharCode(str[0].charCodeAt(0) - 32);
        res = str.replace(str[0], char);
    }
    return res;
}

console.log(capitalize('hello'));
