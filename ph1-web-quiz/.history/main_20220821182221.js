javascript;'use strict';

const question = [
    {
        questionText : "日本のIT人材が2030年には最大どれくらい不足すると言われているでしょうか？",
        select : ["約28万人", "約79万人","約183万人"],
        answer :  "約79万人",
    },
    {
        questionText : "既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？",
        select : ["INTECH","BIZZTECH"," X-TECH"],
        answer : " X-TECH",
    },
    {
        questionText : "IoTとは何の略でしょう？",
        select : ["Internet of Things","Integrate into Technology","Information on Tool"],
        answer : "Internet of Things",
    }
]



function create(){
    const quiz = `<section data-quiz="1">
    <h2 class="questions">
        <span class="q-number">Q2</span>
        <span class="q-passage">既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？</span>
    </h2>
    <img src="./assets-ph1-website-main 2/img/quiz/img-quiz02.png"  class="q-pic">
    <span class="answer">A</span>
    <ul class="buttons">
        <li>
            <button data-answer="0">
                INTECH
            </button>
        </li>

        <li>
            <button data-answer="1">
                BIZZTECH<i class=""></i>
            </button>
        </li>

        <li>
            <button  data-answer="2">
                X-TECH<i class=""></i>
            </button>
        </li>
    </ul>
</section>`
}