<SCRIPT type=text/javascript>
    function verify() {
        if ($('[name=campaign_id]').val() == "") {
            alert("กรุณาเลือก Campaign");
            $("#campaign_id").focus();
            return;
        }
        if ($('[name=campaign_id_lead_list]').val() == "") {
            alert("กรุณาเลือก Campaign");
            $("#campaign_id_lead_list").focus();
            return;
        }
        if ($('[name=startdate]').val() == "") {
            alert("กรุณาใส่วันที่เริ่ม");
            $("#start_date").focus();
            return;
        }
        if ($('[name=enddate]').val() == "") {
            alert("กรุณาใส่วันที่สิ้นสุด");
            $("#end_date").focus();
            return;
        }

        var selectElement = document.getElementById('campaign_id');
        var selectElement2 = document.getElementById('campaign_id_lead_list');
        var selectedOptions = [];
        var selectedOptions2 = [];

        console.log('se1', selectElement);
        console.log('se2', selectElement2);

        for (var i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].selected) {
                selectedOptions.push(selectElement.options[i].value);
            }
        }

        if (selectElement2 && selectElement2.selectedIndex !== -1) {
            // If selectElement2 is selected, store only the selected values in selectedOptions2
            for (var i = 0; i < selectElement2.options.length; i++) {
                if (selectElement2.options[i].selected) {
                    selectedOptions2.push(selectElement2.options[i].value);
                }
            }
        } else {
            // If selectElement2 is not selected at all, store all values in selectedOptions2
            for (var i = 0; i < selectElement2.options.length; i++) {
                var value = selectElement2.options[i].value;
                if (value !== '') {
                    selectedOptions2.push(value);
                }
            }
        }

        console.log('selectedOptions', selectedOptions);
        console.log('selectedOptions2', selectedOptions2);

        document.getElementById('campaign_id_selected').value = selectedOptions.join(', ');
        document.getElementById('campaign_id_selected_lead_list').value = selectedOptions2.join(', ');
        console.log(selectedOptions2)

        var formtojson = JSON.stringify($('form').serializeObject());
        $.post('app/aig/report/Campaign_Performance_Export_ByLead.php', {
            "data": formtojson
        }, function(result) {
            var response = eval('(' + result + ')');
            if (response.result == "success") {
                window.location = "app/aig/report/dw.php?p=temp/" + response.fname + "&o=y";
            }
        });
    }
</SCRIPT>

<!--  Agent Performance Report V1.0 Fri 20 2558  -->
<?php include "dbconn.php" ?>
<?php include "util.php"  ?>
<!-- Agent Permance Report  -->
<div id="report-pane">
    <ul style="width:100%; list-style:none; margin:0;padding:0;">
        <li>
            <div style="width:15%;float:left;">
                &nbsp;
            </div>
            <div style="width:60%;float:left; border-bottom:1px dashed #ddd">
                <div style="position:relative;">
                    <div class="report-back-main" style="float:left; display:inline-block;cursor:pointer; ">
                        <i class="icon-circle-arrow-left icon-3x" style="color:#666; "></i>
                    </div>
                    <div style="display:inline-block; float:left; margin-left:5px;">
                        <h2 style="font-family:raleway; color:#666666; margin:0; padding:0">&nbsp;Campaign Performance Report Lead</h2>
                        <div class="stack-subtitle" style="color:#777777; ">&nbsp; Campaign Performance Lead</div>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
            <div style="width:25%;float:left;">
                &nbsp;
            </div>
            <div style="clear:both"></div>
        </li>
        <li style="padding:5px; margin-top:15px;">
            <div style="width:15%;float:left;">
                &nbsp;
            </div>
            <div style="width:35%;float:left; ">
                <input type="hidden" id="campaign_id_selected" name="campaign_id_selected">
                <span style="font-size:15px; line-height:30px; color:#666; vertical-align: top;">Campaign Name &nbsp;&nbsp;: </span>
                &nbsp;<select style="width:600px; height:200px;" id="campaign_id" name="campaign_id" multiple>
                    <option></option>
                </select>
                <!--  <input type="text" name="search_cust" style="width:250px;" autocomplete="off" placeholder="ระบุชื่อลูกค้า"> -->
            </div>
            <div style="width:35%;float:left; ">
                <input type="hidden" id="campaign_id_selected_lead_list" name="campaign_id_selected_lead_list">
                <span style="font-size:15px; line-height:30px; color:#666; vertical-align: top;">Lead List &nbsp;&nbsp;: </span>
                &nbsp;<select style="width:600px; height:200px;" id="campaign_id_lead_list" name="campaign_id_lead_list" multiple>
                    <option></option>
                </select>
                <!--  <input type="text" name="search_cust" style="width:250px;" autocomplete="off" placeholder="ระบุชื่อลูกค้า"> -->
            </div>
            <div style="width:50%;float:right;">
                <div>&nbsp;</div>
            </div>
            <div style="clear:both"></div>
        </li>
        <li style="padding:5px;">
            <div style="width:15%;float:left;">
                &nbsp;
            </div>
            <div style="width:35%;float:left;color:#666; font-size:16px;">
                <span style="font-size:15px; line-height:30px;width:118px;display:inline-block;"> Start Date </span> :
                <input type="text" name="startdate" style="width:250px; " autocomplete="off" placeholder="เลือกวันที่เริ่มสร้าง app" class="text-center calendar_en">
            </div>
            <div style="width:50%;float:right;">
                <div style="color:#666;">
                    <span style="font-size:15px; line-height:30px;width:100px;display:inline-block;"> End Date</span> :
                    <input type="text" name="enddate" style="width:250px;" autocomplete="off" placeholder="เลือกวันที่สิ้นสุดการสร้าง app" class="text-center calendar_en">
                </div>
            </div>
            <div style="clear:both"></div>
        </li>
        <li style="text-align:center;padding:20px;">
            <div>
                <input type="button" class="btn btn-primary" value="Export" onclick="verify()" style="border-radius:3px; width:110px;">
                <button class="btn btn-default search-campperfmance-btn-clear" style="border-radius:3px; width:110px;"> Clear </button>
            </div>
        </li>
    </ul>

</div>

<!-- end agent performance report -->
<script type="text/javascript" src="js/report_cmp.js"></script>

<script>
    $(function() {

        $('.calendar_en').datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $.rpt.getcmp();
        $("#campaign_id").on("change", function() {
            $.rpt.getleadbycmp();
        });


        //agent report back to main menu
        $('.report-back-main').click(function(e) {
            $('#report').fadeOut('fast', function() {
                $('#select-report').fadeIn('medium');
                $(this).html('');
            });
        });


        $('.search-campperfmance-btn-clear').click(function(e) {
            e.preventDefault();
            //clear search
        });


    })
</script>