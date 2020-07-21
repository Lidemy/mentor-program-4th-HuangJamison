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

// 解題 星星
// eslint-disable-next-line no-shadow
function solve(lines) {
  const count = Number(lines[0]);
  let res = '';
  // eslint-disable-next-line no-plusplus
  for (let i = 1; i <= count; i++) {
    // eslint-disable-next-line no-use-before-define
    res += printStar(i);
    if (i !== count) {
      res += '\n';
    }
  }
  console.log(res);
}

function printStar(times) {
  let res = '';
  // eslint-disable-next-line no-plusplus
  for (let i = 1; i <= times; i++) {
    res += '*';
  }
  return res;
}
