// ==================================================
// Project Name  :  Quizo
// File          :  JS Base
// Version       :  1.0.0
// Author        :  jthemes (https://themeforest.net/user/jthemes)
// ==================================================
$(function(){
  "use strict";
  // ========== Form-select-option ========== //
  $(".step_1").on('click', function(){
    $(".step_1").removeClass("active");
    $(this).addClass("active");
  });
  $(".step_2").on('click', function(){
    $(".step_2").removeClass("active");
    $(this).addClass("active");
  });
  $(".step_3").on('click', function(){
    $(".step_3").removeClass("active");
    $(this).addClass("active");
  });
  $(".step_4").on('click', function(){
    $(".step_4").removeClass("active");
    $(this).addClass("active");
  });

    $(document).ready(function () {
        $(document).on("click", ".step_answer", function () {
            $('#nextBtn').attr('is-correct', $(this).data('is-correct'))
            $('#nextBtn').attr('answer-id', $(this).data('area'))
            $('#nextBtn').attr('question-id', $(this).data('question-id'))
            $(".step_answer").removeClass("active");
            $(this).addClass("active");
        });
    });
});

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("multisteps_form_panel");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "End Quiz";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next Question";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function displayMsg(is_correct, answer_id, question_id) {
    var title = is_correct == 1 ? $('#nextBtn').attr('correct-answer') : $('#nextBtn').attr('failed-answer')
    var icon = is_correct == 1 ? 'success' : 'error'
    var answer_class = is_correct == 1 ? 'correct_answer' : 'failed_answer'
    if (is_correct == 0) {
        $('#answer_label_' + answer_id).addClass(answer_class)
        $('.answer_label_' + question_id +'.answer_label_1').addClass('correct_answer')
        $('.answer_image_' + question_id +'.answer_image_1').removeClass('hidden')
    } else {
        Swal.fire({
            position: 'center',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 2000
        });
    }
}

function nextPrev(n) {
    var is_correct = $('#nextBtn').attr('is-correct');
    var question_id = $('#nextBtn').attr('question-id');
    var answer_id = $('#nextBtn').attr('answer-id');
    var answer_value = $('#opt_' + answer_id).val();

    if (answer_value) {
        displayMsg(is_correct, answer_id, question_id);
    }

    $('#nextBtn').attr('is-correct', '')
    $('#nextBtn').attr('answer-id', '')

    setTimeout(function(){
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("multisteps_form_panel");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            //...the form gets submitted:
            document.getElementById("wizard").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }, 2000);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("multisteps_form_panel");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
