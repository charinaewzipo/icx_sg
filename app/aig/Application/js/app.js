$(function () {
    $.ajaxSetup({
        url: "app_process.php"
    });
    $body = $("body");
    $(document).on({
        ajaxStart: function () { $body.addClass("loading"); },
        ajaxStop: function () { $body.removeClass("loading"); }
    });

    let intervalId;
    let min = 0;
    let sec = 0;

    $('#secure_pause').on('click', function() {
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        localStorage.setItem("securepause",true);
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'PAUSED', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    if(response.data.recordingState == "PAUSED"){
                        $(this).css("color", "red");
                        displayPauseTime();
                    }
                    alert('Recording state1 ' + response.data.recordingState);
                } else {
                    alert('Recording state2 ' + response.data);
                }
            }
        });
    });

    
    $('#btnPaymentBilling').on('click', function() {
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        localStorage.setItem("securepause",true);
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'PAUSED', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    if(response.data.recordingState == "PAUSED"){
                        displayPauseTime();
                    }
                    alert('Recording state1 ' + response.data.recordingState);
                } else {
                    alert('Recording state2 ' + response.data);
                }
            }
        });
    });

    $('#btnPaymentOnline').on('click', function() {
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        localStorage.setItem("securepause",true);
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'PAUSED', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    if(response.data.recordingState == "PAUSED"){
                        displayPauseTime();
                    }
                    alert('Recording state1 ' + response.data.recordingState);
                } else {
                    alert('Recording state2 ' + response.data);
                }
            }
        });
    });
    

    function displayPauseTime() {
        if(intervalId == null){
            min = 0;
            sec = 0;
            intervalId = setInterval(pauseTimer, 1000);
            //console.log("intervalId",intervalId);
        }
    }

    function pauseTimer() {
        window.focus();
        var strPause = "Pause " + min + " minutes " + sec + " seconds";
        document.title = (document.title === "Application Form") ? strPause : "Application Form";
        document.getElementById("pauseDisplay").innerHTML = strPause;
        sec++;
        if (sec >= 60) {
            sec = 0;
            min++;
        }
    }

    function clearPauseTime() {
        document.title = "Application Form";
        document.getElementById("pauseDisplay").innerHTML = "";
        clearInterval(intervalId);
        intervalId = null;
    }

    $('#unsecure_pause').on('click', function() {
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'ACTIVE', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    clearPauseTime();
                    alert('Recording state1 ' + response.data.recordingState);
                } else {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    clearPauseTime();
                    alert('Recording state2 ' + response.data);
                }
            }
        });
    });
    
    $('#payment_key').on('change', function() {
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'ACTIVE', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    clearPauseTime();
                    alert('Recording state ' + response.data.recordingState);
                } else {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    alert('Recording state ' + response.data);
                }
            }
        });
    });

    $('#btnPaste').on('click', function() {
        $('#payment_key').focus();
        pasteText();
        let voiceid = localStorage.getItem("voiceid");
        let lastInteraction = localStorage.getItem("lastInteraction");
        $.ajax({
            'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'ACTIVE', 'agentid': uid },
            'dataType': 'html',
            'type': 'POST',
            'success': function (data) {
                let response = eval('(' + data + ')');
                if (response.result) {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    clearPauseTime();
                    alert('Recording state ' + response.data.recordingState);
                } else {
                    $('#secure_pause').css("color", "");
                    localStorage.removeItem("securepause");
                    alert('Recording state ' + response.data);
                }
            }
        });
    });
    async function pasteText() {
        const text = await navigator.clipboard.readText();
        $('#payment_key').val(text);
        console.log('Text pasted.',text);
    }



    $('#datepicker3').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="DOB_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="INSURED_DOB2_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="INSURED_DOB3_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="INSURED_DOB4_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="INSURED_DOB5_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('#datepicker4').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('#datepicker5').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="Approved_Date_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="Effective_Date_V"]').datepicker($.extend({}, $.datepicker.regional.th, {
        yearRange: "c-80:c",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    }));

    $('input[name="ACCOUNT_EXPIRE"]').datepicker($.extend({}, {
        yearRange: "c-1:c+10",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/y'
    }));

    function maskCreditCardNumbers(text) {
        const creditCardPattern = /\b(?:\d[ -]*?){13,19}\b/g;
    
        const maskCard = (card) => {
            const cleaned = card.replace(/\D/g, '');
            return cleaned.slice(0, -4).replace(/\d/g, '*') + cleaned.slice(-4);
        };
    
        return text.replace(creditCardPattern, (match) => {
            return maskCard(match);
        });
    }
    
    const textArea = document.getElementById('REMARK');
    
    textArea.addEventListener('blur', function() {
        this.value = maskCreditCardNumbers(this.value);
    });


});