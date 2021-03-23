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

  // SPサイト
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


  // -----DOMに要素を追加する処理-----DOMに要素を追加する処理-----DOMに要素を追加する処理-----DOMに要素を追加する処理-----
  const item_url_obj = {}; // 写真のURLを格納するオブジェクト
  const item_brand_obj = {}; // ブランド名を格納するオブジェクト
  const item_name_obj = {}; // 商品名を格納するオブジェクト
  const item_price_obj = {}; // 商品価格を格納するオブジェクト
  window.addEventListener('DOMContentLoaded', async function() {
    // データのやり取り
    const response = await fetch('https://jsondata.okiba.me/v1/json/ej9jA210307121646');
    const items_data = await response.json();

    items_data.forEach(item_data => {
      // DOMのcontainerクラスにdiv(class="box")要素を追加
      const container = document.querySelector('.container');
      const box = document.createElement('div');
      box.setAttribute('class', 'box');
      container.appendChild(box);

      // DOMのboxクラスにa要素を追加
      const a = document.createElement('a');
      a.setAttribute('href', `../php/select_item.php?id=${item_data.id}`);
      box.appendChild(a);

      // DOMのa要素にimg要素を追加
      const img = document.createElement('img');
      img.setAttribute('src', item_data.item);
      a.appendChild(img);

      // DOMのboxクラスにspan要素(ハートアイコン)を追加
      const heart = document.createElement('span');
      heart.setAttribute('class', 'material-icons img_favorite heart');
      heart.setAttribute('id', item_data.id);
      heart.textContent = 'favorite'
      box.appendChild(heart);

      // DOMのboxクラスに詳細を表示するdiv(class="detail")要素を追加
      const detail = document.createElement('div');
      detail.setAttribute('class', 'detail');
      box.appendChild(detail)

      // DOMのdetailクラスにブランド名を表示するp要素を設置
      const brand_name = document.createElement('p');
      brand_name.setAttribute('class', 'brand_name');
      brand_name.textContent = item_data.brand;
      const brandName = brand_name.textContent.length > 20 ? brand_name.textContent.slice(0, 20) + '...' : brand_name.textContent;
      brand_name.innerHTML = brandName;
      detail.appendChild(brand_name);

      // DOMのdetailクラスに商品名を表示するp要素を設置
      const item_name = document.createElement('p');
      item_name.setAttribute('class', 'item_name');
      item_name.textContent = item_data.name;
      const itemName = item_name.textContent.length > 20 ? item_name.textContent.slice(0, 20) + '...' : item_name.textContent;
      item_name.innerHTML = itemName;
      detail.appendChild(item_name);

      // DOMのdetailクラスに商品価格を表示するp要素を設置
      const item_price = document.createElement('p');
      item_price.setAttribute('class', 'item_price');
      item_price.textContent = "¥" + Number(item_data.price).toLocaleString();
      detail.appendChild(item_price);  

      // -----商品検索機能-----商品検索機能-----商品検索機能-----商品検索機能-----
      // URLを取得
      const url = new URL(window.location.href);
      // URLSearchParamsオブジェクトを取得
      const params = url.searchParams;
      const search_word = params.get('search');
      if(search_word !== null) {
        // 見出し語を検索ワードに変更
        const main = document.querySelector('main');
        const show_word = main.firstElementChild;
        show_word.innerHTML = search_word;
        const search_item = [];
        if(search_word.toLowerCase() === item_data.brand.toLowerCase()) {
          search_item.push(item_data.id)

          console.log(search_item);
          
        } else {
          container.remove();
          const message = document.createElement('p');
          message.setAttribute('class', 'message');
          message.textContent = "条件に一致する商品は見つかりませんでした。";
          main.appendChild(message);
        }
      }
    });

    // ユーザが2回目以降にトップページを訪れた際の処理-----ユーザが2回目以降にトップページを訪れた際の処理
    
    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_url_obj = JSON.parse(localStorage.getItem('item_url'));

    if(json_url_obj) {
      const exist_keys = Object.keys(json_url_obj);
      if(exist_keys !== null) {
        exist_keys.forEach(exist_key => {
          const already_favorite = document.querySelectorAll('.heart');
          already_favorite[exist_key - 1].classList.add('changeColor');

          const a = already_favorite[exist_key - 1].previousElementSibling;
          const img = a.firstElementChild;
          const img_src = img.getAttribute('src'); // 商品の写真を取得
          const detail = already_favorite[exist_key - 1].nextElementSibling;
          const brand_name = detail.children[0]; // ブランド名の要素を取得
          const item_name = detail.children[1]; // 商品名の要素を取得
          const item_price = detail.children[2]; // 商品価格の要素を取得

          // ハートアイコンのidを取得
          const heart_id = already_favorite[exist_key - 1].getAttribute('id');

          // 要素をオブジェクトに追加
          item_url_obj[heart_id] = img_src;
          item_brand_obj[heart_id] = brand_name.textContent;
          item_name_obj[heart_id] = item_name.textContent;
          item_price_obj[heart_id] = item_price.textContent;

          // 取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(item_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(item_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(item_name_obj));
          localStorage.setItem('item_price', JSON.stringify(item_price_obj));
        })
      } 
    } 
    // -----ユーザが最初にトップページを訪れた際の処理-----ユーザが最初にトップページを訪れた際の処理-----ユーザが最初にトップページを訪れた際の処理-----
    const hearts = document.querySelectorAll('.heart');
    const keys = Object.keys(items_data);
    for(let i = 0; i < keys.length; i++) {
      hearts[i].addEventListener('click', function() {
        const favorite = hearts[i].classList.toggle('changeColor');
        const a = hearts[i].previousElementSibling;
        const img = a.firstElementChild;
        const img_src = img.getAttribute('src'); // 写真のURLを取得
        const detail = hearts[i].nextElementSibling;
        const brand_name = detail.children[0]; // ブランド名の要素を取得
        const item_name = detail.children[1]; // 商品名の要素を取得
        const item_price = detail.children[2]; // 商品価格の要素を取得

        // ハートアイコンのidを取得
        const heart_id = hearts[i].getAttribute('id');

        if(favorite) {
          // お気に入り登録した際の処理-----お気に入り登録した際の処理-----お気に入り登録した際の処理

          // 要素をオブジェクトに追加
          item_url_obj[heart_id] = img_src;
          item_brand_obj[heart_id] = brand_name.textContent;
          item_name_obj[heart_id] = item_name.textContent;
          item_price_obj[heart_id] = item_price.textContent;

          // 取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(item_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(item_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(item_name_obj));
          localStorage.setItem('item_price', JSON.stringify(item_price_obj));
        } else { // お気に入り解除した際の処理

          // ローカルストレージのJSONデータを取得してオブジェクト型に変換
          const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
          const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
          const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
          const json_price_obj = JSON.parse(localStorage.getItem('item_price'));
        
          // オブジェクトから要素を削除
          delete json_url_obj[heart_id];
          delete json_brand_obj[heart_id];
          delete json_name_obj[heart_id];
          delete json_price_obj[heart_id];

          // 取得したオブジェクトをローカルストレージにJSON形式で保存する
          localStorage.setItem('item_url', JSON.stringify(json_url_obj));
          localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
          localStorage.setItem('item_name', JSON.stringify(json_name_obj));
          localStorage.setItem('item_price', JSON.stringify(json_price_obj));
        }
      })
    }
  })
  
  // -----スライドショーに関する処理-----スライドショーに関する処理-----スライドショーに関する処理-----
  const swiper = new Swiper('.swiper-container', {
    // スライドを切り替える際にかかる時間
    speed: 1000,
    // スライダーをループ(カルーセル)させる
    loop: true,
    // フワッと画面が切り替わる
    effect: 'fade',
    // 写真の表示時間
    autoplay: {
      delay: 2000
    },
  
    // ページネーション (スライダー下の丸いアイコン)
    pagination: {
      el: '.swiper-pagination',
      // クリックできるようにする
      clickable: true,
    },
  
    //  ナビゲーション (左右の矢印) を設定
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  // -----ターゲットに関する処理(PCサイトのみ)-----ターゲットに関する処理(PCサイトのみ)-----
  const taget_person = document.querySelectorAll('.target_person');
  const keys = Object.keys(taget_person);
  // ページ読み込み時に初期値として"すべて"の色を追加
  taget_person[0].classList.add('addColor');
  const prev_target = document.getElementsByClassName('addColor');
  keys.forEach(key => {
    taget_person[key].addEventListener('click', function() {
      if(taget_person[0].classList.contains('addColor')) {
        taget_person[0].classList.remove('addColor');
        taget_person[key].classList.add('addColor');
      } else {
        const now_target = document.getElementsByClassName('addColor')[0];
        now_target.classList.remove('addColor');
        const clicked_target = taget_person[key];
        clicked_target.classList.add('addColor');
      }
    })
  }) 
}