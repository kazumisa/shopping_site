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

  // -----商品検索機能-----商品検索機能-----商品検索機能-----商品検索機能-----
  // URLを取得
  const url = new URL(window.location.href);
  // URLSearchParamsオブジェクトを取得
  const params = url.searchParams;
  const search_word = params.get('search'); // 検索した商品を取得

  if(search_word !== null && search_word !== "") {
    const titles = document.querySelectorAll('.title');
    titles.forEach(title => {
      title.innerHTML = search_word;
    })
  } 
  
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

    // 全てのハートアイコン要素を取得
    const hearts = document.querySelectorAll('.container .img_favorite');

    if(json_url_obj !== null) {
      const keys = Object.keys(json_url_obj);
      if(keys.length !== 0) {
        keys.forEach(key => {
          const json_src = json_url_obj[key];
          const imgs = document.querySelectorAll('.container img');
          imgs.forEach(img => {
            const img_src = img.getAttribute('src');
            if(json_src === img_src) {
              const a = img.parentElement;
              const span = a.nextElementSibling;
              span.classList.add('changeColor'); // お気に入り登録
              const detail = span.nextElementSibling;
              const brand_name = detail.children[0]; // ブランド名の要素を取得
              const item_name = detail.children[1]; // 商品名の要素を取得
              const item_price = detail.children[2]; // 商品価格の要素を取得
              const heart_id = span.getAttribute('id'); // ハートのIDを取得

              // 要素をオブジェクトに追加
              json_url_obj[heart_id] = img_src;
              json_brand_obj[heart_id] = brand_name.textContent;
              json_name_obj[heart_id] = item_name.textContent;
              json_price_obj[heart_id] = item_price.textContent; 

              // 取得したオブジェクトをローカルストレージにJSON形式で保存する
              localStorage.setItem('item_url', JSON.stringify(json_url_obj));
              localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
              localStorage.setItem('item_name', JSON.stringify(json_name_obj));
              localStorage.setItem('item_price', JSON.stringify(json_price_obj));
            }
          })
        })
      }
    }
    for(let i = 0; i < hearts.length; i++) {
      hearts[i].addEventListener('click', function() {
        const favorite = hearts[i].classList.toggle('changeColor');
        const a = hearts[i].previousElementSibling;
        const img = a.firstElementChild;
        const img_src = img.getAttribute('src'); // 写真のURLを取得
        const detail = hearts[i].nextElementSibling;
        const brand_name = detail.children[0]; // ブランド名の要素を取得
        const item_name = detail.children[1]; // 商品名の要素を取得
        const item_price = detail.children[2]; // 商品価格の要素を取得
        const heart_id = hearts[i].getAttribute('id'); // ハートのIDを取得

        // お気に入り登録した際の処理(関数)
        function addFavorite() { 
          // 要素をオブジェクトに追加
          if(json_url_obj === null) {
            item_url_obj[heart_id] = img_src;
            item_brand_obj[heart_id] = brand_name.textContent;
            item_name_obj[heart_id] = item_name.textContent;
            item_price_obj[heart_id] = item_price.textContent;  
            
            //取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('item_url', JSON.stringify(item_url_obj));
            localStorage.setItem('item_brand', JSON.stringify(item_brand_obj));
            localStorage.setItem('item_name', JSON.stringify(item_name_obj));
            localStorage.setItem('item_price', JSON.stringify(item_price_obj));
          } else {
            // ローカルストレージのJSONデータを取得してオブジェクト型に変換
            const json_url_obj = JSON.parse(localStorage.getItem('item_url'));
            const json_brand_obj = JSON.parse(localStorage.getItem('item_brand'));
            const json_name_obj = JSON.parse(localStorage.getItem('item_name'));
            const json_price_obj = JSON.parse(localStorage.getItem('item_price'));

            json_url_obj[heart_id] = img_src;
            json_brand_obj[heart_id] = brand_name.textContent;
            json_name_obj[heart_id] = item_name.textContent;
            json_price_obj[heart_id] = item_price.textContent;  
          
            //取得したオブジェクトをローカルストレージにJSON形式で保存する
            localStorage.setItem('item_url', JSON.stringify(json_url_obj));
            localStorage.setItem('item_brand', JSON.stringify(json_brand_obj));
            localStorage.setItem('item_name', JSON.stringify(json_name_obj));
            localStorage.setItem('item_price', JSON.stringify(json_price_obj));
          }
        }
        // お気に入り解除した際の処理(関数)
        function deleteFavorite() {

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
          if(favorite) {
            addFavorite();
          } else {
            deleteFavorite();
          }
      })
    }  
  }) 
}