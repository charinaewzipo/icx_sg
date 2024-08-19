/*! jQuery UI - v1.12.1 - 2016-09-14
* http://jqueryui.com
* Includes: widget.js, position.js, data.js, disable-selection.js, effect.js, effects/effect-blind.js, effects/effect-bounce.js, effects/effect-clip.js, effects/effect-drop.js, effects/effect-explode.js, effects/effect-fade.js, effects/effect-fold.js, effects/effect-highlight.js, effects/effect-puff.js, effects/effect-pulsate.js, effects/effect-scale.js, effects/effect-shake.js, effects/effect-size.js, effects/effect-slide.js, effects/effect-transfer.js, focusable.js, form-reset-mixin.js, jquery-1-7.js, keycode.js, labels.js, scroll-parent.js, tabbable.js, unique-id.js, widgets/accordion.js, widgets/autocomplete.js, widgets/button.js, widgets/checkboxradio.js, widgets/controlgroup.js, widgets/datepicker.js, widgets/dialog.js, widgets/draggable.js, widgets/droppable.js, widgets/menu.js, widgets/mouse.js, widgets/progressbar.js, widgets/resizable.js, widgets/selectable.js, widgets/selectmenu.js, widgets/slider.js, widgets/sortable.js, widgets/spinner.js, widgets/tabs.js, widgets/tooltip.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */

