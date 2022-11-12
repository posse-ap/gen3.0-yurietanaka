"use strict";

// モーダルが開く、選択できる
const modal = document.querySelector('.js-modal');
const modalOpenButtons = document.querySelectorAll('.js-modal-open-button');
modalOpenButtons.forEach((modalOpenButton) => {
    modalOpenButton.addEventListener('click', ()=> {
        modal.classList.add('u-display-block');
    })
})

// モーダルを閉じる
const modalCloseButton = document.querySelector('.js-modal-close-button');
modalCloseButton.addEventListener('click',()=>{
    modal.classList.remove('u-display-block');
    recordDown.classList.remove('u-display-flex');
    modalInner.classList.remove('u-display-hidden') ;
})

const tweetCheckBox = document.querySelector('.js-tweet-checkbox')
const tweetArea = document.getElementById("js-tweet-area");
const tweet = () => {
    if (tweetCheckBox.checked) {
      const tweetText = `${tweetArea.value}`;
      window.open(`http://twitter.com/intent/tweet?&text=${tweetText}`);
    }
  }; //ツイート機能

//記録投稿ボタンを押したとき＝ ローディング画面
const modalInner = document.querySelector('.js-modal-inner');
const record = document.querySelector('.js-button-record-done');
const nowLoading = document.querySelector('.js-now-loading');
    record.addEventListener('click',()=>{
        tweet();
    modalInner.classList.add('u-display-hidden')
    modalCloseButton.classList.add('u-display-hidden') 
    nowLoading.classList.add('u-display-block')
    // 3秒後に投稿完了画面に切り替わる
    setTimeout(showRecordDown,3000)
})

const recordDown = document.querySelector('.js-record-done');
function showRecordDown() {
    nowLoading.classList.remove('u-display-block') 
    modalCloseButton.classList.remove('u-display-hidden') 
    recordDown.classList.add('u-display-flex')
}






