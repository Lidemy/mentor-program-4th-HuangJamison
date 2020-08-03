/* eslint-disable no-plusplus */
/* eslint-disable no-shadow */
const clientID = 'gsxn2rygq0rua9mo572b02pw0uj0o0';
const { XMLHttpRequest } = require('xmlhttprequest');
const request = require('request');

const xhr = new XMLHttpRequest();
const url = 'https://api.twitch.tv/kraken';

// 1. request
const options = {
  url: `${url}/games/top`,
  headers: {
    Accept: 'application/vnd.twitchtv.v5+json',
    'Client-ID': clientID,
  },
};
request(options, (err, res, body) => {
  let data = {};
  try {
    data = JSON.parse(body);
  } catch (err) {
    console.log(err);
  }
  const topGame = data.top;
  let output = '';
  for (let i = 0; i <= topGame.length - 1; i++) {
    const gameDetail = topGame[i].game; // 大中小圖等等細節
    output += `${topGame[i].viewers} ${gameDetail.name}\n`;
  }
  console.log(output);
});

// 2. xhr 作法
xhr.onload = () => {
  if (xhr.status >= 200 && xhr.status < 400) {
    const response = xhr.responseText;
    const data = JSON.parse(response);
    const topGame = data.top;
    let output = '';
    for (let i = 0; i <= topGame.length - 1; i++) {
      const gameDetail = topGame[i].game; // 大中小圖等等細節
      output += `${topGame[i].viewers} ${gameDetail.name}\n`;
    }
    console.log(output);
  }
};
xhr.open('GET', `${url}/games/top`, true);
xhr.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
xhr.setRequestHeader('Client-ID', clientID);
xhr.send();
