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

  // ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理
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

  window.addEventListener('DOMContentLoaded', function() {
    // ローカルストレージのJSONデータを取得してオブジェクト型に変換
    const json_cart_url = JSON.parse(localStorage.getItem('cart_item_url'));
    const json_cart_brand = JSON.parse(localStorage.getItem('cart_item_brand'));
    const json_cart_name = JSON.parse(localStorage.getItem('cart_item_name'));
    const json_cart_price = JSON.parse(localStorage.getItem('cart_item_price'));

    if(json_cart_url !== null) {
      // オブジェクトのキーを配列として取得
      const keys = Object.keys(json_cart_url);
      keys.forEach(key => {
        //DOMからcontainerクラスを取得
        const container = document.querySelector('.container');

        // DOMにcontainerの子ノードとしてdiv(class=detail)を追加
        const detail = document.createElement('div');
        detail.setAttribute('class', 'detail');
        container.appendChild(detail);
  
        // DOMにdetailの子ノードとしてaタグを追加
        const a = document.createElement('a');
        a.setAttribute('href', `../php/select_item.php?id=${key}`);
        detail.appendChild(a);

        // DOMにaタグの子ノードとしてimgタグを追加
        const img = document.createElement('img');
        img.setAttribute('src', json_cart_url[key]);
        a.appendChild(img);

        // DOMに商品ブランド・商品名・商品価格をまとめるdiv(class=total_detail)を追加
        const total_detail = document.createElement('div');
        total_detail.setAttribute('class', 'total_detail');

        // 商品ブランド
        const item_brand = document.createElement('p');
        item_brand.setAttribute('class', 'item_brand');
        item_brand.textContent = json_cart_brand[key];
        const brandName = item_brand.textContent.length > 20 ? item_brand.textContent.slice(0, 20) + '...' : item_brand.textContent;
        item_brand.innerHTML = brandName;
        total_detail.appendChild(item_brand);

        // 商品名
        const item_name = document.createElement('p');
        item_name.setAttribute('class', 'item_name');
        item_name.textContent = json_cart_name[key];
        const itemName = item_name.textContent.length > 20 ? item_name.textContent.slice(0, 20) + '...' : item_name.textContent;
        item_name.innerHTML = itemName;
        total_detail.appendChild(item_name);

        // 商品価格
        const item_price = document.createElement('p');
        item_price.textContent = json_cart_price[key];
        item_price.setAttribute('class', 'item_price');
        total_detail.appendChild(item_price);

        detail.appendChild(total_detail);

        // 削除ボタン追加
        const div_dele = document.createElement('div');
        const p_dele = document.createElement('p');
        p_dele.textContent = '削除';
        div_dele.setAttribute('class', 'delete');
        div_dele.appendChild(p_dele);
        total_detail.appendChild(div_dele);
      })

      // -----カート内の商品の数をカウントする機能を作成-----カート内の商品の数をカウントする機能を作成-----
      if(keys.length === 0) {
        const cart_count = document.querySelector('.cart_count');
        const p = document.createElement('p');
        p.textContent = '現在、カートに商品は存在しません。';
        cart_count.appendChild(p);
        const go_register = document.querySelector('.go_register');
        go_register.classList.add('hide');
      } else {
        const allPrice = document.querySelectorAll('.item_price');
        let total = 0;
        for(let i = 0; i < allPrice.length; i++) {
          const eachPrice = allPrice[i].textContent.replace('¥', ' ');
          const int_price = parseInt(eachPrice.replace(',', ''), 10);
          total += int_price;
        }
        const cart_count = document.querySelector('.cart_count');
        const p = document.createElement('p');
        p.textContent = `小計 (${keys.length}個の商品) (税込) : ¥${total.toLocaleString()}`;
        p.setAttribute('class', 'total');
        cart_count.appendChild(p);
        
        // "注文手続きへ"ボタンを作成
        const go_register = document.querySelector('.go_register');
        const go_procedure = document.createElement('input')
        go_procedure.setAttribute('type', 'submit');
        go_procedure.setAttribute('value', '注文手続きへ');
        go_procedure.setAttribute('class', 'procedure');
        go_register.appendChild(go_procedure);

        // 削除ボタンを押した際の商品削除機能
        const dele = document.querySelectorAll('.delete');
        dele.forEach(remove => {
          remove.addEventListener('click', function() {
            const parent = remove.parentElement;
            const next_parent = parent.parentElement;
            const a = next_parent.firstChild;
            const img = a.firstChild;
            const img_src = img.getAttribute('src');

            keys.forEach(key => {
              if(json_cart_url[key] === img_src) {
                next_parent.remove();

                delete json_cart_url[key];
                delete json_cart_brand[key];
                delete json_cart_name[key];
                delete json_cart_price[key];

                localStorage.setItem('cart_item_url', JSON.stringify(json_cart_url));
                localStorage.setItem('cart_item_brand', JSON.stringify(json_cart_brand));
                localStorage.setItem('cart_item_name', JSON.stringify(json_cart_name));
                localStorage.setItem('cart_item_price', JSON.stringify(json_cart_price));

                // オブジェクトのキーを配列として取得
                const new_keys = Object.keys(json_cart_url);
                if(new_keys.length === 0) {
                  const p = document.querySelector('.total');
                  p.innerHTML = '現在、カートに商品は存在しません。';
                  const go_register = document.querySelector('.go_register');
                  go_register.classList.add('hide');
                } else {
                  const allPrice = document.querySelectorAll('.item_price');
                  let total = 0;
                  for(let i = 0; i < allPrice.length; i++) {
                    const eachPrice = allPrice[i].textContent.replace('¥', ' ');
                    const int_price = parseInt(eachPrice.replace(',', ''), 10);
                    total += int_price;
                  }
                  const total_price = document.querySelector('.total');
                  total_price.innerHTML = `小計 (${new_keys.length}個の商品) (税込) : ¥${total.toLocaleString()}`;
                }   
              }
            }) 
          })    
        }) 
      }
    } else {
      const cart_count = document.querySelector('.cart_count');
      const p = document.createElement('p');
      p.textContent = '現在、カートに商品は存在しません。';
      cart_count.appendChild(p);
      const go_register = document.querySelector('.go_register');
      go_register.classList.add('hide');
    }
  })
}