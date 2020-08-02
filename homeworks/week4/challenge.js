/* eslint-disable no-plusplus */
/* eslint-disable no-underscore-dangle */
/* eslint-disable no-shadow */
const clientID = 'gsxn2rygq0rua9mo572b02pw0uj0o0';
const request = require('request');

const url = 'https://api.twitch.tv/kraken';
const input = process.argv.slice(2);
const gameName = encodeURIComponent(input.join(' '));
// 撈取線上火紅的實況主
// 之前求職有用過 huli 的這個作業 demo ，向他們說明了解如何串 api，現在看起來很簡單，對當時麻瓜的我來說很困難XD
// https://huangjamison.github.io/popular_twitch/twitch.html
function popularGame(offsetNum = 0) {
  const options = {
    url: `${url}/streams/?game=${gameName}&limit=100&offset=${offsetNum}`,
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
    const popularStreams = data.streams;
    let rank = 1;
    if (offsetNum > 0) {
      rank = 101;
    }
    for (let i = 0; i <= popularStreams.length - 1; i++) {
      console.log(`此款遊戲中 ${decodeURIComponent(gameName)} 第 ${rank} 名`);
      console.log(`實況主 ID: ${popularStreams[i]._id}`);
      console.log(`實況主 channel 名稱: ${popularStreams[i].channel.status}`);
      console.log(`此台觀看人數: ${popularStreams[i].viewers}`);
      console.log('----------------------------------');
      rank += 1;
    }
  });
}
popularGame();
popularGame(100);
