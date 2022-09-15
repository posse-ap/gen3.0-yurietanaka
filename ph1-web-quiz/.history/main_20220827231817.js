'use strict';

const question = [
    {
        questionText : "日本のIT人材が2030年には最大どれくらい不足すると言われ<br>ているでしょうか?",
        select : ["約28万人", "約79万人","約183万人"],
        answer :  1,
        note : "経済産業省 2019年3月 - IT 人材需給に関する調査"
    },
    {
        questionText : "既存業界のビジネスと、先進的なテクノロジーを結びつけて<br>生まれた、新しいビジネスのことをなんと言うでしょう？",
        select : ["INTECH","BIZZTECH"," X-TECH"],
        answer : 2,
    },
    {
        questionText : "IoTとは何の略でしょう?",
        select : ["Internet of Things","Integrate into Technology","Information on Tool"],
        answer : 0,
    },
    {
        questionText : "イギリスのコンピューター科学者であるギャビン・ウッド氏<br>が提唱した、ブロックチェーン技術を活用した「次世代分散<br>型インターネット」のことをなんと言うでしょう？",
        select : ["Society 5.0","CyPhy","SDGs"],
        answer : 0,
        note :"Society5.0 - 科学技術政策 - 内閣府"
    },
    {
        questionText : "イギリスのコンピューター科学者であるギャビン・ウッド氏<br>が提唱した、ブロックチェーン技術を活用した「次世代分散<br>型インターネット」のことをなんと言うでしょう？",
        select :["Web3.0","NFT","メタバース"],
        answer : 0,
    },
    {
        questionText : "先進テクノロジー活用企業と出遅れた企業の収益性の差はど<br>れくらいあると言われているでしょうか？",
        select :["約2倍","約5倍","約11倍"],
        answer : 1,
    }
]
console.log(question[0].select[question[0].answer]);

console.log(question[0].answer)

// htmlの生成　問題の表示
function create(questionNumber,questionText,selectArray){
    let quiz = `
    <section data-quiz="1" class="p-quiz-box">
    <div class="q-container">
    <h2 class="questions">
        <span class="q-number">Q${questionNumber}</span>
        <span class="q-passage">${questionText}</span>
    </h2>
    <img src="./assets-ph1-website-main 2/img/quiz/img-quiz0${questionNumber}.png"  class="q-pic">
    </div>

    <div class="p-quiz-box-answer">
    <span class="answer">A
    </span>
    <ul class="buttons">`
    selectArray.forEach(function(value,index){
        quiz +=`<li class="btn arrow" id="select_${questionNumber}_${index}">
                ${value}
        </li>`
    } )
    quiz +=`</ul>
    <div class="answer-box" id="answer-box-${questionNumber}">
    <h3>正解！</h3>
    <span class="A">A</span>
    <span>${question[questionNumber-1].select[question[questionNumber-1].answer]}</span>
    </div>

    <div class="x-answer-box" id="x-answer-box-${questionNumber}">
    <h3>不正解！</h3>
    <span class="A">A</span>
    <span>${question[questionNumber-1].select[question[questionNumber-1].answer]}</span>
    </div>
    </div>

    </section>`
    const quizpage = document.querySelector('.quizpage');
    quizpage.insertAdjacentHTML('beforeend',quiz)
}


question.forEach(function(value,index){
    create(index+1,value.questionText,value.select)
    for(let i = 0; i < value.select.length;i++){
        const selection = document.getElementById(`select_${index+1}_${i}`) 
        const answerBox =document.getElementById(`answer-box-${index+1}`)
        const XAnswerBox =document.getElementById(`x-answer-box-${index+1}`)

        selection.addEventListener("click",function(){
            // if(
            // isAnswered === true
            // ){
            // return
            // }
            // isAnswered = true;

            if(i == value.answer){
                selection.firstElementChild.classList.add("correct-button")
                answerBox.classList.add("show")
            }else{
                selection.firstElementChild.classList.add("incorrect-button")
                XAnswerBox.classList.add("show")
            }
        },)
    }
})