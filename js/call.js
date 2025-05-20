(function ($) {
	var url = "call-pane_process.php";
	var popup = {
		list: [],
		current: 0
	};
	var sys_dial = {
		list: [],
		current: 0,
		called: []
	};
	var sys_callback = {
		list: [],
		current: 0,
		called: []
	};
	var sys_follow = {
		list: [],
		current: 0,
		called: []
	};
	var sys_hist = {
		list: [],
		current: 0,
		called: []
	};

	var channelid = "";
	var uniqueid = "";
	var callsts = ""; //variable for check is oncall ( prevent double click make call twice )

	var softphone = null;

	setTimeout(() => {
		function isJson(str) {
			try {
				JSON.parse(str);
			} catch (e) {
				return false;
			}
			return true;
		}
		softphone = document.getElementById("softphone");
		window.addEventListener("message", function (event) {
			let voiceid = "";
			let lastinteract = "";
			if (!isJson(event.data)) { return; }
			let message = JSON.parse(event.data);
			if (message) {
				/*
				console.log('contentWindow');
				var elementsToHide = softphone.getElementById('purecloudHTML');
				console.log('contentWindow*',softphone);
				if(elementsToHide){
				for (var i = 0; i < elementsToHide.length; i++) {
                    elementsToHide[i].style.display = 'none'; // Hide elements by class name
                }
				}*/
				console.log('test9999', message.type, message, event);
				if (message.type == "screenPop") {
					let interact = message.data.interactionId;
					let attributes = (interact.hasOwnProperty('attributes')) ? interact.attributes : "";
					let contactlistid = (interact.hasOwnProperty('dialerContactListId')) ? interact.dialerContactListId : "";
					let contactid = (interact.hasOwnProperty('dialerContactId')) ? interact.dialerContactId : "";
					contactid = (!contactid && attributes && attributes.hasOwnProperty('pt_searchvalue')) ? attributes.pt_searchvalue : contactid;
					$('[name=contactid]').val(contactid);
					$('[name=contactlistid]').val(contactlistid);
					voiceid = message.data.interactionId.id;
					let formtojson = JSON.stringify($('form').serializeObject());
					$.post(url, {
						"action": "geneGetleadfromcontactid",
						"data": formtojson
					}, function (result) {
						let response = eval('(' + result + ')');
						if (response.result == "success") {
							console.log("geneGetleadfromcontactid data:",response);
							let listid = response.data;
							console.log("geneGetleadfromcontactid listid:",listid);
							$.call.voiceid = voiceid;
							$.post(url, {
								"action": "geneCallLog",
								"listid": listid,
								"voiceid": voiceid,
								"agentid": uid,
							});
							localStorage.setItem('voiceid', $.call.voiceid);
							$('[name=listid]').val(listid);
							$('[name=voiceid]').val(voiceid);

							let current_cpid = $('[name=cmpid]').val();
							let new_cpid = response.data2.campaign_id;
							if(current_cpid != new_cpid){
								$('[name=cmpid]').val(new_cpid);
								$.call.cmp_initial(new_cpid).done(()=>{
									$.call.cmp_joinlog(new_cpid, response.data2.campaign_id, response.data2.campaign_id, response.data2.campaign_type, response.data2.genesys_callback_queueid);
								});
							}
							console.log("geneGetleadfromcontactid cpid:",current_cpid,new_cpid);

							$.call.loadpopup_content(listid, "sp", true);

							let campaign_id = $('[name=cmpid]').val();
							let calllist_id = listid;
							let agent_id = $('[name=uid]').val();
							let voice_id = voiceid;
							$.post(url, {
								"action": "addCallTrans",
								"campaign_id": campaign_id,
								"calllist_id": calllist_id,
								"agent_id": agent_id,
								"voice_id": voice_id
							});
							$('[name=currentInteraction]').val(voice_id);
						} else {
							$.call.voiceid = null;
							localStorage.setItem('voiceid', $.call.voiceid);
							$('[name=contactid]').val('');
							$('[name=contactlistid]').val('');
							$('[name=listid]').val('');
							$('[name=voiceid]').val('');
						}
					});
					if (timerAutoWrapup != null){
						clearTimeout(timerAutoWrapup);
					}
				} else if (message.type == "processCallLog") {
					// if(message.data.eventName == "interactionDisconnected"){
					// 	callsts = "";
					// }
					// window.PureCloud.User.updateStatus(message.data);
				} else if (message.type == "interactionSubscription") {
					let lastinter = null;
					if (message.data.interaction.old) {
						lastinter = message.data.interaction.old;
						lastinteract = lastinter.id;
					} else {
						lastinter = message.data.interaction;
						lastinteract = lastinter.id;
					}
					if (message.data.category == "add") {
						voiceid = message.data.interaction.id;
						$.call.voiceid = voiceid;
						localStorage.setItem('voiceid', $.call.voiceid);
						$('[name=voiceid]').val(voiceid);
						let campaign_id = $('[name=cmpid]').val();
						let calllist_id = $('[name=listid]').val();
						let agent_id = $('[name=uid]').val();
						let voice_id = $('[name=voiceid]').val();
						$.post(url, {
							"action": "addCallTrans",
							"campaign_id": campaign_id,
							"calllist_id": calllist_id,
							"agent_id": agent_id,
							"voice_id": voice_id
						});
						$('[name=currentInteraction]').val(voice_id);
					} else if (message.data.category == "disconnect") {
						// voiceid = message.data.interaction.id;
						// $.call.voiceid = voiceid;
						// localStorage.setItem('voiceid', $.call.voiceid);
						// $('[name=voiceid]').val(voiceid);
						$("#time_wait").timer('pause');
						$("#time_talk").timer('pause');
						$("#time_wrap").timer('resume');
						$.call.phoneStatus(lastinter.state);
						//timerAutoWrapup = setTimeout(autoWrapup, 300000);
						console.log("disconnect interaction.id:",message.data.interaction.id);
						$.post(url, {
							"action": "updateCallTrans",
							"voice_id": message.data.interaction.id
						});
					} else if (message.data.category == "connect") {
						voiceid = message.data.interaction.id;
						$.call.voiceid = voiceid;
						localStorage.setItem('voiceid', $.call.voiceid);
						$('[name=voiceid]').val(voiceid);
						$("#time_wait").timer('pause');
						$("#time_talk").timer('resume');
						$.call.phoneStatus(lastinter.state);
						if (timerAutoWrapup != null){
							clearTimeout(timerAutoWrapup);
						}
					} else {
						$.call.phoneStatus(lastinter.state, true);
					}
					$.call.lastInteraction = lastinteract;
					localStorage.setItem('lastInteraction', lastinteract);
					$('[name=lastInteraction]').val(lastinteract);

				} else if (message.type == "notificationSubscription") {
					console.log('test8888', message.data.data.interactionId);
				}
				// if(message.type == "screenPop"){
				// 	document.getElementById("screenPopPayload").value = event.data;
				// } else if(message.type == "processCallLog"){
				// 	document.getElementById("processCallLogPayLoad").value = event.data;
				// } else if(message.type == "openCallLog"){
				// 	document.getElementById("openCallLogPayLoad").value = event.data;
				// } else if(message.type == "interactionSubscription"){
				// 	document.getElementById("interactionSubscriptionPayload").value = event.data;
				// } else if(message.type == "userActionSubscription"){
				// 	document.getElementById("userActionSubscriptionPayload").value = event.data;
				// } else if(message.type == "notificationSubscription"){
				// 	document.getElementById("notificationSubscriptionPayload").value = event.data;
				// } else if(message.type == "contactSearch") {
				// 	document.getElementById("searchText").innerHTML = ": " + message.data.searchString;
				// 	sendContactSearch();
				// }
			}
		});
	}, 2000);

	// Customize By Noom
	jQuery.QueryString = (function (a) {
		if (a == "") return {};
		let b = {};
		for (let i = 0; i < a.length; ++i) {
			let p = a[i].split('=');
			if (p.length != 2) continue;
			b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
		}
		return b;
	})(window.location.search.substr(1).split('&'));

	jQuery.RemoveQueryString = function () {
		let uri = window.location.href.toString();
		if (uri.indexOf("?") > 0) {
			let clean_uri = uri.substring(0, uri.indexOf("?"));
			window.history.replaceState({}, document.title, clean_uri);
		}
	};

	jQuery.call = {
		callFrom: "",
		currentCmp: null,
		columns: {
			newlist: null,
			callback: null,
			history: null
		},
		dtList: {
			newlist: null,
			nocontact: null,
			callback: null,
			follow: null,
			success: null,
			reconfirm: null,
			history: null,
		},
		currentTab: null,
		voiceid: null,
		lastInteraction: null,
		init: function () {
			let formtojson = JSON.stringify($('form').serializeObject());
			$.ajax({
				'url': url,
				'data': {
					'action': 'init',
					'data': formtojson
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () { },
				'success': function (data) {

					let result = eval('(' + data + ')');
					let $table = $('#campaign-table tbody');
					$table.find('tr').remove();
					let seq = 0;
					for (let i = 0; i < result.length; i++) {
						seq++;
						$row = $("<tr id='" + result[i].cmpid + "' data-name='" + result[i].cmpName + "' data-queueid='" + result[i].cmpGeneQueue + "' data-callback-queueid='" + result[i].cmpGeneCallbackQueue + "' data-cmptype='" + result[i].cmpType + "' >" +
							"<td style='border-left:1px solid #E2E2E2; border-bottom:1px solid #E2E2E2; vertical-align:middle; text-align:center;' >" + seq + "</td>" +
							"<td style='border-bottom:1px solid #E2E2E2;'><strong>&nbsp;" + result[i].cmpName + "</strong><br/><span style='color:#777777;'>&nbsp;" + result[i].cmpDetail + "</span></td>" +
							"<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>" + result[i].total + "</td>" +
							"<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>" + result[i].nlist + "</td>" +
							"<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>" + result[i].ncont + "</td>" +
							"<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>" + result[i].clsit + "</td>" +
							"<td class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:22px; font-family:lato; font-weight: 600; '>" + result[i].flist + "</td>" +
							"<td  class='text-center' style='border-bottom:1px solid #E2E2E2;vertical-align:middle;font-size:14px; font-family:lato; font-weight: 600; '>" + result[i].jdate + "</td>" +
							"<td style='border-bottom:1px solid #E2E2E2;border-right:1px solid #E2E2E2;  vertical-align:middle' class='text-center'><button class='btn cmp_selected' style=' color:#fff;background-color:#f0ad4e; border-radius:3px;'> Join campaign </button></td>" +
							"</tr>");
						$row.appendTo($table);
					}

					let camp = "Campaign";
					if (seq > 1) {
						camp = "Campaigns";
					}

					let txt = "<tr><td colspan='9' style='border:1px solid #E2E2E2;  border-top:0; text-align:center;color:#676a6c;'>Total " + seq + " " + camp + " &nbsp;</td></tr>";
					$('#campaign-table tfoot').html(txt);

					//init event
					//add event dblclick to  tr
					//prevent duplicate event move to callcampaign-pane
					/*
									 $('#campaign-table tbody').on('dblclick','tr',function(){
										
											let cmpid = $(this).attr('id');
											let cmpname = $(this).attr('data-name');
											$.call.cmp_initial( cmpid  );
											$.call.cmp_joinlog(cmpid , cmpname );
									 });
									 */

					//add event to button  join campaign
					$('.cmp_selected').off('click').click(function (e) {
						e.preventDefault();
						let tr = $(this).parent().parent();
						let cmpid = tr.attr('id');
						let cmpname = tr.attr('data-name');
						let queueid = (tr.attr('data-queueid')) ? tr.attr('data-queueid') : "";
						let queuecallbackid = (tr.attr('data-callback-queueid')) ? tr.attr('data-callback-queueid') : "";
						let cmptype = (tr.attr('data-cmptype')) ? tr.attr('data-cmptype') : "";
						$.call.cmp_initial(cmpid).done(()=>{
							$.call.cmp_joinlog(cmpid, cmpname, queueid, cmptype, queuecallbackid);
						});
					}) //end campaign click ( select campaign )

				} //end success
			}) //end ajax			 

		},
		cmp_joinlog: function (cmpid, cmpname, queueid, cmptype, queuecallbackid) {
			if (queueid === undefined) {
				queueid = "";
			}
			if (cmptype === undefined) {
				cmptype = "normal";
			}
			//log agent join campaign
			let formtojson = JSON.stringify($('form').serializeObject());
			$.post(url, {
				"action": "cmp_joinlog",
				"cmpid": cmpid,
				"data": formtojson
			}, function (result) {

				let response = eval('(' + result + ')');
				if (response.result == "success") {

					//console.log( cmpid +"|"+ cmpname ); 
					// set selected campaign
					$('[name=cmpid]').val(cmpid);
					$('[name=queueid]').val(queueid);
					$('[name=queuecallbackid]').val(queuecallbackid);
					$('[name=cmptype]').val(cmptype);

					//animate select campaign
					$('#smartpanel').slideUp('slow', function () {
						$('#smartpanel-detail').text(cmpname);
						$('#smartpanel').slideDown('slow');
					});

					let uid = $('[name=uid]').val();
					//keep to cookie for next incoming
					$.cookie("cur-cmp", cmpid + "|" + cmpname + "|" + uid + "|" + queueid + "|" + cmptype, {
						path: "/;SameSite=None",
						secure: true,
						expires: 10
					});
					//hide campaign select table
					$('#callcampaign-pane').hide();
					//load callwork pane
					$('#callwork-pane').load('callwork-pane.php', function () {
						$(this).fadeIn('slow');
						//load call list agent
						$.call.load_newlist(cmpid);
						//start monitor
						$('#callwork-mon').fadeIn(1000);
					});


				}

			});

		},
		cmp_initial: function (cmpid) {
			//log join campaign
			let formtojson = JSON.stringify($('form').serializeObject());
			return $.ajax({
				'url': url,
				'data': {
					"action": "cmp_initial",
					"cmpid": cmpid,
					"data": formtojson
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () { },
				'success': function (data) {

					let result = eval('(' + data + ')');
					let left_col = ["first_name", "last_name"];
					//campaign setup both popup-page and callwork-page
					$.call.currentCmp = {
						"cmpid": cmpid,
						"cmpname": result.cmp.cmpName,
						"queueid": result.cmp.geneQueueid,
						"cmptype": result.cmp.cmpType,
						"callbackqueueid": result.cmp.geneCallbackQueueid,
					};
					//initial campaign profile
					//campaign info
					$('#show-cmp').text('').text(result.cmp.cmpName);
					$('#show-cmp-dtl').text('').text(result.cmp.cmpDetail);

					$("#extweb").attr('href', result.cmp.exturl).text('app name');
					$("[name=salescript]").val(result.cmp.saleScript);
					$('[name=cmpisMultiProduct]').val(result.cmp.cmpisMultiProduct);
					$('[name=cmpCode]').val(result.cmp.cmpCode);
					$('[name=cmpisMultiProduct_udf_field]').val(result.cmp.cmpisMultiProduct_udf_field);

					//campaign profile ( popup profile pane )
					txt = "";
					for (let i = 0; i < result.pfield.length; i++) {
						txt = txt + "<tr><td style='vertical-align:top;text-align:right;color:#676a6c;text-wrap-mode: nowrap;'>&nbsp;" + result.pfield[i].cn + " : </td>" +
							"<td style='vertical-align:middle;'><textarea name='" + result.pfield[i].fn + "' cols='40'></textarea></td><tr/>";
					}
					$('#cmpprofile-table tbody').text('').append(txt);

					//load call summary to dashboard
					$.call.load_dashboard(cmpid);
					$.call.columns = {
						newlist: null,
						callback: null,
						history: null
					};
					$.call.dtList = {
						newlist: null,
						nocontact: null,
						callback: null,
						follow: null,
						success: null,
						history: null
					};
					let column_temp = result.cfield;
					let left_column = column_temp.map((value, key) => {
						if (left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });
					let center_column = column_temp.map((value, key) => {
						if (!left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });
					$.call.columns.newlist = { all: column_temp, left: left_column, center: center_column };
					column_temp = result.cfield2;
					left_column = column_temp.map((value, key) => {
						if (left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });
					center_column = column_temp.map((value, key) => {
						if (!left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });

					$.call.columns.callback = { all: column_temp, left: left_column, center: center_column };
					column_temp = result.cfield3;
					left_column = column_temp.map((value, key) => {
						if (left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });
					center_column = column_temp.map((value, key) => {
						if (!left_col.includes(value.dataC)) {
							return key;
						} else {
							return false;
						}
					}).filter((val) => { return (val === false) ? false : true; });

					$.call.columns.history = { all: column_temp, left: left_column, center: center_column };
					//setup dynamic header for this campaign




				} //end success
			}) //end ajax


		},
		load_dashboard: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			$.ajax({
				'url': url,
				'data': {
					'action': 'query_dashboard',
					'cmpid': cmpid,
					'data': formtojson
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () { },
				'success': function (data) {
					let result = eval('(' + data + ')');
					$('#total_diallist').text(result.tnewlist);
					$('#total_nocontact').text(result.tnocont);
					$('#total_callback').text(result.tcallback);
					$('#total_followup').text(result.tfollowup);

				}
			})

		},
		load_newlist: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.newlist) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.newlist.all;
					let left_column = $.call.columns.newlist.left;
					let center_column = $.call.columns.newlist.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column.title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#calllist-table").empty().html(txt);
					$.call.dtList.newlist = $('#calllist-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_newlist',
								'data': formtojson,
							}
						},
						columns: column,
						order: [[0, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.newlist.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.newlist.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
						$.call.queryMultiProductCampaignName()
					});
				} else {
					$.call.dtList.newlist.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.newlist;

			// }, 100);
		},
		load_nocontact: function () {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.nocontact) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.callback.all;
					let left_column = $.call.columns.callback.left;
					let center_column = $.call.columns.callback.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#nocontact-table").empty().html(txt);
					$.call.dtList.nocontact = $('#nocontact-table').DataTable({
						stripeClasses: ['odd', 'even'],
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_nocontact',
								'tabindex': 2,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.nocontact.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.nocontact.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
					});
				} else {
					$.call.dtList.nocontact.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.nocontact;
			// }, 100);
		},
		load_callback: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.callback) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.callback.all;
					let left_column = $.call.columns.callback.left;
					let center_column = $.call.columns.callback.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#callback-table").empty().html(txt);
					$.call.dtList.callback = $('#callback-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_callback',
								'tabindex': 3,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.callback.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.callback.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
					});
				} else {
					$.call.dtList.callback.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.callback;

			// }, 100);

		},


		load_followup: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.follow) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.callback.all;
					let left_column = $.call.columns.callback.left;
					let center_column = $.call.columns.callback.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#followup-table").empty().html(txt);
					$.call.dtList.follow = $('#followup-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_followup',
								'tabindex': 4,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.follow.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.follow.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
					});
				} else {
					$.call.dtList.follow.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.follow;

			// }, 100);

		},
		load_success: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.success) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.callback.all;
					let left_column = $.call.columns.callback.left;
					let center_column = $.call.columns.callback.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#success-table").empty().html(txt);
					$.call.dtList.success = $('#success-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_followup',
								'tabindex': 5,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.success.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.success.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
					});
				} else {
					$.call.dtList.success.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.success;

			// }, 100);

		},
		load_reconfirm: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			// setTimeout(() => {
				if (!$.call.dtList.reconfirm) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.callback.all;
					let left_column = $.call.columns.callback.left;
					let center_column = $.call.columns.callback.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#reconfirm-table").empty().html(txt);
					$.call.dtList.reconfirm = $('#reconfirm-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_reconfirm',
								'tabindex': 5,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
					$.call.dtList.reconfirm.on('dblclick', 'tbody tr', function () {
						let data = $.call.dtList.reconfirm.row(this).data();
						if(!data) return;
						let listid = data[0];
						$('[name=listid]').val(listid);
						$.call.loadpopup_content(listid);
					});
				} else {
					$.call.dtList.reconfirm.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.reconfirm;

			// }, 100);

		},
		load_callhistory: function (cmpid) {
			let formtojson = JSON.stringify($('form').serializeObject());
			let agentlv = (pfile && pfile['lv']) ? parseInt(pfile['lv']) : 0;
			// setTimeout(() => {
				if (!$.call.dtList.history) {
					let txt = "<thead><tr class='primary'>";
					let column = $.call.columns.history.all;
					column.filter(obj => obj.dataC == "voice_id").forEach(obj => {
						if (agentlv >= 1) {
							obj.visible = false;
						} else {
							obj.render = (data, type, row, meta) => {
								if (type === 'display' && data) {
									data = "<a href='https://apps.mypurecloud.jp/directory/#/engage/admin/interactions/" + data + "' target='_blank'><strong>" + data + "</strong>";
								} else {
									data = '';
								}
								return data;
							}
						}
					});
					column.filter(obj => obj.dataC == "create_date").forEach(obj => {
						obj.render = function (data, type, row, meta) {
							if (type === 'display' && data) {
								// ใช้ JavaScript แปลงเป็น +08:00
								let date = new Date(data);
								// ปรับ offset +8 ชั่วโมง (ถ้า date เป็น UTC)
								date.setHours(date.getHours() + 8);
					
								// แสดงผลแบบ YYYY-MM-DD HH:mm:ss
								let yyyy = date.getFullYear();
								let mm = String(date.getMonth() + 1).padStart(2, '0');
								let dd = String(date.getDate()).padStart(2, '0');
								let hh = String(date.getHours()).padStart(2, '0');
								let mi = String(date.getMinutes()).padStart(2, '0');
								let ss = String(date.getSeconds()).padStart(2, '0');
					
								return `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`;
							}
							return data;
						}
					});
					/*
					column.filter(obj => obj.dataC == "status").forEach(obj => {
						if (agentlv <= 1) {
							obj.visible = false;
						} else {
							obj.render = (data, type, row, meta) => {
								if (data == 0) {
									data = '<button type="button" class="btn btn-success" onclick="activeList(' + row[0] + ')">Active</button>';
								} else {
									data = 'Active';
								}
								return data;
							}
						}
					});
					*/
					let left_column = $.call.columns.history.left;
					let center_column = $.call.columns.history.center;
					for (let i = 0; i < column.length; i++) {
						txt = txt + "<th>" + column[i].title + "</th>";
					}
					txt = txt + "</tr></thead>";
					$("#callhistory-table").empty().html(txt);
					$.call.dtList.history = $('#callhistory-table').DataTable({
						dom: 'lBfrtip',
						responsive: true,
						buttons: [
							{
								text: 'Clear',
								action: function (e, dt, node, config) {
									dt.search('').draw();
								}
							}
						],
						stripeClasses: ['odd', 'even'],
						columnDefs: [
							{ className: "dt-head-center", targets: '_all' },
							{ className: "dt-body-center", targets: center_column },
							{ className: "dt-body-left", targets: left_column }
						],
						search: {
							"return": true
						},
						pageLength: 50,
						ajax: {
							'type': 'POST',
							'url': url,
							'data': {
								'action': 'query_callhistory',
								'tabindex': 99,
								'data': formtojson,
							}
						},
						columns: column,
						order: [[column.length - 1, 'desc']],
						processing: true,
						serverSide: true
					});
				// 	$.call.dtList.history.on('dblclick', 'tbody tr', function () {
				// 		let data = $.call.dtList.history.row(this).data();
				// 		let listid = data[0];
				// 		$('[name=listid]').val(listid);
				// 		$.call.loadpopup_content(listid);
				// 	});
				} else {
					$.call.dtList.history.ajax.reload();
				}
				$.call.currentTab = $.call.dtList.history;
			// }, 100);

		},
		gridSet: function ($row) {

			$row
				.hover(function () {
					$row.addClass('row-hover');
				}, function () {
					$row.removeClass('row-hover');
				})
				.click(function () {

					//  $('[name=lid]').val( $row.attr('id') );	
					$('#calllist-table tr.selected-row').removeClass('selected-row');
					$row.addClass('selected-row');

				})
				.dblclick(function (e) {


					$('.nav-call-id').trigger('click');
					//$.callList.detail( $row.attr('id') );

					//$('#calllist-main-pane').hide();
					//$('#calllist-detail-pane').show();				 

				})

		},
		cmplogoff: function () {


			//animate select campaign
			$('#smartpanel').slideUp('slow', function () {
				$('#smartpanel-detail').html('<i class="icon-fire"></i><span style="font-family:roboto; font-size:18px; font-weight:300; margin:5px;">ICX </span>');
				$('#smartpanel').slideDown('slow');
			});

			$('#page-subtitle').text('Call Work');


			$('#callcampaign-pane').load('callcampaign-pane.php', function () {
				$(this).fadeIn('slow');
			});

			$('#callwork-pane').hide();
			//delete to cookie
			$.removeCookie('cur-cmp', {
				path: '/'
			});

			$.call.currentCmp = null;


		},
		initWrapup: function () {

			let formtojson = JSON.stringify($('form').serializeObject());
			$.ajax({
				'url': url,
				'data': {
					'action': 'initwrapup',
					'data': formtojson
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () {
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				},
				'success': function (data) {


					let result = eval('(' + data + ')');


					//   let txt =  "<li id=''><a href='#'>&nbsp;</a></li>";
					//   for( i=0 ; i<result.length ; i++){
					// 	   txt = txt+"<li id='"+result[i].wcode+"'><a href='#'>"+result[i].wdtl+"</a></li>";
					// 	   <input name="" type="radio" value="" class="radio_prod" />
					//   }
					let txt = "";
					for (let i = 0; i < result.length; i++) {
						txt = txt + '<li><input name="wrapup1" type="radio" value="' + result[i].wcode + '" />&nbsp;<label for="level1">' + result[i].wdtl + '</label></li>';
					}
					$('#wrapup1').html(txt);
					$('#wrapup2').html('');
					$('#wrapup3').html('');

					$('input[type=radio][name=wrapup1]').on("change", function (e) {
						e.preventDefault();
						e.stopPropagation();
						let id = $('input[type=radio][name=wrapup1]:checked').val();
						if (id) {
							$.call.n_queryWrapup(2, id);
						}
					});


					//   $('#wrapup1 > li').off('click').click( function(e){
					// 	 e.preventDefault();
					// 	 e.stopPropagation();

					// 	 $('#wrapup2').prev().html('&nbsp;');
					// 	 $('#wrapup3').prev().html('&nbsp;');

					// 	  let self = $(this);
					// 	  $('.wrapper-dropdown-5').removeClass('active');


					// 		self.closest('ul').parent().removeClass('active');
					// 		self.closest('ul').prev().text( $(this).text()   );

					//   	  //set to hidden value
					// 	    $('[name=wrapup1]').val(self.attr('id'));
					// 		$('[name=wrapup2]').val('');
					// 		$('[name=wrapup3]').val('');
					// 	    if( self.attr('id') != "" ){
					// 	    	$.call.queryWrapup(2,self.attr('id'));
					// 	    }


					//   });

					/*
								 let opt = "<option value=''></option>";
									   for( i=0 ; i<result.length ; i++){
											opt = opt + "<option value='"+result[i].wcode+"'>"+result[i].wdtl+"</option>";
									   }
							    
									$('[name=wrapup1]').html( opt );
								 
									//wrapup change
									$('[name=wrapup1]').change( function(){
										   $('[name=wrapup2]').html("");
										   $('[name=wrapup3]').html("");
										   let val = $(this).val();
											$.call.queryWrapup(2,val )
									});
									  */
				} //end success

			}) //end ajax

		},
		n_queryWrapup: function (lv, wrapupcode) {

			$.ajax({
				'url': url,
				'data': {
					'action': 'querywrapup',
					'wrapupcode': wrapupcode
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () {
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				},
				'success': function (data) {


					let result = eval('(' + data + ')');
					let txt = "";
					for (let i = 0; i < result.length; i++) {
						txt = txt + '<li><input name="wrapup' + lv + '" type="radio" value="' + result[i].wcode + '" />&nbsp;<label for="level1">' + result[i].wdtl + '</label></li>';
					}

					if (lv === 2) {
						$('#wrapup2').html(txt);
						$('#wrapup3').html('');
						if (txt) {
							$('#step-wrapup').steps().data('plugin_Steps').next();
						}

						$('input[type=radio][name=wrapup' + lv + ']').on("change", function (e) {
							e.preventDefault();
							e.stopPropagation();
							let id = $('input[type=radio][name=wrapup' + lv + ']:checked').val();
							if (id) {
								$.call.n_queryWrapup(3, id);
							}
						});

						//set wrapup lv2 action
						// $('#wrapup2 > li').off('click').click( function(e){
						// 			e.preventDefault();
						// 			e.stopPropagation();
						// 			//clear lv3
						// 		$('#wrapup3').prev().html('&nbsp;');
						// 			let self = $(this);
						// 			$('.wrapper-dropdown-5').removeClass('active');

						// 			self.closest('ul').parent().removeClass('active');
						// 			self.closest('ul').prev().text( $(this).text());

						// 			//set to hidden value
						// 			$('[name=wrapup2]').val(self.attr('id'));
						// 		$('[name=wrapup3]').val('');
						// 			if( self.attr('id') != "" ){
						// 				$.call.queryWrapup(3,self.attr('id'));
						// 			}
						// });//end function click
					} //end if lv==2

					if (lv === 3) {
						$('#wrapup3').html(txt);
						if (txt) {
							$('#step-wrapup').steps().data('plugin_Steps').next();
						}
						//set wrapup lv3 data
						// $('#wrapup3').html(txt);
						// //set wrapup lv2 action
						// $('#wrapup3 > li').off('click').click( function(e){
						// 			e.preventDefault();
						// 			e.stopPropagation();
						// 			let self = $(this);
						// 			$('.wrapper-dropdown-5').removeClass('active');
						// 			self.closest('ul').parent().removeClass('active');
						// 			self.closest('ul').prev().text( $(this).text());

						// 			//set to hidden value
						// 			$('[name=wrapup3]').val(self.attr('id'))

						// });//end function click

					} //end if lv3

				} //end success
			}) //end ajax


		},
		queryWrapup: function (lv, wrapupcode) {

			$.ajax({
				'url': url,
				'data': {
					'action': 'querywrapup',
					'wrapupcode': wrapupcode
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () {
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				},
				'success': function (data) {


					let result = eval('(' + data + ')');


					let txt = "<li id=''><a href='#'>&nbsp;</a></li>";
					for (let i = 0; i < result.length; i++) {
						txt = txt + "<li id='" + result[i].wcode + "'><a href='#'>" + result[i].wdtl + "</a></li>";
					}

					if (lv === 2) {

						$('#wrapup2').html(txt);
						$('#wrapup3').prev().html('&nbsp;');

						//set wrapup lv2 action
						$('#wrapup2 > li').off('click').click(function (e) {
							e.preventDefault();
							e.stopPropagation();
							//clear lv3
							$('#wrapup3').prev().html('&nbsp;');
							let self = $(this);
							$('.wrapper-dropdown-5').removeClass('active');

							self.closest('ul').parent().removeClass('active');
							self.closest('ul').prev().text($(this).text());

							//set to hidden value
							$('[name=wrapup2]').val(self.attr('id'));
							$('[name=wrapup3]').val('');
							if (self.attr('id') != "") {
								$.call.queryWrapup(3, self.attr('id'));
							}
						}); //end function click
					} //end if lv==2

					if (lv === 3) {
						//set wrapup lv3 data
						$('#wrapup3').html(txt);
						//set wrapup lv2 action
						$('#wrapup3 > li').off('click').click(function (e) {
							e.preventDefault();
							e.stopPropagation();
							let self = $(this);
							$('.wrapper-dropdown-5').removeClass('active');
							self.closest('ul').parent().removeClass('active');
							self.closest('ul').prev().text($(this).text());

							//set to hidden value
							$('[name=wrapup3]').val(self.attr('id'))

						}); //end function click

					} //end if lv3

				} //end success
			}) //end ajax


		},
		saveWrapup: function () {
			// console.log("save wrapup");
			let self = this;
			//check is wrapup is empty 
			let wrapcheck = true;
			if ($('#wrapup1 > li').length > 0 && $('input[type=radio][name=wrapup1]:checked').val() == undefined) {
				wrapcheck = false;
			} else if ($('#wrapup2 > li').length > 0 && $('input[type=radio][name=wrapup2]:checked').val() == undefined) {
				wrapcheck = false;
			} else if ($('#wrapup3 > li').length > 0 && $('input[type=radio][name=wrapup3]:checked').val() == undefined) {
				wrapcheck = false;
			}
			if (!wrapcheck) {
				$('#wrapup-require').fadeOut('fast', function () {
					$(this).fadeIn('slow');
				})
				return;
			} else {
				$('#wrapup-require').fadeOut('fast');
			}

			$('#hangup').trigger('click');

			let impid = $('#cmpprofile-table thead > tr').attr('data-lead');

			let formtojson = JSON.stringify($('form').serializeObject());

			setTimeout(() => {
				$.post(url, {
					"action": "savewrapup",
					"data": formtojson,
					"uniq": uniqueid,
					"impid": impid
				}, function (result) {
					let response = eval('(' + result + ')');
					if (response.result == "success") {


						//remember last called id 
						// let sys = $('#page-subtitle').attr('data-page');
						// let currentrow = 0;	 
						// let totalrow = 0

						/*
						if( sys=="diallist"){
								sys_dial.called.push( sys_dial.list[sys_dial.current-1] )
								currentrow = sys_dial.current;
								totalrow =  sys_dial.list.length;
								
						}else if( sys=="callback"){ 
								sys_callback.called.push( sys_callback.list[sys_callback.current-1])
								currentrow = sys_callback.current;
								totalrow =  sys_callback.list.length;
								
						}else if(sys=="followup"){
								sys_follow.called.push( sys_follow.list[sys_follow.current-1])
								currentrow = sys_follow.current;
								totalrow =  sys_follow.list.length;
								
						}else if(sys=="callhistory"){
								sys_hist.called.push( sys_hist.list[sys_hist.current-1])
								currentrow = sys_hist.current;
								totalrow =  sys_hist.list.length;
						}
						*/
						//show link to reminder
						//  $('#reminder-link').fadeIn('slow');

						//show wrapup save msg & set attr data-status to saved ( for check with hangup )
						/*
							$('#wrapup-msg').fadeOut('fast' , function(){
							$(this).fadeIn('slow');
							}).attr('data-status','saved')
							
							
							
							
							//display phone status on header
							//check if agent is on call do nothing 
							if( $('#makecall').attr('data-status') != "active" ){
							// console.log("make call not active");
								$('#phone-status').fadeOut('slow', function(){ 
									$(this).text('Wrapup saved...') 
										$(this).fadeIn('fast');
								});						    		 
								
								//show left right call list ( delay 3 sec )
								setTimeout(function(){
									//visible left right arrow 
									
								//  if( currentrow == 1  ){
								//		$('#turn-left').css('visibility','hidden'); 
								//  }else{
								//	   $('#turn-left').css('visibility','visible'); 
								//  }
								// if( currentrow >= totalrow  ){
								//		$('#turn-right').css('visibility','hidden'); 
								//  }else{
								//	   $('#turn-right').css('visibility','visible'); 
								//  }
								
									//show close button
									$('#popup-close').css('visibility','visible');
								
							}, 300);
								
								
							}else{
								//animate show wrapup saved and return to on call
								let msg = $('#phone-status').text();
								$('#phone-status').fadeOut('slow', function(){ 
									$(this).text('Wrapup saved...') 
										$(this).fadeIn('slow', function(){
											
												$('#phone-status').fadeOut('slow', function(){ 
													$(this).text( msg );
													$(this).fadeIn('fast');
												});
												
										});
								});
								
							}
							*/

						//clear time
						$("#time_wait").timer('reset').timer('resume');
						$("#time_talk").timer('reset').timer('pause');
						$("#time_wrap").timer('reset').timer('pause');

						//animate show wrapup saved and return to on call
						let msg = $('#phone-status').text();
						$('#phone-status').fadeOut('slow', function () {
							$(this).text('Wrapup saved...')
							$(this).fadeIn('slow', function () {

								$('#phone-status').fadeOut('slow', function () {
									$(this).text(msg);
									$(this).fadeIn('fast');
								});

							});
						});

						//reload mainpage before close
						if($.call.currentTab) $.call.currentTab.ajax.reload();
						localStorage.removeItem('voiceid');
						localStorage.removeItem('lastInteraction');
						$.call.voiceid = null;
						$.call.lastInteraction = null;
						$('[name=lastInteraction]').val('');
						$('[name=voiceid]').val('');

						$('#makecall').show();
						$('#hangup').hide();

						$.call.load_dashboard($('[name=cmpid]').val());
						

						//show close button
						$('#popup-close').css('visibility', 'visible');
						$('#popup-close').trigger('click');

						//set wrapup id for update
						//$('[name=wrapupid]').val()


						// $.call.load( $('[name=cmpid]').val() );
						//    console.log("test8855",self.currentTab);





					}
				});
			}, 100);
		},
		clearWrapup: function () {
			//clear hidden value
			$('[name=wrapup1],[name=wrapup2],[name=wrapup3]').prop('checked', false);
			$('#step-wrapup').steps().data('plugin_Steps').setStepIndex(0);
			// $('#wrapup1').html('');
			$('#wrapup2').html('');
			$('#wrapup3').html('');
			$('[name=wrapupdtl]').val("");
			$('[name=callbackNumbers]').val("");
			$('[name=schedule_time]').val("");

			//clear global parameter 
			channelid = "";
			uniqueid = "";
			callsts = "";

		},
		loadpopup_content: function (listid, callFrom, predict) {
			predict = predict || false;
			callFrom = callFrom || "cc";
			$.call.clearWrapup();
			if (listid == "") {
				alert("calllist id is empty ");
				return;
			}
			this.callFrom = callFrom;


			/*
			  if( $('[name=listid]').val() == "" ){
				  console.log( "calllist id is empty ");
				  alert( "calllist id is empty ");
				  return;
			  }
			  */

			/*
			console.log("check call popup from system ?");
			console.log("check current length popup list "+popup.list.length );
			console.log("check all popup length ")
			*/

			// console.log( "calllist id : "+ $('[name=listid]').val() );
			let formtojson = JSON.stringify($('form').serializeObject());
			$.ajax({
				'url': url,
				'data': {
					'action': 'loadpopup_content',
					'data': formtojson,
					'listid': listid
				},
				'dataType': 'html',
				'type': 'POST',
				'beforeSend': function () {
					//set image loading for waiting request
					//$('#loading').html('').append("<img src='image/ajax-loading.gif'/>");
				},
				'success': function (data) {

					//clear current popup
					//check this is called list

					let result = eval('(' + data + ')');

					//openphone
					$('.softphone').tabSlideOut('open');

					//call script url
					$('#open-callscriptfull').attr('data-script', result.script);


					//call external app
					if (result.exapp.length != undefined) {
						let confirm_id = result.confirm_id.split(",");
						let callid = $('[name=listid]').val();
						let cmpid = $('[name=cmpid]').val();
						let appid = "";
						let cmpisMultiProduct = $('[name=cmpisMultiProduct]').val();
						let cmpisMultiProduct_udf_field = $('[name=cmpisMultiProduct_udf_field]').val();
						let cmpCode = $('[name=cmpCode]').val();
						console.log(" cmpisMultiProduct:", cmpisMultiProduct)
						console.log(" cmpisMultiProduct_udf_field:", cmpisMultiProduct_udf_field)
						console.log(" cmpCode:", cmpCode)
						if (confirm_id.length == 3) {
							cmpid = confirm_id[0];
							appid = confirm_id[1];
							callid = confirm_id[2];
						}
						let ul = $('#campaign-exapp');
						let aid = $('[name=uid]').val();
						let imid = result.impid.id;
						let txt = "";

						result.exapp.forEach((app) => {
								let listItem = `<li style="width:100px; text-align:center; border-radius:8px; color:#666; cursor:pointer; padding:2px 5px; margin:2px;">`;
				
								if (app.appn === "Application" &&cmpisMultiProduct==="1") {
										listItem += `<a href="#" class="popup-trigger" data-cmpid="${cmpid}" data-callid="${callid}" data-aid="${aid}" data-imid="${imid}">`;
								} else if (appid) {
										listItem += `<a href="${app.appu}?id=${appid}" style="text-decoration:none;" target="_blank">`;
								} else {
										listItem += `<a href="${app.appu}?campaign_id=${cmpid}&calllist_id=${callid}&agent_id=${aid}&import_id=${imid}&formType=ah" target="_blank">`;
								}
				
								listItem += `<span class="${app.appi}" style="font-size:26px; color:#666;"></span>
														<span style="font-size:12px; display:block; color:#666;"> ${app.appn}</span>
														</a></li>`;
				
								txt += listItem;
						});
						ul.html(txt)

					}


					//show list name for this calllist
					/*
					let $thead = $('#cmpprofile-table thead');
					$thead.find('tr').remove();
					$thead.append('<tr data-lead="'+result.imp.impid+'"><td colspan="2" style="text-align:right; font-size:12px; color:#999; font-style:italic;"> Lead Source : '+result.imp.impname+'</td></tr>');
					*/

					//enable makecall
					if (predict) {
						$('#makecall').hide();
						$('#hangup').show();
					} else {
						$('#makecall').show();
						$('#hangup').hide();
					}
					$('#transfer').prop("disabled", false);


					//phone popup
					let cp = $('#calllistphone');
					cp.find('li').remove();
					let def = true; //set first number to default value 
					let size = result.calllist.length;
					for (let i = 0; i < size; i++) {

						let tmp = result.calllist[i].key.split("|");

						// console.log( tmp[0]  );

						//  console.log( tmp[0] );
						// console.log( result[i].value );
						if (tmp[0] == "phone") {
							let val = result.calllist[i].value;
							let temp_val = val;

							if (tmp[2] != "" && val != "") {
								//val = tmp[2];

								val = mask(result.calllist[i].value, tmp[2]);
							}

							//setup value to campaign
							$('[name=' + tmp[1] + ']').val(val);

							//console.log( i+"|"+tmp[1]);
							//set popup phone
							if ($('[name=callbackNumbers]').val() == "") {
								$('[name=callbackNumbers]').val(temp_val);
							}
							if (def) {
								def = false;
								cp.append("<li  style='cursor:pointer' data-id='" + temp_val + "' class='active-number' >" + val + "</li>");
							} else {
								cp.append("<li  style='cursor:pointer' data-id='" + temp_val + "' >" + val + "</li>");
							}

						} else
							if (tmp[0] == "status") {

								if (tmp[0] == "status" && result.calllist[i].value == "3") {
									$('#calllistmsg').text('').text('Do NOT Call list');
								} else {
									$('#calllistmsg').text('');
								}

							} else {

								$('[name=' + tmp[1] + ']').val(result.calllist[i].value)

							}


						//	opt = opt + "<option value='"+result[i].wcode+"'>"+result[i].wdtl+"</option>";
					} //end loop for

					/*
					  $('#lastwrapup_dt').text('').text('This call list last recently wrapup on '+result.wrapuphist.lastwrapupdt);
					  $('#lastreminderdt').text('').text('!! Reminder call back on '+result.wrapuphist.lastreminderdt);
					  */

					//show recently call & reminder on sub top of header
					//console.log(result.wrapuphist.result );
					if (result.wrapuphist.result != undefined) {
						$('#lastwrapup_dt').text('');
					} else {
						$('#popup-recently-calls').show();
						$('#lastwrapup_dt').text('').html('This call list last recently wrapup on <span style="color:#999"> ' + result.wrapuphist.lastwrapupdt_th + ' </span><span style="color:#999; font-style: italic;"> - ' + $.timeago(result.wrapuphist.lastwrapupdt) + '</span>');
					}

					$('#lastreminder_dt').text('').html('This call list set reminder on ' + result.wrapuphist.lastreminderdt_th + ' <span style="color:#999; font-style: italic;">' + $.timeago('2014-10-29 18:08:18') + '</span>');


					//popup call  history 
					let $table = $('#popup_history-table tbody');
					$table.find('tr').remove();
					size = result.listhist.length;
					let seq = 0;
					let i;
					for (i = 0; i < size; i++) {
						seq++;
						$row = $("<tr id='" + result.listhist[i].cid + "'><td style='vertical-align:middle; text-align:right' >" + seq + "</td>" +
							"<td class='text-center' style='font-size:12px;'>" + result.listhist[i].cred + "</td>" +
							/*
																				   "<td class='text-center' style='font-size:12px;'>"+result.listhist[i].disp+"</td>"+

																				   "<td class='text-center' style='font-size:12px;'>"+result.listhist[i].bill+"</td>"+
							*/
							"<td  style='font-size:12px;'>" + result.listhist[i].wup + "</td>" +
							"<td  style='font-size:12px;'>" + result.listhist[i].note + "</td></tr>");
						$row.appendTo($table);

					}

					if (i == 0) {
						$row = $("<tr id='nodata'><td colspan='6' class='text-center'>&nbsp; No Call History Record &nbsp;</td></tr>")
						$row.appendTo($table);
					} else {
						$table = $('#popup_history-table tfoot');
						$table.find('tr').remove();
						let s = "s";
						if (i < 1) {
							s = "";
						}
						$addRow = $("<tr ><td colspan='6'  style='border-top: 1px solid #EAEAEA' ><small> Total <span style='color:blue'>" + i + "</span> record" + s + " </small></td></tr>");
						$addRow.appendTo($table);

						$('#call-history_popup_total_calls').text(i)

						//highlight row table when click     
						$('#callhistory-table tbody').on('click', 'tr', function () {
							$('#callhistory-table tr.selected-row').removeClass('selected-row')
							$(this).addClass('selected-row');
						});

					}
					//end popup call  history


					//add event action to list phone number 
					$('#calllistphone li').off('click').off('dblclick').on('click', function () {
						$('#calllistphone li.active-number').removeClass('active-number');
						$(this).addClass('active-number');

					}).on('dblclick', function () {
						$('#makecall').trigger('click');
					})

					//typeOfVoucher
					var option = "<option value=''> &nbsp; </option>";
					for( i=0 ; i<result.typeOfVoucher.length ; i++){
					 	option += "<option value='"+ result.typeOfVoucher[i].id +"'>"+ result.typeOfVoucher[i].value +"</option>";									    										    
					}								
					$('[name=typeOfVoucher]').text('').append(option);

					//typeOfVoucher
					var option = "<option value=''> &nbsp; </option>";
					for( i=0 ; i<result.voucherValue.length ; i++){
					 	option += "<option value='"+ result.voucherValue[i].id +"'>"+ result.voucherValue[i].value +"</option>";									    										    
					}								
					$('[name=voucherValue]').text('').append(option);

					//calllist_data
					$('[name="Dont_call_ind"]').prop('checked', false);
					$('[name="Dont_SMS_ind"]').prop('checked', false);
					$('[name="Dont_email_ind"]').prop('checked', false);
					$('[name="Dont_Mail_ind"]').prop('checked', false);
					for( i=0 ; i<result.calllist_data.length ; i++){
						$('[name=typeOfVoucher]').val(result.calllist_data[i].type_of_vouncher);
						$('[name=voucherValue]').val(result.calllist_data[i].vouncher_value);
						$('[name="Dont_call_ind"][value="' + result.calllist_data[i].dont_call_ind + '"]').prop('checked', true);
						$('[name="Dont_SMS_ind"][value="' + result.calllist_data[i].dont_sms_ind + '"]').prop('checked', true);
						$('[name="Dont_email_ind"][value="' + result.calllist_data[i].dont_email_ind + '"]').prop('checked', true);
						$('[name="Dont_Mail_ind"][value="' + result.calllist_data[i].dont_mail_ind + '"]').prop('checked', true);
					}

					//show history call

					/*
								 let opt = "<option value=''></option>";
						    
								    
									$('[name=wrapup1]').html( opt );
								    
									//wrapup change
									$('[name=wrapup1]').change( function(){
										   $('[name=wrapup2]').html("");
										   $('[name=wrapup3]').html("");
										   let val = $(this).val();
											$.call.queryWrapup(2,val )
									});
									*/


				} //end success

			}) //end ajax


			//clear global parameter; 
			channelid = "";
			uniqueid = "";

			//clear current wrapup  status saved
			$('#wrapup-msg').removeAttr('data-status');

			$('#phone-status').text('Ready to call...'); //show ready to call status on header
			$('#wrapup-msg').hide(); // hide wrapup save msg				   
			$('#reminder-msg').hide(); // hide reminder save msg

			//action reset popupcall vertical menu				
			$('#popup-menu li').removeClass('active');
			$('#popup-menu li:first').addClass('active');

			//show call popup-box
			$('#call-box').show();
			$('#wrapup-box').hide();
			$('#history-box').hide();
			$('#reminder-box').hide();

			$('#panel-wrapup-header').hide();
			$('#panel-history-header').hide();
			$('#panel-popup-header').show();
			$('#panel-reminder-header').hide();

			//action check recently called 
			$.call.show_recently_called();

			//action check recently called
			/*
			   let sys = $('#page-subtitle').attr('data-page');
				let current = 0;
				let id = 0;
				let max = 0;
				 if( sys=="diallist"){
					 //check is called
					 id = sys_dial.list[sys_dial.current - 1];
					 if(  sys_dial.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }else if( sys=="callback"){ 
					//check is called
					 id = sys_callback.list[sys_callback.current -1];
					 if(  sys_callback.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }else if(sys=="followup"){
					//check is called
					 id = sys_follow.list[sys_follow.current -1];
					 if(  sys_follow.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
					 
				 }else if(sys=="callhistory"){
					 //check is called
					 id = sys_hist.list[sys_hist.current -1];					
					 if(  sys_hist.called.indexOf(id) != -1  ){
							$('#popup-recently-call').show();
					 }else{
							$('#popup-recently-call').hide();
					 }
				 }
				 //end check recently called
			   */
			//action before load content
			$('#popup').fadeIn('fast', function () {
				// window.scrollTo(0, 0);
				$(this).css({
					'height': (($(document).height())) + 'px'
				});
				$("html, body").animate({
					scrollTop: 0
				}, "fast");
			});

			$('#popup-close').off('click').click(function () {
				$.RemoveQueryString();
				$('.softphone').tabSlideOut('close');
				$('#popup').fadeOut('slow');


				//reload window
				// location.reload();

				//clear all value;
				//sys_dial.list = []; 
				//	sys_dial.current = 0;
				sys_dial.called = [];

				//sys_callback.list = [];
				//sys_callback.current = 0;
				//sys_callback.called = [];

				//sys_follow.list = [];
				//sys_follow.current = 0;
				//sys_follow.called = [];

				//sys_hist.list = [];
				//sys_hist.current = 0;
				//sys_hist.called = [];

			});

			$.call.initWrapup();

		},
		transfer: function (queueid) {
			if (!queueid || (!$.call.voiceid && !$.call.lastInteraction)) return;
			return $.ajax({
				'url': url,
				'data': {
					'action': 'geneTransfer',
					'voiceid': $.call.voiceid,
					'lastInteraction': $.call.lastInteraction,
					'queueid': queueid,
					'cmpName' :  $.call.currentCmp.cmpname
				},
				'dataType': 'html',
				'type': 'POST',
				'success': function (data) {
					let response = eval('(' + data + ')');
					if (response.result) {
						$('#stacknotify').stacknotify({ 'message': response.data, 'detail': 'Success' });
					} else {
						$('#stacknotify').stacknotify({ 'message': response.data, 'detail': 'Error', 'type': 'error' });
					}
					// if (response.result == "success") {
					// 	let sec = parseInt(response.data);
					// 	console.log("return value " + sec);

					// 	//sec = 5000;
					// 	if (sec > 0) {
					// 		console.log("set time out : " + sec);
					// 		setTimeout(function () {
					// 			//console.log( sec );
					// 			let opts = {
					// 				"sound": "on"
					// 			};
					// 			$.reminder.alarm(opts);
					// 			//  doSomething();
					// 			// loop();  
					// 		}, sec);
					// 	} else {
					// 		console.log("no reminder " + sec);

					// 	}
					// 	//setTimeout( $.reminder.nextalarm() , 5000 );



					// } //end if

				} //end success
			}); //end ajax
		},
		makeCall: async function (call, callnumber) {
			if (!call || !callnumber) return;
			if (callsts != "") {
				return;
			} else {
				callsts = "oncall";
			}

			//check Renewal is issued
			let incident_type  = $('[name=incident_type]').val();
			if(incident_type == "Renewal"){
				$body.addClass("loading");
				let token = localStorage.getItem('accessToken');
				if(token == null){
					await getToken();
					token = localStorage.getItem('accessToken');
				}
				let retrieve_quote_url  = $('[name=retrieve_quote_url]').val();
				let personal_id = $('[name=personal_id]').val();
				let udf4  = $('[name=udf4]').val();
				let body = {
					"channelType": "10",
					"idNo": personal_id,
					"policyNo": udf4
				  };
				console.log("retrieveQuote request:",retrieve_quote_url,body);
				let retrieve_quote_result = await retrieveQuote(retrieve_quote_url,token,body);
				console.log("retrieveQuote result:",retrieve_quote_result);
				if(retrieve_quote_result.statusCode == 401){
					await getToken();
					token = localStorage.getItem('accessToken');
					console.log("retrieveQuote request:",retrieve_quote_url,body);
					retrieve_quote_result = await retrieveQuote(retrieve_quote_url,token,body);
					console.log("retrieveQuote result:",retrieve_quote_result);
				}
				if(retrieve_quote_result.data != null){
					if (await autoWrapupRenewal(retrieve_quote_result.data.statusCode) == true){
						return;
					}
				}
				$body.removeClass("loading");
			}

			//makecall genesys
			if (this.callFrom == "sp") {
				let interactionId = $('[name=voiceid]').val();
				let payload = {
					action: 'pickup',
					id: interactionId
				};
				softphone.contentWindow.postMessage(JSON.stringify({
					type: 'updateInteractionState',
					data: payload
				}), "*");
			} else {
				let calllist_id = $('[name=listid]').val();
				console.log("makeCall calllist_id:",calllist_id);
				$.post(url, {
					"action": "getQueueFromCalllist",
					"calllist_id": calllist_id
				}, function (result) {
					try{
						console.log("makeCall getQueueFromCalllist result:",result);
					let response = eval('(' + result + ')');
					if (response.result == "success") {
						console.log("getQueueFromCalllist data:",response);
						let genesys_queue_id = response.data.genesys_queue_id;
						if(genesys_queue_id == ""){
							genesys_queue_id = $('[name=queueid]').val();
						}
						console.log("makeCall genesys_queue_id:",genesys_queue_id);
						if(genesys_queue_id != ""){
							let ctdObj = {
								type: 'clickToDial',
								data: (genesys_queue_id) ? {
									number: call,
									autoPlace: true,
									queueId: genesys_queue_id
								} : {
									number: call,
									autoPlace: true
								}
							};
							softphone.contentWindow.postMessage(JSON.stringify(ctdObj), "*");
						}
					} 
					} catch (e) {
						console.log("makeCall getQueueFromCalllist error:",e);
					}
				});
			}

			//socket test
			/*
				  socket  = io.connect('http://192.168.0.101:8888');	
				  socket.on('connect', function(){
								 console.log("client connected");
								// $('#chat').show();
								 //socket.emit('uregist', 'a'  , 'test' );
			
								 //send register msg
								 let uid = jQuery('[name=uid]').val();
								 let uext = jQuery('[name=uext]').val();
								 socket.emit('ureg', { 'uid' : uid , 'ext' : uext });
								 socket.on('ureg', function( data ){
								let msg =  "agent id ["+data.uid+"] on extension ["+data.ext+"] register : "+data.msg+"<br/>"; 

										// jQuery('#msg').append(msg)
								 
										console.log( data.msg );
								});
								//recieved hangup msg 
								socket.on('hangup', function(data){
										console.log( data.msg );
										 jQuery('#msg').append(data.msg)
										 if( data.action == "hangup"){
												jQuery('#msg').append("Hangup....<br/>");

												jQuery('#hangup').fadeOut('fast', function(){
													jQuery('#makecall').fadeIn('fast');
												});
										}
								});
								 
								 
				  });
				 //end socket
				*/

			//clear current wrapup saved status 
			$('#wrapup-msg').removeAttr('data-status');

			//action can't do when make call
			$('#turn-right').css('visibility', 'hidden');
			$('#turn-left').css('visibility', 'hidden');

			//hide close button
			$('#popup-close').css('visibility', 'hidden');

			//display animate on popup header
			//real


			$('#phone-status').text('Make Call... ' + callnumber).addClass('blink');

			//integration genesys
			$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
			$('#wrapup-click').trigger('click');
			$('#makecall').fadeOut('medium', function () {
				$('#hangup').fadeIn('fast');
			});


			/*
				let uid = $('[name=uid]').val();
				let src = $('[name=uext]').val();
				$.post('sys_ami.php',{"action":"makecall","src": src ,"dst": call ,"uid": uid },function(data){
		
					let result =  eval('(' + data + ')'); 		
					
					if(result.status == 'x' ){
						alert("WARNNING !!  your phone is : "+result.statusdtl);
					
							//set animate to initial 
							$('#phone-status').fadeOut('slow', function(){ 
								$(this).text('Ready to call...') 
								$(this).fadeIn('fast');
							}).removeClass('blink');
						return ;
					}
				
					//global uniqueid
					channel = result.channel;    //set channel id for hangup
					uniqueid = result.uniqueid;  //set unique id for link with telephony system 
					
					//console.log( "ast ami channel : "+channel );
					//console.log( "ast ami uniqueid : "+uniqueid)
				
					
					$('#phone-status').fadeOut('slow', function(){ 
						$(this).text('On Call... '+callnumber); 
						$(this).fadeIn('fast');
					})
					
					//change button to hangup
					//can change after recieved hangup channel
						$('#makecall').fadeOut( 'medium' , function(){
							$('#hangup').fadeIn('fast');
						});
					
					//show wrapup when click make call delay after chang button
					//recieved channel then show wrapup
					setTimeout(function(){
						$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
						$('#wrapup-click').trigger('click');
					},1000);
			
				
			
					//remove class blink ( as shown on header )
					$('#phone-status').removeClass('blink');
						
				});//end post
				*/


			/*$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
			$('#wrapup-click').trigger('click');*/



			// test no asterisk
			/*
				let max = 1000;
				let min = 3000;
				let random_unique_id = Math.floor(Math.random() * (max - min + 1)) + min;
				
				
				let max = 4000;
				let min = 2000;
			let rand = Math.floor(Math.random() * (max - min + 1)) + min;
				$('#phone-status').text('Make Call... '+callnumber).addClass('blink');
				setTimeout(function(){
					
						//action change button makecall to hangup
					$('#phone-status').fadeOut('slow', function(){ 
							$(this).text('On Call... '+callnumber); 
							$(this).fadeIn('fast');
					})
						//show wrapup when click make call
					//recieved channel then show wrapup
						$('.panel-heading,#wrapup-box,#wrapup-click').addClass('fadeInUp');
						$('#wrapup-click').trigger('click');
						
						//global uniqueid
						channel = "";    //set channel id for hangup
						uniqueid = random_unique_id;  //set unique id for link with telephony system 
						
						//change button to hangup
						//can change after recieved hangup channel
						$('#makecall').fadeOut( 'medium' , function(){
							$('#hangup').fadeIn('fast');
						});
						
					
						//remove class blink ( as shown on header )
					$('#phone-status').removeClass('blink');
				
				}, rand );
			*/
			//end test

		},
		hangupCall: function () {

			let uid = $('[name=uid]').val();

			let interactionId = $('[name=voiceid]').val();
			let payload = {
				action: 'disconnect',
				id: interactionId
			};
			softphone.contentWindow.postMessage(JSON.stringify({
				type: 'updateInteractionState',
				data: payload
			}), "*");

			//hangup test
			/*
				callsts = "";
				  
				//display phone status on header
				   $('#phone-status').fadeOut('slow', function(){ 
					   $(this).text('Hangup...') 
							  $(this).fadeIn('fast');
				   });
				
				 //if hangup not return success , button not change to make call 
				//change hangup button to make call button
				 $('#hangup').fadeOut('medium' , function(){
					  $('#calllistphone').fadeIn('fast');
					  $('#makecall').fadeIn('fast' , function(){ });
				  });
				  */
			//end hangup test


			// $.post('sys_ami.php',{"action":"hangup","channel":channel ,"uid": uid },function(data){
			//         let result = eval('('+data+')');	

			//         if(result.data=="Success"){

			// 			//console.log("success"+result.data);
			// 		   //set global status to empty ( ava for next retry call );
			// 		    callsts = "";

			//         	//display phone status on header
			// 			   $('#phone-status').fadeOut('slow', function(){ 
			// 				   $(this).text('Hangup...') 
			// 	    		   	$(this).fadeIn('fast');
			// 	    	   });

			// 			 //if hangup not return success , button not change to make call 
			//         	//change hangup button to make call button
			//         	 $('#hangup').fadeOut('medium' , function(){
			// 				  $('#calllistphone').fadeIn('fast');
			// 				  $('#makecall').fadeIn('fast' , function(){ });
			// 			  });


			//         }//end if
			//    });


			//remove wrapup action
			//$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');
			// console.log( $('#wrapup-msg').attr('data-status') );
			//check is wrapup already save
			//   if( $('#wrapup-msg').attr('data-status') == "saved" ){

			// 	  //remember last called id 
			// 		let sys = $('#page-subtitle').attr('data-page');
			// 		let currentrow = 0;	 
			// 		let totalrow = 0

			// 		 if( sys=="diallist"){
			// 				sys_dial.called.push( sys_dial.list[sys_dial.current-1] )
			// 				currentrow = sys_dial.current;
			// 				totalrow =  sys_dial.list.length;

			// 		 }else if( sys=="callback"){ 
			// 				sys_callback.called.push( sys_callback.list[sys_callback.current-1])
			// 				currentrow = sys_callback.current;
			// 				totalrow =  sys_callback.list.length;

			// 		 }else if(sys=="followup"){
			// 				sys_follow.called.push( sys_follow.list[sys_follow.current-1])
			// 				currentrow = sys_follow.current;
			// 				totalrow =  sys_follow.list.length;

			// 		 }else if(sys=="callhistory"){
			// 				sys_hist.called.push( sys_hist.list[sys_hist.current-1])
			// 				currentrow = sys_hist.current;
			// 				totalrow =  sys_hist.list.length;
			// 		 }

			// 	   //show left right call list ( delay 3 sec )
			// 	   setTimeout(function(){
			// 			//visible left right arrow 
			// 		  if( currentrow == 1  ){
			// 				$('#turn-left').css('visibility','hidden'); 
			// 		   }else{
			// 			   $('#turn-left').css('visibility','visible'); 
			// 		   }
			// 		  if( currentrow >= totalrow  ){
			// 				$('#turn-right').css('visibility','hidden'); 
			// 		   }else{
			// 			   $('#turn-right').css('visibility','visible'); 
			// 		   }

			// 			//show close button
			// 			$('#popup-close').css('visibility','visible');

			// 	 }, 300);


			//   }

		},
		show_recently_called: function () {

			let sys = $('#page-subtitle').attr('data-page');
			let current = 0;
			let id = 0;
			let max = 0;


			//test
			//  console.log( "on system : "+sys);
			if (sys == "diallist") {
				//check is diallist
				id = sys_dial.list[sys_dial.current - 1];
				if (sys_dial.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}
				//test
				// console.log( "current list "+sys_dial.current );

			} else if (sys == "callback") {
				//check is callback
				id = sys_callback.list[sys_callback.current - 1];
				if (sys_callback.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "followup") {
				//check is followup
				id = sys_follow.list[sys_follow.current - 1];
				if (sys_follow.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "callhistory") {
				//check is callhistory
				id = sys_hist.list[sys_hist.current - 1];
				if (sys_hist.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}
			}




		},
		nextlist: function () {

			//remove wrapup action
			$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');

			//get system
			let sys = $('#page-subtitle').attr('data-page');
			let current = 0;
			let id = 0;
			let max = 0;
			if (sys == "diallist") {
				sys_dial.current++;
				current = sys_dial.current;
				id = sys_dial.list[sys_dial.current - 1];
				max = sys_dial.list.length;
				//check is called
				if (sys_dial.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "callback") {
				sys_callback.current++;
				current = sys_callback.current;
				id = sys_callback.list[sys_callback.current - 1];
				max = sys_callback.list.length;
				//check is called
				if (sys_callback.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "followup") {
				sys_follow.current++;
				current = sys_follow.current;
				id = sys_follow.list[sys_follow.current - 1];
				max = sys_follow.list.length;
				//check is called
				if (sys_follow.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "callhistory") {
				sys_hist.current++;
				current = sys_hist.current;
				id = sys_hist.list[sys_hist.current - 1];
				max = sys_hist.list.length;

				//check is called
				if (sys_hist.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			}

			//display on popup
			if (current >= max) {
				$('#turn-right').css('visibility', 'hidden');
			}
			$('#popup-current-row').text('').text(current);
			$('#turn-left').css('visibility', 'visible');

			//load after increase 
			$('[name=listid]').val(id);
			//effect
			$('#popup-body').fadeOut('fast', function () {
				$.call.loadpopup_content("");
				$(this).fadeIn('fast');
			})

		},
		prevlist: function () {
			//remove wrapup action
			$('.panel-heading,#wrapup-box,#wrapup-click').removeClass('fadeInUp');

			//get system
			let sys = $('#page-subtitle').attr('data-page');
			let current = 0;
			let id = 0;
			let max = 0;
			if (sys == "diallist") {
				sys_dial.current--;
				current = sys_dial.current;
				id = sys_dial.list[sys_dial.current - 1];
				max = sys_dial.list.length;
				//check is called
				if (sys_dial.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "callback") {
				sys_callback.current--;
				current = sys_callback.current;
				id = sys_callback.list[sys_callback.current - 1];
				max = sys_callback.list.length;
				//check is called
				if (sys_callback.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "followup") {
				sys_follow.current--;
				current = sys_follow.current;
				id = sys_follow.list[sys_follow.current - 1];
				max = sys_follow.list.length;
				//check is called
				if (sys_follow.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			} else if (sys == "callhistory") {
				sys_hist.current--;
				current = sys_hist.current;
				id = sys_hist.list[sys_hist.current - 1];
				max = sys_hist.list.length;
				//check is called
				if (sys_hist.called.indexOf(id) != -1) {
					$('#popup-recently-call').show();
				} else {
					$('#popup-recently-call').hide();
				}

			}

			//display on popup header
			if (current == 1) {
				$('#turn-left').css('visibility', 'hidden');
			}
			$('#popup-current-row').text('').text(current);
			$('#turn-right').css('visibility', 'visible');

			//load after increase 
			$('[name=listid]').val(id);
			//effect
			$('#popup-body').fadeOut('fast', function () {
				$.call.loadpopup_content("");
				$(this).fadeIn('fast');
			})


		},
		save_reminder: function () {
			let formtojson = JSON.stringify($('form').serializeObject());
			$.post(url, {
				"action": "save_reminder",
				"data": formtojson
			}, function (result) {
				let res = eval('(' + result + ')');
				if (res.result == "success") {

					$('[name=pop_reminderid]').val(res.remid);
					$('#reminder-msg').fadeOut('fast', function () {
						$(this).fadeIn('slow');
					})

				}
			});

		},
		phoneStatus: function (text, blink) {
			if (blink === undefined) {
				blink = false;
			}
			if (blink) {
				$('#phone-status').text(text).addClass('blink');
			} else {
				$('#phone-status').text(text).removeClass('blink');
			}
		},
		alarm: function (opts) {
			console.log("alarm");
			let options = {
				'distance': 12,
				'times': 4
			};
			$("#shake").effect('shake', options, 500).delay(400).effect('shake', options, 500);

			if (opts.sound == "on") {
				let audio = $("#alarm-ring")[0];
				audio.play();
			}


			$.reminder.nextalarm('off');


		},
		nextalarm: function (opt) {
			let formtojson = JSON.stringify($('form').serializeObject());
			$.ajax({
				'url': url,
				'data': {
					'action': 'alarm',
					'data': formtojson,
					'opt': opt
				},
				'dataType': 'html',
				'type': 'POST',
				'success': function (data) {
					let response = eval('(' + data + ')');
					if (response.result == "success") {
						let sec = parseInt(response.data);
						console.log("return value " + sec);

						//sec = 5000;
						if (sec > 0) {
							console.log("set time out : " + sec);
							setTimeout(function () {
								//console.log( sec );
								let opts = {
									"sound": "on"
								};
								$.reminder.alarm(opts);
								//  doSomething();
								// loop();  
							}, sec);
						} else {
							console.log("no reminder " + sec);

						}
						//setTimeout( $.reminder.nextalarm() , 5000 );



					} //end if

				} //end success
			}); //end ajax

		},
		search_calllist: function () {

			let formtojson = JSON.stringify($('form').serializeObject());
			$.post("call-pane_process.php", {
				"action": "search_calllist",
				"data": formtojson
			}, function (data) {
				let result = eval('(' + data + ')');
				if (result.result == "success") {


					//** DIAL LIST **//
					let $table = $('#calllist-table tbody');
					$table.find('tr').remove();
					let x = "";
					let range = parseInt(result.fieldlength);
					//load agent call list  
					let seq = 1;
					//clear list
					sys_dial.list = [];

					// console.log( result.clist.length );
					let i;
					for (i = 0; i < result.clist.length; i++) {
						sys_dial.list.push(result.clist[i].f0);
						x += "<tr id='" + result.clist[i].f0 + "'><td style='vertical-align:middle; text-align:center' >" + seq + "</td>";
						let row = "";
						for (let f = 1; f < range; f++) {
							let dynvar = eval("result.clist[" + i + "].f" + f);
							if (f == 1) {
								row += "<td ><a href='#' class='nav-call-id'><strong>" + dynvar + "</strong></a></td>";
							} else {
								row += "<td >&nbsp;" + dynvar + "&nbsp;</td>";
							}
						}
						x += row;
						x += "</tr>";
						seq++;
					}

					$table.html(x);

					//dial list tfooter
					if (i == 0) {
						$row = $("<tr id='nodata'><td colspan='" + range + "' class='text-center' >&nbsp; No Call Record  &nbsp;</td></tr>")
						$row.appendTo($table);
					} else {
						$table = $('#calllist-table tfoot');
						$table.find('tr').remove();
						let s = "s";
						if (i < 1) {
							s = "";
						}
						$addRow = $("<tr ><td colspan='" + range + "'  style='border-top: 1px solid #EAEAEA' ><small> Total <span style='color:blue'>" + i + "</span> record" + s + " </small></td></tr>");
						$addRow.appendTo($table);

						$('#total_diallist').text('').text(i);

						//highlight row table when click     
						$('#calllist-table tbody').on('click', 'tr', function () {
							$('#calllist-table tr.selected-row').removeClass('selected-row')
							$(this).addClass('selected-row');
						});

						//add action when double click on row
						$('#calllist-table tbody').on('dblclick', 'tr', function () {

							//set current click list
							sys_dial.current = $(this).children().first().text();
							$('#popup-current-row').text('').text(sys_dial.current);
							$('#popup-total-row').text('').text(sys_dial.list.length);

							if (sys_dial.current == 1) {
								$('#turn-left').css('visibility', 'hidden');
							} else {
								$('#turn-left').css('visibility', 'visible');
							}
							if (sys_dial.current >= sys_dial.list.length) {
								$('#turn-right').css('visibility', 'hidden');
							} else {
								$('#turn-right').css('visibility', 'visible');
							}

							$('[name=listid]').val($(this).attr('id'));

							//load popup content
							$.call.loadpopup_content("");

						})

					}
					//end if list footer



				}
			});



		},
		queryMultiProductCampaignName: function () {
			let cmpisMultiProduct_udf_field = $('[name=cmpisMultiProduct_udf_field]').val();
			let calllist_id = $('[name=listid]').val();
			let formtojson = JSON.stringify({ cmpisMultiProduct_udf_field,calllist_id});

			$.ajax({
				url: url,
				data: {
					action: 'queryMultiProductCampaignName',
					data: formtojson
				},
				dataType: 'html',
				type: 'POST',
				success: function (data) {
					let result = eval('(' + data + ')');
					console.log(" result:", result)
					$(document).off('click', '.popup-trigger').on('click', '.popup-trigger', function (e) {
						e.preventDefault();

						if ($('#popup-box').length) {
							$('#popup-box').remove();
							return;
						}

						let cmpid = $(this).data("cmpid");
						let callid = $(this).data("callid");
						let aid = $(this).data("aid");
						let imid = $(this).data("imid");

						let popup = $('<div id="popup-box"></div>').css({
							position: 'absolute',
							top: $(this).offset().top + $(this).outerHeight(),
							left: $(this).offset().left + 50,
							backgroundColor: '#fff',
							padding: '10px',
							borderRadius: '8px',
							boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
							zIndex: 1000,
						});

						let list = $('<ul id="popup-list"></ul>').css({
							listStyle: 'none',
							padding: '0',
							margin: '0',
						});

						if (Array.isArray(result)) {
							result.forEach((app) => {
								let listItem = $('<li style="padding: 10px; cursor: pointer;"></li>')
									.text(app.campaign_name)
									.on('click', function () {
										let url = `/app/aig/Application/check_app.php?campaign_id=${app.campaign_id}&calllist_id=${callid}&agent_id=${aid}&import_id=${imid}&id=`;
										window.open(url, '_blank');
									});

								list.append(listItem);
							});
						}

						popup.append(list);
						$('body').append(popup);

						$(document).on('click', function (event) {
							if (!$(event.target).closest('#popup-box, .popup-trigger').length) {
								$('#popup-box').remove();
							}
						});
					});
				},
				error: function (xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
		}



	} //end jQuery

	function mask(input, pattern) {

		let res = "";
		for (let i = 0; i < pattern.length; i++) {
			let m = pattern.charAt(i);
			if (m == 0) {
				res = res + input.charAt(i);
			} else {
				res = res + m
			}
		}

		// input.replace(/blue/g, "red"); 

		return res;
	}

	function autoWrapup() {
		console.log("Auto Wrapup");
		$('input[type=radio][name=wrapup1][value=909]').prop('checked', true);
		$.call.saveWrapup();
		clearTimeout(timerAutoWrapup);
	}

	async function getToken() {
		await fetch('getTokenAPI.php', {
			method: 'GET',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		})
		.then(response => response.text())
		.then(data => {
			console.log("getToken data:",data); 
			localStorage.setItem('accessToken', data);
		})
		.catch(error => {
			console.error('getToken error:', error);
		});
	}

	async function retrieveQuote(url, token, body) {
		try {
			const response = await fetch(url, {
				method: 'POST',
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(body)
			});
	
			const data = await response.json();
			const statusCode = response.status;
	
			return {
				statusCode,
				data
			};
	
		} catch (error) {
			console.error('retrieveQuote error:', error);
			return {
				statusCode: null,
				data: null
			};
		}
	}

	async function autoWrapupRenewal(statusCode) {
		if (statusCode == "N01"){
			alert("Quote is referred.");
			$body.removeClass("loading");
			let calllist_id = $('[name=listid]').val();
			let agent_id = $('[name=uid]').val();
			console.log("autoWrapupRenewal :",calllist_id,agent_id);
			const result = await $.post(url, {
                "action": "getLastWrapup",
                "calllist_id": calllist_id,
                "agent_id": agent_id
            });
            console.log("getLastWrapup result:", result);
            let response = eval('(' + result + ')');
			console.log("getLastWrapup response:", response);
            if (response.result === "success") {
                let last_wrapup_id = response.data.last_wrapup_id;
                if (last_wrapup_id === "") {
                    $('input[type=radio][name=wrapup1][value=1]').prop('checked', true).trigger('change');
                } else {
                    let wrapup_codes = last_wrapup_id.split("|");
                    $('input[type=radio][name=wrapup1][value=' + wrapup_codes[0] + ']').prop('checked', true).trigger('change');
                    if (wrapup_codes[1] !== '') {
						setTimeout(function() {
                        	$('input[type=radio][name=wrapup2][value=' + wrapup_codes[1] + ']').prop('checked', true).trigger('change');
						}, 1000);
                    }
                }
                setTimeout($.call.saveWrapup, 1000);
                return true;
            }
		}
		if (statusCode == "N18"){
			alert("Policy has already been issued.");
			$body.removeClass("loading");
			$('input[type=radio][name=wrapup1][value=5]').prop('checked', true).trigger('change');
			setTimeout(function() {
				$.call.saveWrapup();
			}, 1000);
			return true;
		} 
		if (statusCode == "N15"){
			alert("Quote has lapsed.");
			$body.removeClass("loading");
			$('input[type=radio][name=wrapup1][value=12]').prop('checked', true).trigger('change');
			setTimeout(function() {
				$('input[type=radio][name=wrapup2][value=36]').prop('checked', true).trigger('change');
			}, 1000);
			setTimeout(function() {
				$.call.saveWrapup();
			}, 1000);
			return true;
		} 
		if (statusCode == "N16"){
			alert("Quote has been rejected.");
			$body.removeClass("loading");
			$('input[type=radio][name=wrapup1][value=12]').prop('checked', true).trigger('change');
			setTimeout(function() {
				$('input[type=radio][name=wrapup2][value=36]').prop('checked', true).trigger('change');
			}, 1000);
			setTimeout(function() {
				$.call.saveWrapup();
			}, 1000);
			return true;
		} 
		
	}

	window.activeList = function(call_id) {
		console.log("activeList call_id:",call_id);
		$.post(url, {
			"action": "activeList",
			"call_id": call_id,
		});
		$.call.dtList.history.ajax.reload();
	}

})(jQuery) //end function

let timerAutoWrapup;

$(function () {

	$body = $("body");
	$(document).on({
		ajaxStart: function () { $body.addClass("loading"); },
		ajaxStop: function () { $body.removeClass("loading"); }
	});

	//test wrapup
	//$.call.initWrapup();

	// console.log( "cookie campaign : "+$.cookie("cur-cmp")  );
	let currcamp = $.cookie("cur-cmp");
	if (currcamp == undefined) {
		//if no cookie load campaign for join
		$('#callcampaign-pane').load('callcampaign-pane.php', function () {
			$(this).fadeIn('slow');
		});

	} else {
		/*
		let tmp =  currcamp.indexOf("|");
			let cmpid = currcamp.substring(0,tmp);
		let cmpname = currcamp.substring( tmp+1 , currcamp.length );

		//load campaign dynamic 
		  $.call.cmp_initial( cmpid );
		  */

		let uid = $('[name=uid]').val();
		let tmp = currcamp.split("|");
		//check if user not match in cookie
		if (tmp[2] != uid) {

			$('#callcampaign-pane').load('callcampaign-pane.php', function () {
				$(this).fadeIn('slow');
			});

		} else {

			$.call.cmp_initial(tmp[0]).done(() => {
				$('#callwork-pane').load('callwork-pane.php', function () {
					$(this).fadeIn('slow');
					$.call.load_newlist(tmp[0]);
				});
			});
			$('[name=cmpid]').val(tmp[0]);
			$('[name=queueid]').val(tmp[3]);
			$('[name=cmptype]').val(tmp[4]);
			$('[name=queuecallbackid]').val(tmp[6]);
			$('#callwork-mon').fadeIn(1000);

		} //end else

		

	}

	$.call.initWrapup();


	//check campaign from cookie
	/*
	console.log( "cookie campaign : "+$.cookie("cur-cmp")  );
	let currcamp = $.cookie("cur-cmp");
	if( currcamp == "" ||  currcamp == undefined ){
	    
		console.log("if");
	    
		//get campaign
	
		$('#cmp-logoff').hide();
	    
		//$('#select-campaign').show();
	    
	  	

	    
	}else{
		console.log("esle");
	    
		let tmp =  currcamp.indexOf("|");
		let cmpid = currcamp.substring(0,tmp);
	   let cmpname = currcamp.substring( tmp , currcamp.length );
	    
			  //load current campaign
			//$.call.selectCmp( cmpid , cmpname );
			$('#cmp-logoff').show();
	   	
  	
	}
	*/

	//init action
	//show campaign on menu bar
	/* not use ?
	  $('.cmp_selected').on( 'click', function(e){
		  	
			  e.preventDefault();
			  $.call.init();
			  //if logoff show current menu
				  $('#smartpanel-detail').html('<span class="ion-ios7-telephone-outline size-24"></span>TeleSmile');
				  $('#cmp-logoff').hide();
				   
				  //delete to cookie
			  $.removeCookie('cur-cmp');
			  $('#select-campaign').show();
	  });
	  */

	//save wrapup
	$('.save_wrapup').click(function (e) {
		e.preventDefault();
		$.call.saveWrapup();
		clearTimeout(timerAutoWrapup);
	})


	$('.save_reminder_onpopup').click(function (e) {
		e.preventDefault();

		//save reminder
		$.call.save_reminder();

		//if save success 
		$('#backto-wrapup').fadeIn('slow');

		$('#wrapup-link').fadeIn('slow');
		$('#backto-wrapup').click(function (e) {
			e.preventDefault();
			$('#wrapup-box').show();
			$('#call-box').hide();
			$('#history-box').hide();
			$('#reminder-box').hide();

			$('#panel-wrapup-header').show();
			$('#panel-history-header').hide();
			$('#panel-popup-header').hide();
			$('#panel-reminder-header').hide();
		})
	});

	/*
	  //fruits.push("Kiwi");
	   let x = { calllist: [1,2,3,4] , current : 3 , called : [1,2,3]}
	   console.log( "total calllist"+ x.calllist.length );
	   let focus =  x.current 
	   console.log( "current "+ x.current );
	   let y = $.inArray(  focus , x.called )
	   console.log( "jq : "+y );
	   let z = x.called.indexOf(focus);
	   console.log( "java : "+z);
	   
	   if( x.called.indexOf(focus) != -1 ){
		   console.log("found");
	   }else{
		   console.log("not found");
	   }
	*/


});