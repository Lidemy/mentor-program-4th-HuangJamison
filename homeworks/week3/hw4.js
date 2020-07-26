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

// 解題 回文
// eslint-disable-next-line no-shadow
function solve(lines) {
  const line = lines[0];
  let reverse = '';
  // eslint-disable-next-line no-plusplus
  for (let i = line.length - 1; i >= 0; i--) {
    reverse += line[i];
  }
  if (reverse === line) {
    console.log('True');
    return;
  }
  console.log('False');
}
