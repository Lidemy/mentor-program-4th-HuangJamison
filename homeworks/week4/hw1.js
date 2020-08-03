/* eslint-disable no-shadow */
/* eslint-disable no-plusplus */
const apiUrl = 'https://lidemy-book-store.herokuapp.com/books';
const num = '10';
const request = require('request');

request(`${apiUrl}?_limit=${num}`, (err, res, body) => {
  let data = {};
  try {
    data = JSON.parse(body); // 先將拿到的資料轉成 object
  } catch (err) {
    console.log(err);
  }
  for (let i = 0; i <= data.length - 1; i++) {
    console.log(data[i].id, data[i].name);
  }
});
