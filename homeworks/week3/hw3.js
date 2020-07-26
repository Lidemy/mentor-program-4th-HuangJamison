const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
});

const lines = [];

rl.on('line', (line) => {
  lines.push(line);
});

rl.on('close', () => {
  // eslint-disable-next-line no-use-before-define
  solve(lines); // 執行 solve function
});

// 解題 質數
// eslint-disable-next-line no-shadow
function solve(lines) {
  const arr = lines.slice(1).map(num => Number(num));
  // eslint-disable-next-line no-plusplus
  for (let i = 0; i <= arr.length - 1; i++) {
    // eslint-disable-next-line no-use-before-define
    if (isPrime(arr[i])) {
      console.log('Prime');
      // eslint-disable-next-line no-continue
      continue;
    }
    console.log('Composite');
  }
}

function isPrime(num) {
  if (num === 1) {
    return false;
  }
  if (num === 2) {
    return true;
  }
  // eslint-disable-next-line no-plusplus
  for (let i = 2; i < num; i++) {
    if (num % i === 0) {
      return false;
    }
  }
  return true;
}
