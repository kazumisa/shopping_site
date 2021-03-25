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
        // お気に入り商品を解除
        localStorage.removeItem('item_url');
        localStorage.removeItem('item_brand');
        localStorage.removeItem('item_name');
        localStorage.removeItem('item_price');
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
  window.addEventListener('DOMContentLoaded', async function() {
    // データのやり取り
    const response = await fetch('https://jsondata.okiba.me/v1/json/xmIUt210325053424');
    const items_data = await response.json();

    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
    const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
    const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
    const json_price_obj = JSON.parse(localStorage.getItem('item_price'));
    const json_cart_obj = JSON.parse(localStorage.getItem('cart'));

    // 各要素の取得
    const register_favorite = document.querySelector('.register_btn');
    const register_div = register_favorite.parentElement;
    const main_top = register_div.parentElement;
    const item_pic = main_top.firstElementChild;
    const img = item_pic.firstElementChild;
    const img_src = img.getAttribute('src'); // 写真のURLを取得
    const item_content = item_pic.nextElementSibling;
    const brand_name = item_content.children[0]; // ブランド名の要素を取得
    const item_name = item_content.children[1]; // 商品名の要素を取得
    const item_price = item_content.children[2]; // 商品価格の要素を取得

    if(json_url_obj !== null) {
      // お気に入り登録された商品のキーを取得
      const keys = Object.keys(json_url_obj);

      if(keys.length !== 0) { // お気に入り登録されている商品がある時の処理
        keys.forEach(key => {
          if(img_src === json_url_obj[key]) {
            // お気に入り登録されている商品に解除ボタンを配置
            register_favorite.innerHTML = 'お気に入り解除';
            register_favorite.classList.remove('register');
            register_favorite.classList.add('release');
          } 
        })
      }
    }

    if(json_cart_obj !== null) {
      // 買い物かごに追加された商品のキーを取得
      const cart_keys = Object.keys(json_cart_obj);

      if(cart_keys.length !== 0) { // 買い物かごに追加された商品がある時の処理
        cart_keys.forEach(cart_key => {
          if(img_src === json_cart_obj[cart_key]) {
            // 買い物かごに追加されている商品に背景色を追加
            const shopping_cart_btn = document.querySelector('.shopping_cart_btn');
            shopping_cart_btn.classList.add('add_cart');
            shopping_cart_btn.classList.add('backColor');
          }
        })
      }
    }

    if(json_cart_obj === null) {
      const shopping_cart_obj = {};
      const shopping_cart_btn = document.querySelector('.shopping_cart_btn');
      shopping_cart_btn.addEventListener('click', async function() {
        // データのやり取り
        const response = await fetch('https://jsondata.okiba.me/v1/json/xmIUt210325053424');
        const items_data = await response.json();

        // 商品の写真のURLを取得
        const parent = shopping_cart_btn.parentElement;
        const nextParent = parent.parentElement;
        const item_pic = nextParent.firstElementChild;
        const img = item_pic.firstElementChild;
        const img_src = img.getAttribute('src');

        items_data.forEach(item_data => {
          if(item_data.item === img_src) {
            // 要素をオブジェクトに追加
            shopping_cart_obj[item_data.id] = img_src;

            // 取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('cart', JSON.stringify(shopping_cart_obj));

            // 買い物かごに追加されている商品に背景色を追加
            const shopping_cart_btn = document.querySelector('.shopping_cart_btn');
            shopping_cart_btn.classList.add('add_cart');
            shopping_cart_btn.classList.add('backColor');
          } 
        })
      })
    } else if (json_cart_obj !== null) {
      const shopping_cart_btn = document.querySelector('.shopping_cart_btn');
      shopping_cart_btn.addEventListener('click', async function() {
        // データのやり取り
        const response = await fetch('https://jsondata.okiba.me/v1/json/xmIUt210325053424');
        const items_data = await response.json();

        // 商品の写真のURLを取得
        const parent = shopping_cart_btn.parentElement;
        const nextParent = parent.parentElement;
        const item_pic = nextParent.firstElementChild;
        const img = item_pic.firstElementChild;
        const img_src = img.getAttribute('src');

        items_data.forEach(item_data => {
          if(item_data.item === img_src) {
            // 要素をオブジェクトに追加
            json_cart_obj[item_data.id] = img_src;

            // 取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('cart', JSON.stringify(json_cart_obj));

            // 買い物かごに追加されている商品に背景色を追加
            const shopping_cart_btn = document.querySelector('.shopping_cart_btn');
            shopping_cart_btn.classList.add('add_cart');
            shopping_cart_btn.classList.add('backColor');
          } 
        })
      })
    }

    function registerFavorite() {
      const register = document.querySelector('.register'); // お気に入り登録ボタンを取得
      if(register !== null) {
        // お気に入り登録する際の処理
        items_data.forEach(item_data => {
          if(item_data.item === img_src) {
            // 要素をオブジェクトに追加
            json_url_obj[item_data.id] = img_src;
            json_brand_obj[item_data.id] = brand_name;
            json_name_obj[item_data.id] = item_name;
            json_price_obj[item_data.id] = item_price;
  
            // 取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('item_url', JSON.stringify(json_url_obj));
            localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
            localStorage.setItem('item_name', JSON.stringify(json_name_obj));
            localStorage.setItem('item_price', JSON.stringify(json_price_obj));
  
            // お気に入り解除ボタンを設置
            register_favorite.classList.remove('register');
            register_favorite.classList.add('release');
            register_favorite.innerHTML = 'お気に入り解除';
          }
        })
      } else{
        // お気に入り解除する際の処理
        items_data.forEach(item_data => {
          if(item_data.item === img_src) {
            // 要素をオブジェクトに追加
            delete json_url_obj[item_data.id];
            delete json_brand_obj[item_data.id];
            delete json_name_obj[item_data.id];
            delete json_price_obj[item_data.id];
  
            // 取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('item_url', JSON.stringify(json_url_obj));
            localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
            localStorage.setItem('item_name', JSON.stringify(json_name_obj));
            localStorage.setItem('item_price', JSON.stringify(json_price_obj));
  
            // お気に入り解除ボタンを設置
            register_favorite.classList.remove('release');
            register_favorite.classList.add('register');
            register_favorite.innerHTML = 'お気に入り登録';
          }
        })  
      }
    }
    const register_btn = document.querySelector('.register_btn');
    register_btn.addEventListener('click', function() {
      registerFavorite()
    });
  }) 
}