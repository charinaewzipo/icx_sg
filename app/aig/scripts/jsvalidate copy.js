$(document).ready(function () {
    function exactAge(birthdate) {
        let startDate = new Date(new Date(birthdate).toISOString().substr(0, 10));
        const endingDate = new Date().toISOString().substr(0, 10); // YYYY-MM-DD
        let endDate = new Date(endingDate);
        if (startDate > endDate) {
            const swap = startDate;
            startDate = endDate;
            endDate = swap;
        }
        const startYear = startDate.getFullYear();

        // Leap years
        const february = (startYear % 4 === 0 && startYear % 100 !== 0) || startYear % 400 === 0 ? 29 : 28;
        const daysInMonth = [31, february, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        let yearDiff = endDate.getFullYear() - startYear;
        let monthDiff = endDate.getMonth() - startDate.getMonth();
        let dayDiff = endDate.getDate() - startDate.getDate();

        if (monthDiff < 0) {
            yearDiff--;
            monthDiff += 12;
        }

        if (dayDiff < 0) {
            if (monthDiff > 0) {
                monthDiff--;
            } else {
                yearDiff--;
                monthDiff = 11;
            }
            dayDiff += daysInMonth[startDate.getMonth()];
        }

        return {
            years: yearDiff,
            months: monthDiff,
            days: dayDiff,
        };
    }

    function checkRules() {
        let AppStatus = $('select[name="AppStatus"]').val();
        const statusFollow = [ "Follow-doc","Follow Doc" ];
        if ($.inArray( AppStatus, statusFollow ) === -1) {
            return true;
        }
        return false;
    }

    function getPremium() {
        //alert("I am an alert box!");

        let setValue = (C_PRE, C_PAY, PFREQQ) => {
            if (PFREQQ == 'รายเดือน' && C_PRE) {
                C_PAY = C_PRE * 2;
            }
            else{
                C_PAY = C_PRE;
            }
            $('input[name="INSTALMENT_PREMIUM"]').val(C_PRE);
            $('input[name="INSTALMENT_COPY"]').val(C_PAY);
        }

        let P_NAME = $('select[name="PRODUCT_NAME"]').val();
        let C_NAME = $('select[name="COVERAGE_NAME"]').val();
        let PFREQQ = $('select[name="PAYMENTFREQUENCY"]').val();
        let AGE_A = $('input[name="ADE_AT_RCD"]').val();
        let C_PRE = "";
        let C_PAY = "";
        let CAMP = $('input[name="campaign_id"]').val();

        let url = "AjaxGetPrmiumD2C.php?PRODUCT_NAME=" + P_NAME + "&COVERAGE_NAME=" + C_NAME + "&PAYMENTFREQUENCY=" + PFREQQ + "&AGE=" + AGE_A + "&CAMPAIGN_ID=" + CAMP;

        $.get(url).done((data) => {
            var response = JSON.parse(data);
            C_PRE = $.isNumeric(response.premium_payment) ? parseInt(response.premium_payment) : "";
            setValue(C_PRE, C_PAY, PFREQQ);
            $('input[name="PLAN_LAYER_CODE"]').val(response.PLAN_LAYER_CODE);
        }).fail(() => {
            C_PRE = "";
            setValue(C_PRE, C_PAY, PFREQQ);
            $('input[name="PLAN_LAYER_CODE"]').val("");
        });

    }
    function binddata() {
        let securepause = localStorage.getItem("securepause");
        if(securepause) {
            $('#secure_pause').css("color", "red");
        } else {
            $('#secure_pause').css("color", "");
        }
        getPremium();
    };
    $('input[name="DOB_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="ADE_AT_RCD"]').val(age_obj.years);
        $('input[name="DOB"]').val(dob.format('DD/MM/YYYY'));
        getPremium();
    });
    $('select[name="PRODUCT_NAME"]').on("change", function () {
        getPremium();
    });
    $('select[name="COVERAGE_NAME"]').on("change", function () {
        getPremium();
    });
    $('select[name="PAYMENTFREQUENCY"]').on("change", function () {
        getPremium();
    });
    $('input[name="INSURED_DOB2_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="INSURED_DOB2"]').val(dob.format('DD/MM/YYYY'));
    });
    $('input[name="INSURED_DOB3_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="INSURED_DOB3"]').val(dob.format('DD/MM/YYYY'));
    });
    $('input[name="INSURED_DOB4_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="INSURED_DOB4"]').val(dob.format('DD/MM/YYYY'));
    });
    $('input[name="INSURED_DOB5_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="INSURED_DOB5"]').val(dob.format('DD/MM/YYYY'));
    });
    $('input[name="Approved_Date_V"]').on("change", function () {
        let approve = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        $('input[name="Approved_Date"]').val(approve.format('DD/MM/YYYY'));
    });
    $('input[name="Effective_Date_V"]').on("change", function () {
        let dob = moment($.datepicker.getYMD('input[name="' + $(this).attr("name") + '"]'), "YYYY-MM-DD");
        let age_obj = exactAge(dob);
        $('input[name="Effective_Date"]').val(dob.format('YYYY/MM/DD'));
    });
    $('button.payment').on("click", function () {
        let voiceid = localStorage.getItem('voiceid');
        if (voiceid) {

        }
    });

    binddata();

    $.validator.addMethod('checkAddress1', (value, element, param) => {
        return (($("input[name='ADDRESSNO1']").val().length) <= 45);
    }, 'max length 45!');

    $.validator.addMethod('checkAddress2', (value, element, param) => {
        return (($("input[name='BUILDING1']").val().length) <= 45);
    }, 'max length 45!');

    $.validator.addMethod('checkPercent', (value, element, param) => {
        const bene1 = parseInt($("input[name='BENEFICIARY_BENEFIT1']").val()) || 0;
        const bene2 = parseInt($("input[name='BENEFICIARY_BENEFIT2']").val()) || 0;
        const bene3 = parseInt($("input[name='BENEFICIARY_BENEFIT3']").val()) || 0;
        const bene4 = parseInt($("input[name='BENEFICIARY_BENEFIT4']").val()) || 0;
        const checkP = bene1 + bene2 + bene3 + bene4;
        return (checkP == 100);
    }, '100 Percent only!');

    $.validator.addMethod('checkBenefit', (value, element, param) => {
        const bene1 = $("input[name='BENEFICIARY_NAME1']").val() || "";
        const bene2 = $("input[name='BENEFICIARY_NAME2']").val() || "";
        const bene3 = $("input[name='BENEFICIARY_NAME3']").val() || "";
        const bene4 = $("input[name='BENEFICIARY_NAME4']").val() || "";
        const checkP = bene1 + bene2 + bene3 + bene4;
        return ((checkP == "" && $(element).prop("checked")) || (checkP != "" && !$(element).prop("checked")));
    }, 'Please check!');

    $.validator.addMethod("nameCard", (value, element) => {
        return /^[A-Z\s\.]+[A-Z]$/.test(value);
    }, "Incorrect credit card name!");

    $.validator.addMethod("PaymentKey", (value, element) => {
        return /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]{16})$/.test(value);
    }, "Incorrect payment key!");

    $.validator.addMethod("CheckBin", (value, element) => {
        var check_bin = document.getElementById("check_bin").value.substr(0,6);
        console.log("check_bin=",check_bin);
        console.log("checkRules=",checkRules());
        if(check_bin == "1" && checkRules() == true){
            var binConfig = document.getElementById("divBin").innerHTML;
            var jsonBin = JSON.parse(binConfig);
            console.log("binConfig=",jsonBin);
            var campaign_id = document.getElementById("campaign_id").value;
            console.log("campaign_id=",campaign_id);
            var binKey = document.getElementById("payment_key").value.substr(0,6);
            console.log("binKey=",binKey);
            for (var i = 0; i < jsonBin.length; i++) {
                if(jsonBin[i].campaign_id == campaign_id && jsonBin[i].BIN_Number == binKey){
                    return true;
                }
            }
            return false;
        }
        else{
            return true;
        }
    }, "Credit card not match!");

    $('#submit').on('click', () => {
        $('input[name="ACCOUNT_NAME"]').val (function () {
            return this.value.toUpperCase();
        });
        $("form#application").submit();
    });

    $("#application").validate({
        rules: {
            TITLE: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            FIRSTNAME: {
                required: true,
                maxlength: 60
            },
            LASTNAME: {
                required: true,
                maxlength: 60
            },
            SEX: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            DOB: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                maxlength: 10
            },
            DOB_V: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                maxlength: 10
            },
            ADE_AT_RCD: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                maxlength: 2
            },
            IDCARD: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                minlength: 13,
                maxlength: 13,
                digits: true
            },
            INSURED_STATUS: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            APP_CONSENT: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            ADDRESSNO1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                checkAddress1: true
            },
            BUILDING1: {
                checkAddress2: true
            },
            SUB_DISTRICT1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            DISTRICT1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            PROVINCE1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            ZIPCODE1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            TELEPHONE1: {
                maxlength: 9
            },
            MOBILE1: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                maxlength: 10
            },
            PRODUCT_NAME: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            COVERAGE_NAME: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            PAYMENTFREQUENCY: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            GIVEN_BENAFICIARY: {
                checkBenefit: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            INSTALMENT_PREMIUM: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },
            ACCOUNT_NAME: {
                nameCard: {
                    depends: function (element) {
                        return checkRules();
                    }
                }
            },
            payment_key: {
                PaymentKey: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
                CheckBin: {
                    depends: function (element) {
                        return true;
                    }
                },
                minlength: 16,
                maxlength: 16
            },
            INSTALMENT_COPY: {
                required: {
                    depends: function (element) {
                        return ($('select[name="PAYMENTFREQUENCY"]').val() == 'รายเดือน');
                    }
                }
            },
            BENEFICIARY_NAME1: {
                required: {
                    depends: function (element) {
                        return (($("input[name='BENEFICIARY_BENEFIT1']").val().length || $("input[name='GIVEN_BENAFICIARY']").prop("checked") == false) && checkRules());
                    }
                },
            },
            BENEFICIARY_NAME2: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_BENEFIT2']").val().length && checkRules();
                    }
                },
            },
            BENEFICIARY_NAME3: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_BENEFIT3']").val().length && checkRules();
                    }
                },
            },
            BENEFICIARY_NAME4: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_BENEFIT4']").val().length && checkRules();
                    }
                },
            },
            BENEFICIARY_BENEFIT1: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME1']").val().length && checkRules();
                    }
                },
                checkPercent: {
                    param: true,
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME1']").val().length;
                    }
                }
            },
            BENEFICIARY_BENEFIT2: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME2']").val().length && checkRules();
                    }
                },
                checkPercent: {
                    param: true,
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME2']").val().length;
                    }
                }
            },
            BENEFICIARY_BENEFIT3: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME3']").val().length && checkRules();
                    }
                },
                checkPercent: {
                    param: true,
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME3']").val().length;
                    }
                }
            },
            BENEFICIARY_BENEFIT4: {
                required: {
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME4']").val().length && checkRules();
                    }
                },
                checkPercent: {
                    param: true,
                    depends: function (element) {
                        return $("input[name='BENEFICIARY_NAME4']").val().length;
                    }
                }
            },
            /*ACCOUNT_EXPIRE: {
                required: {
                    depends: function (element) {
                        return checkRules();
                    }
                },
            },*/
        },
        submitHandler: function (form) {
            let path = window.location.pathname;
            let pathindex = path.lastIndexOf('/') + 1;
            let curfile = path.substring(pathindex, pathindex + 3);
            let urlfile = "app_update.php";
            if (curfile == 'new') {
                urlfile = "newApp_save.php";
            }
            $.post(urlfile, $("#application").serialize(), (data) => {
                alert(data.data);
		console.log('datafromjsvalidate',data);
                if (data.result == 'success') {
                    $('#submit').prop('disabled', true)
                    window.location = data.url;
                }
            }, "json");
        }
    });
});