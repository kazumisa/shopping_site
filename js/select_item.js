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
  const mask = document.querySelectorAll('.mask');
  const menu = document.querySelectorAll('.menu');
  const tab = document.querySelectorAll('.window');
  menu[0].addEventListener('click', function() {
    mask[0].classList.add('show');
    tab[0].classList.add('show');
  })

  // SPサイト
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
        alert('ログアウトしました。');
        location.href('../php/logout.php');
      } else {
        e.preventDefault();
      }
    })
  }

  // -----アイテム説明の表示・非表示切り替え処理-----アイテム説明の表示・非表示切り替え処理-----
  const item_detail = document.querySelector('.item_detail');
  const off = document.querySelector('.off');
  const on  = document.querySelector('.on');
  off.addEventListener('click', function() {
    off.classList.add('hide');
    on.classList.remove('hide');
    item_detail.classList.remove('hide');
  })

  on.addEventListener('click', function() {
    on.classList.add('hide');
    item_detail.classList.add('hide');
    off.classList.remove('hide');
  })

  // -----サイズとカラーの表示・非表示切り替え処理-----サイズとカラーの表示・非表示切り替え処理-----
  const item_size_color_off = document.querySelector('.item_size_color_off');
  const item_size_color_on = document.querySelector('.item_size_color_on');
  item_size_color_off.addEventListener('click', function() {
    item_size_color_off.classList.add('hide');
    item_size_color_on.classList.remove('hide');
  })

  item_size_color_on.addEventListener('click', function() {
    item_size_color_off.classList.remove('hide');
    item_size_color_on.classList.add('hide');
  })

  // -----お気に入り登録と解除に関する処理-----お気に入り登録と解除に関する処理-----
  const item_url_obj = {}; // 写真のURLを格納するオブジェクト
  const item_brand_obj = {}; // ブランド名を格納するオブジェクト
  const item_name_obj = {}; // 商品名を格納するオブジェクト
  const item_price_obj = {}; // 商品価格を格納するオブジェクト

  // -----お気に入り登録に関する処理(SPサイト・PCサイト共通)-----お気に入り登録に関する処理(SPサイト・PCサイト共通)-----
  window.addEventListener('DOMContentLoaded', function() {
    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
    const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
    const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
    const json_price_obj = JSON.parse(localStorage.getItem('item_price'));

    const favorite_btn = document.querySelector('.register_btn');
    const favorite_id = favorite_btn.getAttribute('id');
    if(json_url_obj !== null) {
      const keys = Object.keys(json_url_obj);
      if(keys.length !== 0) { // 既にお気に入り登録されている商品の処理
        keys.forEach(key => {
          if(key === favorite_id) {
            favorite_btn.classList.add('nowFavorite');
            favorite_btn.innerHTML = "お気に入り解除";
          }
        })
      }
    }

    favorite_btn.addEventListener('click', function() {
      const favorite = favorite_btn.classList.toggle('nowFavorite')
      const parent_div = favorite_btn.parentElement;
      const main_top = parent_div.parentElement;
      const item_pic = main_top.firstElementChild;
      const img = item_pic.firstElementChild;
      const img_src = img.getAttribute('src'); // 写真のURLを取得
      const item_content = item_pic.nextElementSibling;
      const brand_name = item_content.children[0]; // ブランド名を取得
      const item_name = item_content.children[1]; // 商品名を取得
      const item_price = item_content.children[2]; // 商品価格を取得
      const item_id = favorite_btn.getAttribute('id');

      // お気に入り登録した際の処理(関数)
      function addFavorite() { 
        favorite_btn.innerHTML = "お気に入り解除";

        if(json_url_obj === null) {
          // 要素をオブジェクトに追加
          item_url_obj[item_id] = img_src;
          item_brand_obj[item_id] = brand_name.textContent;
          item_name_obj[item_id] = item_name.textContent;
          item_price_obj[item_id] = item_price.textContent; 
        } else {
          // 要素をオブジェクトに追加
          json_url_obj[item_id] = img_src;
          json_brand_obj[item_id] = brand_name.textContent;
          json_name_obj[item_id] = item_name.textContent;
          json_price_obj[item_id] = item_price.textContent; 
        }
  
        if(json_url_obj === null) {
          //取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(item_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(item_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(item_name_obj));
          localStorage.setItem('item_price', JSON.stringify(item_price_obj));
        } else {
          //取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(json_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(json_name_obj));
          localStorage.setItem('item_price', JSON.stringify(json_price_obj));
        }
      }
      // お気に入り解除した際の処理(関数)
      function deleteFavorite() {
        favorite_btn.innerHTML = "お気に入り登録";

        // オブジェクトから要素を削除
        delete item_url_obj[item_id];
        delete item_brand_obj[item_id];
        delete item_name_obj[item_id];
        delete item_price_obj[item_id];

        // ローカルストレージのJSONデータを取得してオブジェクト型に変換
        const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
        const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
        const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
        const json_price_obj = JSON.parse(localStorage.getItem('item_price'));
      
        // オブジェクトから要素を削除
        delete json_url_obj[item_id];
        delete json_brand_obj[item_id];
        delete json_name_obj[item_id];
        delete json_price_obj[item_id];

        // 取得したオブジェクトをローカルストレージにJSON形式で保存する
        localStorage.setItem('item_url', JSON.stringify(json_url_obj));
        localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
        localStorage.setItem('item_name', JSON.stringify(json_name_obj));
        localStorage.setItem('item_price', JSON.stringify(json_price_obj)); 
      }

      if(json_url_obj === null && json_brand_obj === null && json_name_obj === null && json_price_obj === null) {
        if(favorite) {
          addFavorite();
        } else {
          deleteFavorite();
        }
      } else {
        if(favorite) {
          addFavorite();
        } else {
          deleteFavorite();
        }
      }
    })

    // -----買い物かごに商品を追加した際の処理-----買い物かごに商品を追加した際の処理-----
    const cart_url_obj = {}; // 商品をカートに入れるオブジェクト
    const cart_brand_obj = {}; // 商品をカートに入れるオブジェクト
    const cart_name_obj = {}; // 商品をカートに入れるオブジェクト
    const cart_price_obj = {}; // 商品をカートに入れるオブジェクト

    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_cart_url = JSON.parse(localStorage.getItem('cart_item_url'));

    // "買い物かごに入れる"ボタンを取得
    const cart_btn = document.querySelector('.shopping_cart_btn');

    if(json_cart_url !== null) {
      const keys = Object.keys(json_cart_url);
      if(keys !== 0) {
        keys.forEach(key => {
          const img = document.querySelector('img');
          const img_src = img.getAttribute('src');
          const cart_url = json_cart_url[key];
          if(cart_url === img_src) {
            cart_btn.classList.add('backColor')
            cart_btn.innerHTML = "買い物かごに追加済み";
          }
        })
      }
    }
    cart_btn.addEventListener('click', function() {
      cart_btn.classList.add('backColor');
      const parent = cart_btn.parentElement;
      const main_top = parent.parentElement;
      const item_pic = main_top.firstElementChild;
      const img = item_pic.firstElementChild;
      const img_src = img.getAttribute('src'); // 写真のURLを取得
      const item_content = item_pic.nextElementSibling;
      const brand_name = item_content.children[0]; // ブランド名を取得
      const item_name = item_content.children[1]; // 商品名を取得
      const item_price = item_content.children[2]; // 商品価格を取得
      const register_btn = document.querySelector('.register_btn');
      const item_id = register_btn.getAttribute('id');

      if(json_cart_url === null) {
        // 買い物かごに追加した際の処理
        cart_url_obj[item_id] = img_src;
        cart_brand_obj[item_id] = brand_name.textContent;
        cart_name_obj[item_id] = item_name.textContent;
        cart_price_obj[item_id] = item_price.textContent;
  
        //取得したオブジェクトをローカルストレージにJSON形式で保存する
        localStorage.setItem('cart_item_url', JSON.stringify(cart_url_obj));
        localStorage.setItem('cart_item_brand', JSON.stringify(cart_brand_obj));
        localStorage.setItem('cart_item_name', JSON.stringify(cart_name_obj));
        localStorage.setItem('cart_item_price', JSON.stringify(cart_price_obj));
  
        cart_btn.innerHTML = "買い物かごに追加済み";
      } else {
        // ローカルストレージのJSONデータを取得してオブジェクト型に変換
        const json_cart_url = JSON.parse(localStorage.getItem('cart_item_url'));
        const json_cart_brand = JSON.parse(localStorage.getItem('cart_item_brand'));
        const json_cart_name = JSON.parse(localStorage.getItem('cart_item_name'));
        const json_cart_price = JSON.parse(localStorage.getItem('cart_item_price'));

        // 買い物かごに追加した際の処理
        json_cart_url[item_id] = img_src;
        json_cart_brand[item_id] = brand_name.textContent;
        json_cart_name[item_id] = item_name.textContent;
        json_cart_price[item_id] = item_price.textContent;
  
        //取得したオブジェクトをローカルストレージにJSON形式で保存する
        localStorage.setItem('cart_item_url', JSON.stringify(json_cart_url));
        localStorage.setItem('cart_item_brand', JSON.stringify(json_cart_brand));
        localStorage.setItem('cart_item_name', JSON.stringify(json_cart_name));
        localStorage.setItem('cart_item_price', JSON.stringify(json_cart_price));
  
        cart_btn.innerHTML = "買い物かごに追加済み";
      }
    })
  })
}