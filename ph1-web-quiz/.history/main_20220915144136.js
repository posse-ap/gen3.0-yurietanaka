'use strict';

const question = [
    {
        questionText : "日本のIT人材が2030年には最大どれくらい不足すると言われ<br>ているでしょうか?",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz01.png",
        select : ["約28万人", "約79万人","約183万人"],
        answer :  1,
        note : "経済産業省 2019年3月 - IT 人材需給に関する調査"
    },
    {
        questionText : "既存業界のビジネスと、先進的なテクノロジーを結びつけて<br>生まれた、新しいビジネスのことをなんと言うでしょう？",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz02.png",
        select : ["INTECH","BIZZTECH"," X-TECH"],
        answer : 2
    },
    {
        questionText : "IoTとは何の略でしょう?",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz03.png",
        select : ["Internet of Things","Integrate into Technology","Information on Tool"],
        answer : 0
    },
    {
        questionText : "日本が目指すサイバー空間とフィジカル空間を高度に融合させたシステムによって開かれる未来社会のことをなんと言うでしょうか？",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz04.png",
        select : ["Society 5.0","CyPhy","SDGs"],
        answer : 0,
        note :"Society5.0 - 科学技術政策 - 内閣府"
    },
    {
        questionText : "イギリスのコンピューター科学者であるギャビン・ウッド氏<br>が提唱した、ブロックチェーン技術を活用した「次世代分散<br>型インターネット」のことをなんと言うでしょう？",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz05.png",
        select :["Web3.0","NFT","メタバース"],
        answer : 0
    },
    {
        questionText : "先進テクノロジー活用企業と出遅れた企業の収益性の差はど<br>れくらいあると言われているでしょうか？",
        img : "./assets-ph1-website-main 2/img/quiz/img-quiz06.png",
        select :["約2倍","約5倍","約11倍"],
        answer : 1,
        note : "Accenture Technology Vision 2021"
    }
]
function shuffle(Array)
{
    for (let i = Array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [Array[j], Array[i]] = [Array[i], Array[j]];
        }
        return Array;
}
const shuffledQuestion=shuffle(question)

// htmlの生成　問題の表示
function create(questionNumber,questionText,selectArray){

    const noteHtml=shuffledQuestion[questionNumber-1].note ? `
        <cite class="cite">
        <div>
        <img src="./assets-ph1-website-main 2/img/icon/icon-note.svg">
        </div>
        ${shuffledQuestion[questionNumber-1].note}
        </cite>
    `: "";
    let quiz = `
    <section data-quiz="1" class="p-quiz-box">
    <div class="q-container">
    <h2 class="questions">
        <span class="q-number">Q${questionNumber}</span>
        <span class="q-passage">${questionText}</span>
    </h2>
    <img src="${shu}" class="q-pic">
    </div>

    <div class="p-quiz-box-answer">
    <span class="answer">A
    </span>
    <ul class="buttons" id="select_${questionNumber}">`
    selectArray.forEach(function(value,index){
        quiz +=`<li class="btn arrow" id="select_${questionNumber}_${index}">
                ${value}
        </li>`
    } )
    quiz +=`</ul>
    <div class="answer-box" id="answer-box-${questionNumber}">
    <h3 class="yes">正解！</h3>
    <span class="A">A</span>
    <span>${shuffledQuestion[questionNumber-1].select[shuffledQuestion[questionNumber-1].answer]}</span>
    </div>

    <div class="x-answer-box" id="x-answer-box-${questionNumber}">
    <h3 class="no">不正解...</h3>
    <span class="A">A</span>
    <span class"">${shuffledQuestion[questionNumber-1].select[shuffledQuestion[questionNumber-1].answer]}</span>
    </div>
    ${noteHtml}
    </div>
    </section>`
    const quizpage = document.querySelector('.quizpage');
    quizpage.insertAdjacentHTML('beforeend',quiz)
}


shuffledQuestion.forEach(function(value,index){
    create(index+1,value.questionText,value.select)
    for(let i = 0; i < value.select.length;i++){
        const question =document.getElementById(`select_${index+1}`)
        const selection = document.getElementById(`select_${index+1}_${i}`) 
        const answerBox =document.getElementById(`answer-box-${index+1}`)
        const XAnswerBox =document.getElementById(`x-answer-box-${index+1}`)

        selection.addEventListener("click",function(){

            if(i == value.answer){
                selection.classList.add("correct-button")
                answerBox.classList.add("show")
                question.classList.add("pointer-none")
            }else{
                selection.classList.add("incorrect-button")
                XAnswerBox.classList.add("show")
                question.classList.add("pointer-none")
            }
        },)
    }
})