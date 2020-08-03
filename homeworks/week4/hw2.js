/* eslint-disable no-unused-vars */
/* eslint-disable no-plusplus */
/* eslint-disable no-use-before-define */
/* eslint-disable no-shadow */
/*
   node hw2.js list // 印出前二十本書的 id 與書名
   node hw2.js read 1 // 輸出 id 為 1 的書籍
   node hw2.js delete 1 // 刪除 id 為 1 的書籍
   node hw2.js create "I love coding" // 新增一本名為 I love coding 的書
   node hw2.js update 1 "new name" // 更新 id 為 1 的書名為 new name
   練習看懂 api 簡易功能
*/

const apiUrl = 'https://lidemy-book-store.herokuapp.com/books';
const request = require('request');

// 1. 要有一個接參數的 function try catch 拿到值
// 2. 判斷參數要用哪個 function
try {
  // 取第二個參數之後的
  const input = process.argv.slice(2);
  switch (input[0]) {
    case 'list':
      list();
      break;
    case 'read':
      read(input[1]);
      break;
    case 'delete':
      deleteBook(input[1]);
      break;
    case 'create':
      create(input[1]);
      break;
    case 'update':
      update(input[1], input[2]);
      break;
    default:
      console.log('沒有此功能哦!');
      break;
  }
} catch (e) {
  console.log(e);
}

/**
 * 列出前 20 本書
 */
function list() {
  const num = 20;
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
}

/**
 * 列印出指定 id 書名
 * @param  int id
 * @return none
 */
function read(id = 1) {
  request(`${apiUrl}/${id}`, (err, res, body) => {
    let data = {};
    try {
      data = JSON.parse(body); // 先將拿到的資料轉成 object
    } catch (err) {
      console.log(err);
    }
    console.log(data.name);
  });
}

/**
 * 刪除特定 id 書
 * @param int id
 * @return none
 */
function deleteBook(id) {
  request.del(`${apiUrl}/${id}`, (err, res, body) => {
    try {
      console.log(`刪除成功 ${id} 的書`);
    } catch (err) {
      console.log(err);
    }
  });
}

/**
 * 新增一本書
 * @param  string name
 * @return none
 */
function create(name) {
  const options = {
    url: apiUrl,
    json: true,
    body: {
      name,
    },
  };
  request.post(options, (err, res, body) => {
    try {
      console.log(`新增一本書名為: ${name}`);
    } catch (err) {
      console.log(err);
    }
  });
}

/**
 * 更新一本書
 * @param int   id
 * @param sting name
 */
function update(id, name) {
  const options = {
    url: `${apiUrl}/${id}`,
    json: true,
    body: {
      id,
      name,
    },
  };
  request.patch(options, (err, res, body) => {
    try {
      console.log(`更新第 ${id} 本書為: ${name}`);
    } catch (err) {
      console.log(err);
    }
  });
}
