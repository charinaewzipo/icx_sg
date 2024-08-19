$(function () {
  $.validator.addMethod(
    "time24",
    function (value, element) {
      if (!/^\d{2}:\d{2}:\d{2}$/.test(value)) return false;
      var parts = value.split(":");
      if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
      return true;
    },
    "Invalid time format."
  );
  function bindQC() {
    let sum = 0;
    $(".qc_answer").each(function (index, value) {
      if ($(value).find('input[type="radio"]:checked').val() == "true") {
        const score = parseFloat(
          $(value).parent().find("input[name^='score']").val()
        );
        console.log(sum, value);
        sum = sum + score;
      }
    });
    $(".qc_score td:eq(1)").html(scoreToGrade(sum));

    // Insert sum value into input field with name "qc_score"
    $("input[name='qc_score']").val(sum);
  }
  function scoreToGrade(score) {
    console.log(score);
    let grade = score + "%";
    switch (true) {
      case score >= 95:
        grade = grade + " A";
        break;
      case score >= 90:
        grade = grade + " B";
        break;
      case score >= 85:
        grade = grade + " C";
        break;
      default:
        grade = grade + " D";
    }
    return grade;
  }
  function bindQA() {
    let sum = 0;
    $(".qa_answer").each(function (index, value) {
      if ($(value).find('input[type="radio"]:checked').val() == "true") {
        const score = parseFloat(
          $(value).parent().find("input[name^='score']").val()
        );
        sum = sum + score;
      }
    });
    $(".qa_score td:eq(1)").html(scoreToGrade(sum));
    // Insert sum value into input field with name "qa_score"
    $("input[name='qa_score']").val(sum);
  }

  //Load
  bindQC();
  bindQA();
  $("input[name^='answer']").on("change", function () {
    if ($(this).val() == "fault") {
      $(this).parent().parent().css("color", "red");
    } else {
      $(this).parent().parent().css("color", "");
    }
    bindQC();
  });

  $("input[name^='qaanswer']").on("change", function () {
    bindQA();
  });

  $("form[name='App']").validate({
    rules: {
      talk_time: {
        maxlength: 8,
        minlength: 8,
        required: true,
        time24: true,
      },
    },
    submitHandler: function (form) {
      // do other things for a valid form
      form.submit();
    },
  });

  if ([1].includes(user_lv)) {
    $(".qc_answer").show();
    $(".qa_answer").hide();
    $(".qa_answer input[type='radio']").attr("disabled", true);
    $(".qc_answer input[type='radio']").attr("disabled", true);
  } else if ([3].includes(user_lv)) {
    $(".qa_answer").show();
    $(".qc_answer").show();
    $(".qa_answer input[type='radio']").attr("disabled", true);
    $(".qc_answer input[type='radio']").attr("disabled", false);
  } else if ([7].includes(user_lv)) {
    $(".qa_answer").show();
    $(".qc_answer").show();
    $(".qa_answer input[type='radio']").attr("disabled", false);
    $(".qc_answer input[type='radio']").attr("disabled", true);
  } else {
    $(".qa_answer").show();
    $(".qc_answer").show();
    $(".qa_answer input[type='radio']").attr("disabled", true);
    $(".qc_answer input[type='radio']").attr("disabled", true);
  }
});
