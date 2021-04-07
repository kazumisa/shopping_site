'use strict';

{
  // -----Milfinをクリックしたらトップページへ-----Milfinをクリックしたらトップページへ-----
  const milfin = document.querySelector('.milfin');

  milfin.addEventListener('click', () => {
    location.href = '../php/index.php';
  })
  
  // -----画面右上のメニューアイコンに関する処理-----画面右上のメニューアイコンに関する処理-----
  const mask = document.querySelector('.mask');
  const menu = document.querySelector('.menu');
  const tab = document.querySelector('.window');
  
  menu.addEventListener('click', function() {
    mask.classList.add('show');
    tab.classList.add('show');
  })

  mask.addEventListener('click', function() {
    mask.classList.remove('show');
    tab.classList.remove('show');
  })
 
  // -----ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理-----ログアウトに関する処理-----
  const logout = document.querySelector('.logout');
  
  if(logout !== null) {
    logout.addEventListener('click', function(e) { 
      const conf = confirm('ログアウトしますか？');
      if(conf) {
        alert('ログアウトしました。');
        location.href('../php/logout.php');
      } else {
        e.preventDefault();
      }
    })
  }
}