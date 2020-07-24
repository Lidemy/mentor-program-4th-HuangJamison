const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
});

const lines = [];

rl.on('line', (line) => {
  lines.push(line);
});

rl.on('close', () => {
  // ctrl+D
  // eslint-disable-next-line no-use-before-define
  solve(lines); // 執行 solve function
});

// 解題 function 水仙花數
// eslint-disable-next-line no-shadow
function solve(lines) {
  const line = lines[0];
  const inputNumber = line.split(' ');
  const n = Number(inputNumber[0]);
  const m = Number(inputNumber[1]);
  // eslint-disable-next-line no-plusplus
  for (let i = n; i <= m; i++) {
    // eslint-disable-next-line no-use-before-define
    if (isSepcial(i)) {
      console.log(i);
    }
  }
}

function isSepcial(num) {
  const numLen = String(num).length;
  let sum = 0;
  // eslint-disable-next-line no-plusplus
  for (let i = 0; i <= numLen - 1; i++) {
    const eachNum = String(num).charAt(i);
    // eslint-disable-next-line no-restricted-properties
    sum += Math.pow(Number(eachNum), Number(numLen));
  }
  if (sum === num) {
    return true;
  }
  return false;
}
