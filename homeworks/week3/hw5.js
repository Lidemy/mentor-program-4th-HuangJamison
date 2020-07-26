/* eslint-disable no-param-reassign */
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

// 解題 比大小
// eslint-disable-next-line no-shadow
function solve(lines) {
  const count = lines[0];
  // eslint-disable-next-line no-plusplus
  for (let i = 1; i <= count; i++) {
    const input = lines[i];
    const [a, b, method] = input.split(' ');
    // eslint-disable-next-line no-use-before-define
    const outcome = judge(a, b, method);
    console.log(outcome);
  }
}

// eslint-disable-next-line consistent-return
function judge(a, b, method) {
  if (a.length > 16 || b.length > 16) {
    if (a.length > b.length && method === '1') {
      return 'A';
    }
    if (a.length > b.length && method === '-1') {
      return 'B';
    }
    if (b.length > a.length && method === '1') {
      return 'B';
    }
    if (b.length > a.length && method === '-1') {
      return 'A';
    }
    if (a.length === b.length) {
      const limit = a.length;
      let index = 0;
      while (index < limit) {
        if (Number(a[index]) > Number(b[index])) {
          if (method === '1') {
            return 'A';
          }
          return 'B';
        }
        if (Number(a[index]) < Number(b[index])) {
          if (method === '1') {
            return 'B';
          }
          return 'A';
        }
        // eslint-disable-next-line no-plusplus
        index++;
      }
      return 'DRAW';
    }
  }
  // 小位數判斷
  a = Number(a);
  b = Number(b);
  if (method === '1') {
    if (a > b) {
      return 'A';
    } if (a < b) {
      return 'B';
    }
    return 'DRAW';
  }
  if (method === '-1') {
    if (a > b) {
      return 'B';
    } if (a < b) {
      return 'A';
    }
    return 'DRAW';
  }
}
