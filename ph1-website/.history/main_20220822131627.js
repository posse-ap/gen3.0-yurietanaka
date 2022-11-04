'use strict';

const question = [
    {
        questionText : "日本のIT人材が2030年には最大どれくらい不足すると言われているでしょうか?",
        select : ["約28万人", "約79万人","約183万人"],
        answer :  "約79万人",
    },
    {
        questionText : "既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？",
        select : ["INTECH","BIZZTECH"," X-TECH"],
        answer : " X-TECH",
    },
    {
        questionText : "IoTとは何の略でしょう?",
        select : ["Internet of Things","Integrate into Technology","Information on Tool"],
        answer : "Internet of Things",
    }
    {
        questionText : "イギリスのコンピューター科学者であるギャビン・ウッド氏が提唱した、ブロックチェーン技術を活用した「次世代分散型インターネット」のことをなんと言うでしょう？"
        select : ["Society 5.0","CyPhy","SDGs"]
        ansewr : "Society 5.0"
    }
    {
        questionText : ""
        select :
        answer 
    }
]


// htmlの生成　問題の表示
function create(questionNumber,questionText,selectArray){
    let quiz = `<section data-quiz="1">
    <h2 class="questions">
        <span class="q-number">Q${questionNumber}</span>
        <span class="q-passage">${questionText}</span>
    </h2>
    <img src="./assets-ph1-website-main 2/img/quiz/img-quiz0${questionNumber}.png"  class="q-pic">
    <span class="answer">A</span>
    <ul class="buttons">`
    selectArray.forEach(function(value,index){
        quiz +=`<li>
            <button>
                ${value}
            </button>
        </li>`
    } )
    quiz +=`</ul>
    </section>`
    const quizpage = document.querySelector('.quizpage');
    quizpage.insertAdjacentHTML('beforeend',quiz)
}

question.forEach(function(value,index){
    
    create(index+1,value.questionText,value.select)
})

