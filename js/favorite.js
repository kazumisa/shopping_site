'use strict';

{
  // -----Milfinをクリックしたらトップページへ-----Milfinをクリックしたらトップページへ-----
  const milfin = document.querySelectorAll('.milfin');

  // SPサイト
  milfin[0].addEventListener('click', () => {
    location.href = '../php/index.php';
  })
  // PCフォンサイト
  milfin[1].addEventListener('click', () => {
    location.href = '../php/index.php';
  })
  
  // -----画面右上のメニューアイコンに関する処理-----画面右上のメニューアイコンに関する処理-----

  // SPサイト
  const mask = document.querySelectorAll('.mask');
  const menu = document.querySelectorAll('.menu');
  const tab = document.querySelectorAll('.window');
  menu[0].addEventListener('click', function() {
    mask[0].classList.add('show');
    tab[0].classList.add('show');
  })

  mask[0].addEventListener('click', function() {
    mask[0].classList.remove('show');
    tab[0].classList.remove('show');
  })

  // PCサイト
  menu[1].addEventListener('click', function() {
    mask[1].classList.add('show');
    tab[1].classList.add('show');
  })

  mask[1].addEventListener('click', function() {
    mask[1].classList.remove('show');
    tab[1].classList.remove('show');
  })

  // -----ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理-----
  const logout = document.querySelectorAll('.logout');
  if(logout.length !== 0) {
    // SPサイト
    logout[0].addEventListener('click', function(e) { 
      const conf = confirm('ログアウトしますか？');
      if(conf) {
        // お気に入り商品を解除
        localStorage.removeItem('item_url');
        localStorage.removeItem('item_brand');
        localStorage.removeItem('item_name');
        localStorage.removeItem('item_price');
        localStorage.removeItem('cart');
        alert('ログアウトしました。');
        location.href('../php/logout.php');
      } else {
        e.preventDefault();
      }
    })
  
    // PCサイト
    logout[1].addEventListener('click', function(e) { 
      const conf = confirm('ログアウトしますか？');
      if(conf) {
        // お気に入り商品を解除
        localStorage.removeItem('item_url');
        localStorage.removeItem('item_brand');
        localStorage.removeItem('item_name');
        localStorage.removeItem('item_price');
        localStorage.removeItem('cart');
        alert('ログアウトしました。');
        location.href('../php/logout.php');
      } else {
        e.preventDefault();
      }
    })
  }


  // -----お気に入り商品の一覧とその解除-----お気に入り商品の一覧とその解除-----お気に入り商品の一覧とその解除-----
  window.addEventListener('DOMContentLoaded', function() {
    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
    const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
    const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
    const json_price_obj = JSON.parse(localStorage.getItem('item_price'));

    if(json_url_obj !== null) {

      // オブジェクトのキーを配列として取得
      const keys = Object.keys(json_url_obj);
  
      // -----お気に入り商品の数をカウントする機能作成-----お気に入り商品の数をカウントする機能作成-----
      const count_favorite = document.querySelector('.count_favorite');
      const p = document.createElement('p');
  
      // お気に入り商品の数を表示する
      if(keys.length === 0) {
        p.textContent = '現在、お気に入り登録された商品は存在しません。';
        count_favorite.appendChild(p);
      } else {
        p.textContent = `現在、お気に入り登録された商品は${keys.length}件あります。`;
        count_favorite.appendChild(p);
      }
  
      keys.forEach(key => { 
        // DOMからcontainerクラスを取得
        const container = document.querySelector('.container');
  
        // DOMにcontainerの子ノードとしてdiv(class=box)を追加
        const box = document.createElement('div');
        box.setAttribute('class', 'box');
        container.appendChild(box);
  
        // DOMにboxクラスの子ノードとしてaタグを追加
        const a = document.createElement('a');
        a.setAttribute('href', `./select_item.php?id=${key}`);
        box.appendChild(a);
          
        // DOMにaタグの子ノードとしてimgタグを追加
        const img = document.createElement('img');
        img.setAttribute('src', json_url_obj[key]);
        a.appendChild(img);
    
        // DOMにboxの子ノードとしてspan(closeアイコン)タグを追加
        const span = document.createElement('span');
        span.setAttribute('class', 'material-icons close');
        span.setAttribute('id', `${key}`);
        span.textContent = 'close';
        box.appendChild(span);
    
        // DOMにboxの子ノードとしてdiv(class=detail)を追加
        const detail = document.createElement('div');
        detail.setAttribute('class', 'detail');
        box.appendChild(detail); 
  
        // DOMにboxの子ノードとしてブランド名を表示するpタグを追加
        const brand_name = document.createElement('p');
        brand_name.setAttribute('class', 'brand_name');
        brand_name.textContent = json_brand_obj[key];
        const brandName = brand_name.textContent.length > 20 ? brand_name.textContent.slice(0, 20) + '...' : brand_name.textContent;
        brand_name.innerHTML = brandName;
        detail.appendChild(brand_name);
  
        // DOMにboxの子ノードとして商品名を表示するpタグを追加
        const item_name = document.createElement('p');
        item_name.setAttribute('class', 'item_name');
        item_name.textContent = json_name_obj[key];
        const itemName = item_name.textContent.length > 20 ? item_name.textContent.slice(0, 20) + '...' : item_name.textContent;
        item_name.innerHTML = itemName;
        detail.appendChild(item_name);
  
        // DOMにboxの子ノードとして商品価格を表示するpタグを追加
        const item_price = document.createElement('p');
        item_price.textContent = json_price_obj[key];
        item_price.setAttribute('class', 'item_price');
        detail.appendChild(item_price);
  
        // お気に入り商品の削除ボタンを取得
        const close = document.getElementById(`${key}`);
        close.addEventListener('click', function() {
          const parentElement = close.parentElement;
  
          // DOMを削除する処理
          parentElement.remove();
  
          // ローカルストレージ内のオブジェクトの要素を削除
          delete json_url_obj[key];
          delete json_brand_obj[key];
          delete json_name_obj[key];
          delete json_price_obj[key];
  
          // 取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(json_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(json_name_obj));
          localStorage.setItem('item_price', JSON.stringify(json_price_obj));
  
          // オブジェクトのキーを配列として取得
          const keys = Object.keys(json_url_obj);
  
          // お気に入り商品の数を表示する
          if(keys.length === 0) {
            p.textContent = '現在、お気に入りされた商品は存在しません。';
            count_favorite.appendChild(p);
          } else {
            p.textContent = `現在、お気に入りされた商品は${keys.length}件あります。`;
            count_favorite.appendChild(p);
          }
        })
      })
    } else {
      const count_favorite = document.querySelector('.count_favorite');
      const p = document.createElement('p');
      p.textContent = '現在、お気に入り登録された商品は存在しません。';
      count_favorite.appendChild(p);
    }
  })
}