(function ($) {
	var url = "permission-pane_process.php";
	var currentRow = null;
	var deleteRowid = [];
	var updateRowid = [];
	jQuery.permission = {
		load: function () {
			$.ajax({
				'url': url,
				'data': { 'action': 'query' },
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () {
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");

				},
				'success': function (data) {
					//remove image loading 
					//$('#loading').html('').append("Project Management Sheet");

					var result = eval('(' + data + ')');
					var role = result.role;
					result = result.level;
					var $table = $('#permission-table tbody');
					$table.find('tr').remove();
					var txt = "";
					var txtlabel = "";
					txtlabel += '<tr class="primary">'+
					'<td style="width:4%;vertical-align:middle" class="text-center" >#</td>'+
					'<td style="width:30%;vertical-align:middle" > Page Permission</td>';
					$.each(role,function(index, value){
						txtlabel += '<td style="width:11%;vertical-align:middle" class="text-center" > Lv. '+value.label+' </td>';
					});
					txtlabel += '</tr>';
					


					for (i = 0; i < result.length; i++) {
						seq = i;
						seq++;
						txt += "<tr id='" + result[i].mid + "'>" +
							"<td style='vertical-align:middle; text-align:center' >&nbsp;" + seq + "&nbsp;</td>" +
							"<td>" + result[i].mname + "</td>";
						$.each(result[i].role, function (index, value) {
							let c_chk = "";
							let c_dis = " disabled='disabled'";
							if (result[i].role[index] == 1) { c_chk = "checked=checked" } else { c_chk = ""; result[i].role[index] = 0; }
							txt += "<td class='text-center' >" +
								"<input  id='" + result[i].appname + "-" + index + "' type='checkbox'  " + c_chk + ((index == 'admin') ? c_dis : "") + "  value='" + result[i].role[index] + "'>" +
								"</td>";
						});
						txt += "</tr>";
					}
					$('#permission-table thead').html(txtlabel);
					$('#permission-table tbody').html(txt);



					if (i == 0) {
						$row = $("<tr id='nodata'><td colspan='6' class='listTableRow small center'>&nbsp;<span class='fa fa-times-circle fa-lg'></span> &nbsp; Data not found &nbsp;</td></tr>")
						$row.appendTo($table);
					} else {
						var $table = $('#dept-table tfoot');
						$table.find('tr').remove();
						var s = "s";
						if (i < 1) { s = ""; }
						$addRow = $("<tr ><td colspan='3'  style='border-top: 1px solid #EAEAEA' ><small> Total " + i + " Record" + s + " </small></td></tr>");
						$addRow.appendTo($table);
					}

				}
			});//end ajax 

		},
		save: function () {

			//    var $table = $('#permission-table tbody'); 

			var d = "{\"data\":[";
			//$('#permission-table tbody tr[status=n]').each( function( index ){
			$('#permission-table tbody tr').each(function (index) {
				//console.log( $(this).attr('id'));
				var xid = $(this).attr('id');
				let length = $(this).find('td').length - 1;
				console.log(length);
				d += "{\"appid\":\"" + $(this).attr('id') + "\",";
				$(this).find('td').each(function (key) {


					var self = $(this), checked = 0;
					if (self.children('[type=checkbox]').is(":checked")) {
						checked = 1;
					} else {
						checked = 0;
					}
					
					if(key>1){
						let role = $(this).find('input').attr('id');
						role = role.split('-');
						d += '"'+role[1]+'":"'+ $.trim(checked) + '"';
						if(key == length) {
							d += "},";
						}else {
							d += ",";
						}
					}


				})//end each td

			})//end each tr

			d = d.substr(0, d.lastIndexOf(","));
			d += "]}";

			$.post(url, { "action": "save", "data": d }, function (result) {
				var response = eval('(' + result + ')');
				if (response.result == "success") {
					$.permission.load();

					$('#stacknotify').stacknotify({ 'message': 'Save success', 'detail': 'Save success' });
				}
			});


		},
		cancel: function () {
			$.permission.load();
		},

	}//end jQuery
})(jQuery)//end function



$(function () {
	$.permission.load();
	$('.save_permission').click(function (e) {
		e.preventDefault();
		$.permission.save();
	});
	$('.cancel_permission').click(function (e) {
		e.preventDefault();
		var confirm = window.confirm("Cancel this action ?");
		if (confirm) {
			$.permission.cancel();
		}
	});


})