// javascript;'use strict';
console.log('JavaScript');
function check(question_no, selected_no, valid_no) {



    const selected = document.getElementById("answerlist_" + question_no + "_" + selected_no); 
    selected.classList.add("incorrect-buttons")
    
    const valid = document.getElementById("answerlist_" + question_no + "_" + valid_no);
}