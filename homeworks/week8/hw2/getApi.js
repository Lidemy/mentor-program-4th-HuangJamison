/* eslint-disable no-use-before-define */
/* eslint-disable no-unused-vars */
/* eslint-disable no-plusplus */
/* eslint-disable func-names */
/* eslint-disable no-alert */
const xhr = new XMLHttpRequest();
const clientID = 'gsxn2rygq0rua9mo572b02pw0uj0o0';
const url = 'https://api.twitch.tv/kraken';
function getTopFiveGame() {
  return new Promise((resolve, reject) => {
    xhr.open('GET', `${url}/games/top?limit=6`, true);
    xhr.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
    xhr.setRequestHeader('Client-ID', clientID);
    xhr.send();
    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status < 400) {
        const response = xhr.responseText;
        const parseData = JSON.parse(response);
        const topGame = parseData.top;
        const topFive = [];
        for (let i = 0; i <= topGame.length - 1; i++) {
          const gameDetail = topGame[i].game; // 大中小圖等等細節
          topFive.push(gameDetail.name);
        }
        const data = {
          status: 'success',
          data: topFive,
        };
        return resolve(data);
      }
      const data = {
        status: 'failure',
        data: [],
      };
      return reject(data);
    };
  });
}
async function displayNavTopFive(topFive) {
  const navItems = document.querySelectorAll('.nav__list-item a');
  if (topFive.status === 'success') {
    const topFiveGame = topFive.data;
    for (let i = 0; i < navItems.length; i++) {
      navItems[i].innerHTML = `${topFiveGame[i]}`;
      navItems[i].dataset.game = topFiveGame[i];
    }
    // 預設先抓第一名的遊戲實況 20 名
    const topOne = document.querySelector('.nav__list-item a').dataset.game;
    const result = await getGameLiveStream(topOne, 20);
    console.log(result);
  }
}
function getGameLiveStream(gameName, num) {
  return new Promise((resolve, reject) => {
    xhr.open('GET', `${url}/streams/?game=${gameName}&limit=${num}`, true);
    xhr.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
    xhr.setRequestHeader('Client-ID', clientID);
    xhr.send();
    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status < 400) {
        const response = xhr.responseText;
        const parseData = JSON.parse(response);
        const hotLivestream = parseData.streams;
        const livsestreamTotal = document.querySelector('.livestream-total');
        let livestreamContent = '';
        for (let i = 0; i < hotLivestream.length; i++) {
          livestreamContent += `
            <div class="livestream">
              <a href="${hotLivestream[i].channel.url}" target="_blank">
                <div class="livestream__img">
                  <img src="${hotLivestream[i].preview.large}"/>
                </div>
                <div class="livestream__intro">
                  <div class="livestream__channel-img">
                    <img src="${hotLivestream[i].channel.logo}"/>
                  </div>
                  <div class="livesteam__about">
                    <div class="livesteam__topic">${hotLivestream[i].channel.status}</div>
                    <div class="livesteam__channel">Host: ${hotLivestream[i].channel.display_name}</div>
                    <div class="livestream__viewers">Viewers: ${hotLivestream[i].viewers}</div>
                  </div>
                </div>
              </a>
            </div>
          `;
        }
        livsestreamTotal.innerHTML = livestreamContent;
        const gameChosen = document.querySelector('.game_chosen');
        gameChosen.innerText = gameName;
        resolve(`抓取 ${gameName} 成功`);
      }
    };
  });
}
async function main() {
  const topFive = await getTopFiveGame();
  await displayNavTopFive(topFive);
}
main();
// 建立事件監聽
window.onload = function () {
  const navList = document.querySelector('.nav__list-wrap');
  navList.addEventListener('click', (e) => {
    if (e.target.classList.contains('nav__list-item')) {
      const gameName = e.target.querySelector('a').dataset.game;
      const livestreamAll = document.querySelector('.livestream-total');
      if (gameName) {
        // 清除畫面
        livestreamAll.innerHTML = '';
        const result = getGameLiveStream(gameName, 20);
        console.log(result);
      }
    }
  });
};
