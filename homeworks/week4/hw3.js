/* eslint-disable no-plusplus */
/* eslint-disable no-shadow */
const apiUrl = 'https://restcountries.eu/rest/v2/name';
const request = require('request');

const input = process.argv.slice(2);

const keyword = input[0];
request(`${apiUrl}/${keyword}`, (err, res, body) => {
  let data;
  try {
    data = JSON.parse(body);
    // 修正
    if (data.status === 404) {
      console.log('再檢查一下你的request或是...沒這個國家！');
    }
  } catch (err) {
    console.log(err);
  }
  let ans = '';
  for (let i = 0; i <= data.length - 1; i++) {
    ans += '============\n';
    ans += `國家：${data[i].name}\n`;
    ans += `首都：${data[i].capital}\n`;
    ans += `貨幣：${data[i].currencies[0].code}\n`;
    ans += `國碼：${data[i].callingCodes[0]}\n`;
  }
  console.log(ans);
});