(function (factory) {
    if (typeof define === "function" && define.amd) {

        // AMD. Register as an anonymous module.
        define(["jquery"], factory);
    } else {

        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    //-----------------------------------------------------------------
    // 2018-03-27 LittleBoy
    //-----------------------------------------------------------------
    $.datepicker.versionPack = "1.12.1";
    $.datepicker.versionPackDate = "2018-03-29";
    $.datepicker._defaults.isBuddhist = false;

    $.datepicker.regional.th = $.extend({}, $.datepicker.regional[""], {
        changeMonth: true,
        changeYear: true,
        dateFormat: 'd M yy',
        isBuddhist: true,
        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
        dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
        monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
    });
    $.datepicker.regional["th-TH"] = $.extend({}, $.datepicker.regional.th);

    $.datepicker.getInst = function (targetOrInst) {
        //console.log("LittleBoy getInst(targetOrInst)", arguments);
        if (typeof targetOrInst === "string") {
            return $(targetOrInst).data("datepicker");
        }
        else {
            if (targetOrInst && targetOrInst.currentYear)
                return targetOrInst;
            else
                return $.datepicker._getInst(targetOrInst);
        }
    };

    $.datepicker.getDate = function (targetOrInst) {
        //console.log("LittleBoy getDate(targetOrInst)", arguments);
        var inst = this.getInst(targetOrInst);

        if (inst) {
            //return inst.id + " (" + inst.currentYear + "," + inst.currentMonth + "," + inst.currentDay + ")";
            var v = inst.input.val().trim();
            //console.log("LittleBoy getDate - inst", inst, v);

            if (v == "") return null;
            var d = $.datepicker.parseDate($.datepicker._get(inst, "dateFormat"),
                v,
                $.datepicker._getFormatConfig(inst));
            return d;
        }
        return null;
    };

    $.datepicker.setDate = function (targetOrInst, dateValue) {
        //console.log("LittleBoy setDate(targetOrInst, dateValue)", arguments);
        var inst = this.getInst(targetOrInst);
        if (inst) {
            this._setDate(inst, dateValue);
            this._updateDatepicker(inst);
            this._updateAlternate(inst);
        }
    };

    // Convert value of target as format YYYY-MM-DD
    // posible target: HtmlElement or Instance from data("datepicker")
    $.datepicker.getYMD = function (targetOrInst) {
        //console.log("LittleBoy getYMD(targetOrInst)", arguments);
        var inst = this.getInst(targetOrInst);

        if (inst) {
            //return inst.id + " (" + inst.currentYear + "," + inst.currentMonth + "," + inst.currentDay + ")";
            var v = inst.input.val().trim();
            //console.log("LittleBoy getYMD - inst", inst, v);

            if (v == "") return "";
            //if(v!=inst.lastVal)
            var d = $.datepicker.parseDate($.datepicker._get(inst, "dateFormat"),
                v,
                $.datepicker._getFormatConfig(inst));

            //var d = new Date(inst.currentYear, inst.currentMonth, inst.currentDay);
            d.setTime(d.getTime() - d.getTimezoneOffset() * 60000);
            if (d !== null) return d.toISOString().substr(0, 10);
        }
        return "";
    };

    $.datepicker.formatDate = function (format, date, settings) {
        //console.log("Rivised LittleBoy formatDate(format,date,settings)", arguments);
        //console.log("Revised LittleBoy formatDate - this", this);
        if (!date) {
            return "";
        }

        // LittleBoy isBuddhist
        var isBuddhist = (settings ? settings.isBuddhist : null) || this._defaults.isBuddhist || false;

        var iFormat,
            dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort,
            dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames,
            monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort,
            monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames,

            // Check whether a format character is doubled
            lookAhead = function (match) {
                var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) === match);
                if (matches) {
                    iFormat++;
                }
                return matches;
            },

            // Format a number, with leading zero if necessary
            formatNumber = function (match, value, len) {
                var num = "" + value;
                if (lookAhead(match)) {
                    while (num.length < len) {
                        num = "0" + num;
                    }
                }
                return num;
            },

            // Format a name, short or long as requested
            formatName = function (match, value, shortNames, longNames) {
                return (lookAhead(match) ? longNames[value] : shortNames[value]);
            },
            output = "",
            literal = false;

        if (date) {
            for (iFormat = 0; iFormat < format.length; iFormat++) {
                if (literal) {
                    if (format.charAt(iFormat) === "'" && !lookAhead("'")) {
                        literal = false;
                    } else {
                        output += format.charAt(iFormat);
                    }
                } else {
                    switch (format.charAt(iFormat)) {
                        case "d":
                            output += formatNumber("d", date.getDate(), 2);
                            break;
                        case "D":
                            output += formatName("D", date.getDay(), dayNamesShort, dayNames);
                            break;
                        case "o":
                            output += formatNumber("o",
                                Math.round((new Date(date.getFullYear(), date.getMonth(), date.getDate()).getTime() - new Date(date.getFullYear(), 0, 0).getTime()) / 86400000), 3);
                            break;
                        case "m":
                            output += formatNumber("m", date.getMonth() + 1, 2);
                            break;
                        case "M":
                            output += formatName("M", date.getMonth(), monthNamesShort, monthNames);
                            break;
                        case "y":
                            // LittleBoy
                            if (isBuddhist) {
                                output += (lookAhead("y") ? date.getFullYear() + 543 :
                                    ((date.getFullYear() + 543) % 100 < 10 ? "0" : "") + (date.getFullYear() + 543) % 100);
                            }
                            else {
                                output += (lookAhead("y") ? date.getFullYear() :
                                    (date.getFullYear() % 100 < 10 ? "0" : "") + date.getFullYear() % 100);
                            }
                            break;
                        case "@":
                            output += date.getTime();
                            break;
                        case "!":
                            output += date.getTime() * 10000 + this._ticksTo1970;
                            break;
                        case "'":
                            if (lookAhead("'")) {
                                output += "'";
                            } else {
                                literal = true;
                            }
                            break;
                        default:
                            output += format.charAt(iFormat);
                    }
                }
            }
        }
        return output;
    };

    $.datepicker.parseDate = function (format, value, settings) {
        //console.log("Revised LittleBoy parseDate(format, value, settings)", arguments);
        // console.log("Revised LittleBoy parseDate - this", this);
        if (format == null || value == null) {
            throw "Invalid arguments";
        }

        value = (typeof value === "object" ? value.toString() : value + "");
        if (value === "") {
            return null;
        }

        // LittleBoy isBuddhist
        var isBuddhist = (settings ? settings.isBuddhist : null) || this._defaults.isBuddhist || false;

        var iFormat, dim, extra,
            iValue = 0,
            shortYearCutoffTemp = (settings ? settings.shortYearCutoff : null) || this._defaults.shortYearCutoff,
            shortYearCutoff = (typeof shortYearCutoffTemp !== "string" ? shortYearCutoffTemp :
                new Date().getFullYear() % 100 + parseInt(shortYearCutoffTemp, 10)),
            dayNamesShort = (settings ? settings.dayNamesShort : null) || this._defaults.dayNamesShort,
            dayNames = (settings ? settings.dayNames : null) || this._defaults.dayNames,
            monthNamesShort = (settings ? settings.monthNamesShort : null) || this._defaults.monthNamesShort,
            monthNames = (settings ? settings.monthNames : null) || this._defaults.monthNames,
            year = -1,
            month = -1,
            day = -1,
            doy = -1,
            literal = false,
            date,

            // Check whether a format character is doubled
            lookAhead = function (match) {
                var matches = (iFormat + 1 < format.length && format.charAt(iFormat + 1) === match);
                if (matches) {
                    iFormat++;
                }
                return matches;
            },

            // Extract a number from the string value
            getNumber = function (match) {
                var isDoubled = lookAhead(match),
                    size = (match === "@" ? 14 : (match === "!" ? 20 :
                        (match === "y" && isDoubled ? 4 : (match === "o" ? 3 : 2)))),
                    minSize = (match === "y" ? size : 1),
                    digits = new RegExp("^\\d{" + minSize + "," + size + "}"),
                    num = value.substring(iValue).match(digits);
                if (!num) {
                    throw "Missing number at position " + iValue;
                }
                iValue += num[0].length;
                return parseInt(num[0], 10);
            },

            // Extract a name from the string value and convert to an index
            getName = function (match, shortNames, longNames) {
                var index = -1,
                    names = $.map(lookAhead(match) ? longNames : shortNames, function (v, k) {
                        return [[k, v]];
                    }).sort(function (a, b) {
                        return -(a[1].length - b[1].length);
                    });

                $.each(names, function (i, pair) {
                    var name = pair[1];
                    if (value.substr(iValue, name.length).toLowerCase() === name.toLowerCase()) {
                        index = pair[0];
                        iValue += name.length;
                        return false;
                    }
                });
                if (index !== -1) {
                    return index + 1;
                } else {
                    throw "Unknown name at position " + iValue;
                }
            },

            // Confirm that a literal character matches the string value
            checkLiteral = function () {
                if (value.charAt(iValue) !== format.charAt(iFormat)) {
                    throw "Unexpected literal at position " + iValue;
                }
                iValue++;
            };

        for (iFormat = 0; iFormat < format.length; iFormat++) {
            if (literal) {
                if (format.charAt(iFormat) === "'" && !lookAhead("'")) {
                    literal = false;
                } else {
                    checkLiteral();
                }
            } else {
                switch (format.charAt(iFormat)) {
                    case "d":
                        day = getNumber("d");
                        break;
                    case "D":
                        getName("D", dayNamesShort, dayNames);
                        break;
                    case "o":
                        doy = getNumber("o");
                        break;
                    case "m":
                        month = getNumber("m");
                        break;
                    case "M":
                        month = getName("M", monthNamesShort, monthNames);
                        break;
                    case "y":
                        year = getNumber("y");
                        break;
                    case "@":
                        date = new Date(getNumber("@"));
                        year = date.getFullYear();
                        month = date.getMonth() + 1;
                        day = date.getDate();
                        break;
                    case "!":
                        date = new Date((getNumber("!") - this._ticksTo1970) / 10000);
                        year = date.getFullYear();
                        month = date.getMonth() + 1;
                        day = date.getDate();
                        break;
                    case "'":
                        if (lookAhead("'")) {
                            checkLiteral();
                        } else {
                            literal = true;
                        }
                        break;
                    default:
                        checkLiteral();
                }
            }
        }

        if (iValue < value.length) {
            extra = value.substr(iValue);
            if (!/^\s+/.test(extra)) {
                throw "Extra/unparsed characters found in date: " + extra;
            }
        }

        //----------------------------
        // LittleBoy
        //----------------------------
        if (isBuddhist) {
            //console.log("LittleBoy parseDate - isBuddhist", settings.isBuddhist)
            if (year === -1) {
                year = new Date().getFullYear();
            } else if (year < 100) {
                var curDate = new Date();
                var diff = (curDate.getFullYear() + 543) - (curDate.getFullYear() + 543) % 100; // -> 2500
                year += diff - 543;
            }
            else
                year -= 543;
        }
        else {
            //console.log("LittleBoy parseDate - isBuddhist: false")
            if (year === -1) {
                year = new Date().getFullYear();
            } else if (year < 100) {
                year += new Date().getFullYear() - new Date().getFullYear() % 100 +
                    (year <= shortYearCutoff ? 0 : -100);
            }
        }
        // End of LittleBoy

        if (doy > -1) {
            month = 1;
            day = doy;
            do {
                dim = this._getDaysInMonth(year, month - 1);
                if (day <= dim) {
                    break;
                }
                month++;
                day -= dim;
            } while (true);
        }

        date = this._daylightSavingAdjust(new Date(year, month - 1, day));
        if (date.getFullYear() !== year || date.getMonth() + 1 !== month || date.getDate() !== day) {
            throw "Invalid date"; // E.g. 31/02/00
        }
        return date;
    };

    $.datepicker._generateMonthYearHeader = function (inst, drawMonth, drawYear, minDate, maxDate,
        secondary, monthNames, monthNamesShort) {
        //console.log("Revised LittleBoy _generateMonthYearHeader (inst, drawMonth, drawYear, minDate, maxDate, secondary, monthNames, monthNamesShort)", arguments);
        //console.log("Revised LittleBoy _generateMonthYearHeader - this", this);

        var inMinYear, inMaxYear, month, years, thisYear, determineYear, year, endYear,
            changeMonth = this._get(inst, "changeMonth"),
            changeYear = this._get(inst, "changeYear"),
            showMonthAfterYear = this._get(inst, "showMonthAfterYear"),
            html = "<div class='ui-datepicker-title'>",
            monthHtml = "";

        // Month selection
        if (secondary || !changeMonth) {
            monthHtml += "<span class='ui-datepicker-month'>" + monthNames[drawMonth] + "</span>";
        } else {
            inMinYear = (minDate && minDate.getFullYear() === drawYear);
            inMaxYear = (maxDate && maxDate.getFullYear() === drawYear);
            monthHtml += "<select class='ui-datepicker-month' data-handler='selectMonth' data-event='change'>";
            for (month = 0; month < 12; month++) {
                if ((!inMinYear || month >= minDate.getMonth()) && (!inMaxYear || month <= maxDate.getMonth())) {
                    monthHtml += "<option value='" + month + "'" +
                        (month === drawMonth ? " selected='selected'" : "") +
                        ">" + monthNamesShort[month] + "</option>";
                }
            }
            monthHtml += "</select>";
        }

        if (!showMonthAfterYear) {
            html += monthHtml + (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "");
        }

        // LittleBoy isBuddhist
        var isBuddhist = this._get(inst, "isBuddhist");

        // Year selection
        if (!inst.yearshtml) {
            inst.yearshtml = "";
            if (secondary || !changeYear) {
                // LittleBoy
                html += "<span class='ui-datepicker-year'>" + (drawYear + (isBuddhist ? 543 : 0)) + "</span>";
            } else {

                // determine range of years to display
                years = this._get(inst, "yearRange").split(":");
                thisYear = new Date().getFullYear();
                determineYear = function (value) {
                    var year = (value.match(/c[+\-].*/) ? drawYear + parseInt(value.substring(1), 10) :
                        (value.match(/[+\-].*/) ? thisYear + parseInt(value, 10) :
                            parseInt(value, 10)));
                    return (isNaN(year) ? thisYear : year);
                };
                year = determineYear(years[0]);
                endYear = Math.max(year, determineYear(years[1] || ""));
                year = (minDate ? Math.max(year, minDate.getFullYear()) : year);
                endYear = (maxDate ? Math.min(endYear, maxDate.getFullYear()) : endYear);
                inst.yearshtml += "<select class='ui-datepicker-year' data-handler='selectYear' data-event='change'>";
                for (; year <= endYear; year++) {
                    // LittleBoy
                    if (isBuddhist) {
                        inst.yearshtml += "<option value='" + year + "'" +
                            (year === drawYear ? " selected='selected'" : "") +
                            ">" + (year + 543) + "</option>";
                    }
                    else {
                        inst.yearshtml += "<option value='" + year + "'" +
                            (year === drawYear ? " selected='selected'" : "") +
                            ">" + year + "</option>";
                    }
                }
                inst.yearshtml += "</select>";

                html += inst.yearshtml;
                inst.yearshtml = null;
            }
        }

        html += this._get(inst, "yearSuffix");
        if (showMonthAfterYear) {
            html += (secondary || !(changeMonth && changeYear) ? "&#xa0;" : "") + monthHtml;
        }
        html += "</div>"; // Close datepicker_header
        return html;
    };

    $.datepicker._getFormatConfig = function (inst) {
        //console.log("Revised LittleBoy _getFormatConfig(inst)", arguments);
        var shortYearCutoff = this._get(inst, "shortYearCutoff");
        shortYearCutoff = (typeof shortYearCutoff !== "string" ? shortYearCutoff :
            new Date().getFullYear() % 100 + parseInt(shortYearCutoff, 10));
        return {
            shortYearCutoff: shortYearCutoff,
            dayNamesShort: this._get(inst, "dayNamesShort"), dayNames: this._get(inst, "dayNames"),
            monthNamesShort: this._get(inst, "monthNamesShort"), monthNames: this._get(inst, "monthNames"),
            isBuddhist: this._get(inst, "isBuddhist")
        };
    };

}));
