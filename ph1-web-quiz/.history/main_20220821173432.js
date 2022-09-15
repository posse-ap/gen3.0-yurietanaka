// javascript;'use strict';


// console.log("aa")
// function check(question_no, selected_no, valid_no) {



//     const selected = document.getElementById("answerlist_" + question_no + "_" + selected_no); 
//     selected.classList.add("incorrect-buttons")
    
//     const valid = document.getElementById("answerlist_" + question_no + "_" + valid_no);
//     valid.classList.add("incorrect-buttons")
// }

// // 関数を実行する
// function hello(){
//     console.log("hello")
// }
// hello()

// // 引き数
// function hello(name){
//     console.log("hello"+name)
// }
// hello("yurie")
// hello("ponta")

// if文

// // for文

// // for(let i = 0; i < 5;i++){
// //     console.log(i)
// // }

// // foreach 配列の数だけループする
// const array = ["あ","い","う","え","お"]
// array.forEach(function(onokan,index,){
//     console.log()
// })
// // foreachの第一引き数onokanは配列の一つ一つの中身を返す
// // 第二引き数indexは配列番号を返す
// console.log(array)


// Object １つのkey に対して一つの値をとる
const obj = {
    name : "makoto" ,
    type : "明るい",
    university : "早稲田"
}
console.log(obj.type)
console.log(Object.values(obj))
