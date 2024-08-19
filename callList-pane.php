
<?php require_once("./app/function/StartConnect.inc"); ?> 

<div id="calllist-main-pane">
	<div style="float:left; display:inline-block">
		<h2 style="display:inline-block;font-family:raleway; color:#666666; ">Call List</h2>
		<div id="page-subtitle" data-page="diallist"
			style="font-family:raleway;color:#777777;position:relative; top:-10px; text-indent:2px;">
			Call List
		</div>
	</div>
	<div style="clear:both"></div>
	<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px; margin-bottom:5px;">
	<div style="margin-bottom:15px;">
		<div style="float:left">
			<button class="btn btn-success new_calllist" style="border-radius:3px; "> <i class="icon-upload"
					style="font-size:16px; font-weight:400"></i>&nbsp; Import New List </button>
		</div>
		<div style="float:right;">
			<!-- 
					<button class="btn" style="float:right;background-color: #16a085 ; color:#fff;  font-size:12px;  border-top-right-radius:3px; border-bottom-right-radius:3px;  height:34px;" id="calllist-search-btn"> Search  </button>
					<input type="text" placeholder="search name..." autocomplete="off" name="calllist_search" style="float:right;">
			-->
		</div>
		<div style="clear:both"></div>
	</div>

	<table class="table table-bordered" id="calllist-table">
		<thead>
			<tr class="primary">
				<td style="width:5%; text-align:center">#</td>
				<td style="width:20%; text-align:center"> List Name</td>
				<td style="width:15%; text-align:center"> Import Date </td>
				<td style="width:20%; text-align:center"> Import User </td>
				<td style="width:15%; text-align:center"> Total List </td>
				<td style="width:25%; text-align:center"> Use In Campaign </td>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<div style="float:left;"><a href='#' id='loadmorelist' data-read='1'> Load more list </a></div>
					<div style="float:right"><span id="page" style='color:blue'>0</span> of <span id="ofpage">0</span>
					</div>
					<div style="clear:both"></div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

<!-- detail pane -->
<div style="display:none; " id="calllist-detail-pane">
	<div style="position:relative; padding-top:20px;">
		<div id="calllist-back-main" style="float:left; display:inline-block;cursor:pointer; ">
			<i style="color:#666;  " class="icon-circle-arrow-left icon-3x"></i>
		</div>
		<div style="display:inline-block; float:left; margin-left:10px;">
			<h2 style="font-family:raleway; color:#666666;  margin:0; padding:0"> Call List Detail</h2>
			<div class="stack-subtitle" style="color:#777777; text-indent:4px; "> Call List Detail</div>
		</div>
		<div style="clear:both"></div>
		<hr style="border-bottom: 1px dashed #777777; position:relative; top:-10px; margin-bottom:5px;">
	</div>
	<div style="margin-bottom:15px;">
		<button class="btn btn-success new_calllist" style="border-radius:3px"><i class="icon-upload"
				style="font-size:16px; font-weight:400"></i> Import New List </button>
		<button class="btn btn-danger delete_list" style="border-radius:3px"> Delete List </button>
	</div>
	<ul class="nav nav-tabs" role="tablist ">
		<li class="active" style="vertical-align:bottom; font-size:16px;"> <a href="#tab1" role="tab" data-toggle="tab"
				id="list-detail-tab"><span class="ion-ios-copy-outline icon-2x"></span> &nbsp; Call List Detail </a>
		</li>
		<li style="vertical-align:bottom; font-size:16px;"><a href="#tab2" role="tab" data-toggle="tab"
				id="list-maintain-tab"><span class="ion-ios-color-wand-outline icon-2x"></span> &nbsp; Call List
				Maintenance </a></li>
		<li style="vertical-align:bottom; font-size:16px;"><a href="#tab3" role="tab" data-toggle="tab"
				id="list-export-tab"><span class="ion-ios-cloud icon-2x"></span> &nbsp; Call List Export </a></li>
	</ul>
	<div class="tab-content">
		<!--  tab1 Campaign Detail -->
		<div id="tab1" class="tab-pane active" style="background-color:#fff; border:1px solid #E2E2E2; border-top:0;">

			<!-- wrapper  -->
			<div style="border:0px solid #000;">
				<!--  left pane -->
				<div
					style="float:left; width:47%; border:0px solid #000; margin:15px 0 10px 10px; background-color:#f2f2f2">
					<h3 style="color:#666;font-family:raleway; text-align:center"> Call List Name Detail </h3>
					<ul style="list-style:none;margin:20px 0 0 0; padding:0; ">
						<li style="padding:5px 8%">
							<div style="color:#666;text-indent:5px; text-align:right;"> List Status : <span
									id=clist_status
									style="font-size:12px; color: rgb(255, 255, 255); padding: 2px 8px; border-radius: 3px;">
								</span></div>
							<div style="color:#666;text-indent:5px; text-align:right"> Import Date : <span
									id="clist_fimpd"></span></div>
							<div style="color:#666;text-indent:5px; text-align:right"> Import By : <span
									id="clist_fimpu"></span></div>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> List Name</div>
							<p><input name="calllist_name" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> List Detail</div>
							<p><textarea name="calllist_detail" style="width:100%; height:80px;"></textarea></p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> List Status</div>
							<p>
								<select name="calllist_status" style="width:100%">
									<option value="1"> Available </option>
									<option value="4"> Expire </option>
								</select>
							</p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> List Comment </div>
							<p><textarea name="calllist_note" style="width:100%; height:80px;"></textarea></p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> <input type="checkbox" name="is_count" id="is_count"> Normal Lead</div>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys Campaign Name</div>
							<p><input name="genesys_campaign_name" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys Campaign Id</div>
							<p><input name="genesys_campaign_id" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys List Name</div>
							<p><input name="genesys_list_name" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys List Id</div>
							<p><input name="genesys_list_id" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys Queue Name</div>
							<p><input name="genesys_queue_name" type="text" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%">
							<div style="padding-bottom:5px; color:#666;text-indent:5px;"> Genesys Queue Id</div>
							<p><input name="genesys_queue_id" type="text" style="width:100%"> </p>
							<p><input name="import_id" type="hidden" style="width:100%"> </p>
						</li>
						<li style="padding:5px 8%; text-align:right;">
							<button class="btn btn-success update_list"> Save Change </button>

						</li>
					</ul>
					** หากกำหนดสถานะเป็น expire list นั้นจะไม่สามารถทำอะไรได้เลย <br />
					** Phase ถัดไปสามารถกำหนดวันที่ และเวลาในการหมดอายุ ได้ <br />
				</div>
				<!--  end left pane -->

				<!--  right pane -->
				<div
					style="float:right; width:50%;  margin:15px 10px 0 10px;   border:0px solid red; background-color:#f2f2f2; min-height: 618px ">
					<h3 style="color:#666;font-family:raleway; text-align:center; "> Call List File Import Detail </h3>
					<!-- wrap tab -->
					<div style="margin:0 30px;">
						<ul class="nav nav-tabs" role="tablist">
							<li class="active"><a href="#tab-dtl1" role="tab" data-toggle="tab"><i
										class="icon-file-alt"></i> File Detail </a></li>
							<li><a href="#tab-dtl2" role="tab" data-toggle="tab"><i class="icon-th-large"></i> Field
									Mapped </a></li>
						</ul>
						<div class="tab-content">
							<!--  tab1 Detail -->
							<div id="tab-dtl1" class="tab-pane active"
								style="background-color:#fff; border:1px solid #E2E2e2; border-top:0;">
								<!--  start inner tab1 -->
								<ul style="list-style:none; margin:0;padding:30px;">
									<li style="padding:5px 0; margin:0 10px; border-bottom:1px solid #E2E2E2; ">
										<h4 style="color:#666;font-family:raleway; margin:0;padding:0"><i
												class="icon-file-alt"></i> File Detail </h4>
									</li>
									<li style="padding:30px 10px 5px 10px; background-color:#f2f2f2; margin: 10px;">
										<div class="pull-left"
											style="width:20%; text-align:center; position:relative ;">
											<span class="icon-file-alt"
												style="font-size:70px; color:#999; font-weight:0; position:relative;"></span>
											<div id="clist_ftype_dtl"
												style="border-radius:2px;  color:#fff; font-size:12px; top:-33px; text-align:center; position:relative;  z-index:1; padding:2px 0; margin:0 30px 0 30px;">
												TEXT</div>
										</div>
										<div class="pull-right" style="width:80%;">
											<div style="text-indent:0px; padding:1px 0;"> File Name : <span
													id="clist_fname"> </span> </div>
											<div style="text-indent:0px; padding:1px 0;"> File Type : <span
													id="clist_ftype"></span></div>
											<div style="text-indent:0px; padding:1px 0;"> File Size : <span
													id="clist_fsize"></span></div>
										</div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 0; margin:30px 10px 0 10px;  border-bottom:1px solid #E2E2E2; ">
										<h4 style="color:#444;font-family:raleway; margin:0;padding:0"><i
												class="icon-bar-chart"></i> List Import Summary </h4>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-left"> New List</div>
										<div class="pull-right" id="total-newlist"> 0 </div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-left" style=""> Bad List</div>
										<div class="pull-right" id="total-badlist"> 0 </div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-left" style=""> In List Duplicate</div>
										<div class="pull-right" id="total-inlistdup"> 0 </div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-left" style=""> In Database Duplicate</div>
										<div class="pull-right" id="total-indbdup"> 0 </div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-left" style=""> Manual Add List</div>
										<div class="pull-right" id="total-manlist"> 0 </div>
										<div style="clear:both"></div>
									</li>
									<li
										style="padding:5px 10px; border-bottom:1px dashed #CCC;font-size:16px; margin:0 20px;">
										<div class="pull-right" id="total-alllist"> 0 </div>
										<div class="pull-right" style="text-align:right; margin:0 25px;"> Total </div>
										<div style="clear:right"></div>
									</li>
								</ul>
								<!-- end inner tab1 -->
							</div>
							<!--  end tab1 Detail -->
							<!--  tab2 Detail -->
							<div id="tab-dtl2" class="tab-pane"
								style="background-color:#fff; border:1px solid #E2E2E2; border-top:0;">
								<!--  start inner tab2 -->
								<div style="">
									<ul style="list-style:none; margin:0;padding:30px;">
										<li style="padding:5px 0; margin:0 10px; border-bottom:1px solid #E2E2E2; ">
											<h4 style="color:#666;font-family:raleway; margin:0;padding:0"><i
													class="icon-th-large"></i> Field Detail </h4>
										</li>
										<li style="padding:10px 10px 0 10px;">
											<table class="table table-bordered" id="import-field-table">
												<thead>
													<tr class="primary">
														<td style="width:5%; vertical-align:middle;text-align:center"> #
														</td>
														<td style="width:45%;vertical-align:middle;text-align:center">
															Caption Name </td>
														<td style="width:50%;vertical-align:middle;text-align:center">
															Field Name </td>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>

										</li>
									</ul>

								</div>
								<!--  end inner tab2 -->
							</div>
							<!-- end tab2 Detail -->
						</div>
						<!-- end tabl content -->

					</div>
					<!-- end wrap tab -->
				</div>
				<!-- end right pane -->
				<div style="clear:both"></div>
			</div>
			<!--  end wrapper -->

			<!--  start campaign list detail -->
			<div style="margin:0 10px 10px 10px; border:1px sold #000; background-color:#F2F2F2">
				<div style="padding:5px 10px 10px 10px;">

					<h3 style="color:#666;font-family:raleway">Call List In Campaign Detail </h3>
					<table class="table table-bordered" style="width:100%" id="listcamp-table">
						<thead>
							<tr class="primary">
								<td style="text-align:center; vertical-align:middle; width:30%"> Campaign Name </td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Total List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> New List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Call Back </td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Followup </td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Do not call </td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Bad List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Over Call limit </td>
								<!-- <td style="text-align:center; vertical-align:middle; width:8%"> Call Progress </td> -->
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>
			</div>
			<!--  end campaign list detail -->

		</div>
		<!--  end tab1 -->

		<!--  start tab2 -->
		<div style="clear:both"></div>
		<div id="tab2" class="tab-pane" style="background-color:#fff; border:1px solid #E2E2E2; border-top:0">
			<!--  wrapper -->

			<div style="padding:5px 20px;position:relative; border:0px solid red">

				<div style="background-color:#F2F2F2; margin:20px 0 0 0; border-radius:3px">
					<h3 style="color:#666;font-family:raleway;padding:15px 0 0 15px"><i class="icon-search"></i> Search
						Call List</h3>
					<hr style="margin:0 20px; padding:0; border:1px solid #AAA; " />
					<ul style="list-style:none; margin:15px 0 0 0;padding:15px 0 0 0; border:0px solid green"
						id="search-ul">
						<li style="margin:5px 0; border:0px solid red">
							<div style="float:left; width:50%; text-align:center;">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> First Name : </span>
								<span style="margin:0 10px;"> <input type="text" name="search" class="input_box"></span>
							</div>
							<div style="float:right; width:50%; text-align:left">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> Last Name : </span>
								<span style="margin:0 10px;"> <input type="text" name="search" class="input_box"></span>
							</div>
							<div style="clear:both"></div>
						</li>
						<li style="margin:5px 0;border:0px solid red">
							<div style="float:left; width:50%; text-align:center;">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> First Name : </span>
								<span style="margin:0 10px;"> <input type="text" name="search" class="input_box"></span>
							</div>
							<div style="float:right; width:50%; text-align:left">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> Last Name : </span>
								<span style="margin:0 10px;"> <input type="text" name="search" class="input_box"></span>
							</div>
							<div style="clear:both"></div>
						</li>
					</ul>
					<ul style="list-style:none; padding:0 0 15px 0; border:0px solid green">
						<li>
							<div style="float:left; width:50%; text-align:right;">
								<button class="btn btn-success search_mnlist" style="width:100px"> Search </button>
								&nbsp;
							</div>
							<div style="float:right; width:50%; text-align:left">
								&nbsp;
								<button class="btn btn-default clear_mnlist" style="width:100px"> Clear </button>
							</div>
							<div style="clear:both"></div>


							<div style="width:100%; text-align:center;">

							</div>
						</li>
					</ul>

				</div>


				<table class="table table-border" id="search-table">
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<td class="text-align:center"> </td>
						</tr>
					</tfoot>
				</table>

				<h3 style="color:#666;font-family:raleway; margin:0; padidng-top: 20px 0"><i
						class="icon-align-justify"></i> Call List Detail </h3>
				<hr style="margin:10px 0; padding:0; border:1px solid #AAA; " />
				<button class="btn btn-primary new_mnlist"><i class="icon-plus-sign-alt"></i> Add List </button>
				<button class="btn btn-danger delete_mnlist"><i class="icon-minus-sign-alt"></i> Remove List </button>
				<button class="btn btn-success save_mnlist"> Save Change </button>
				<button class="btn btn-default cancel_mnlist"> Cancel </button>


				<table id="calllist-maintain-table" class="table table-bordered">
					<thead>
						<tr>
							<td>Loading Dynamic Field</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<td>
								<div style="float:left;"><a href='#' id='loadmoremnlist' data-read='1'> Load more list
									</a></div>
								<div style="float:right"><span id="calllistPage" style='color:blue'>0</span> of <span
										id=calllistOfpage>0</span></div>
								<div style="clear:both"></div>
							</td>
						</tr>
					</tfoot>
				</table>


			</div>
			<!-- end wrapper -->



			<h2>Call List Maintenance </h2>
			*** Call list ที่เพิ่มเองจะไม่ถูกนับรวมกับ Call list ที่มีการ import เข้ามา (
			เฉพาะสำหรับการนำไปออกเป็นรายงาน )
			page นี้ต้องสามารถ set do not call list ได้ด้วย <br />
			ต้องสามารถแก้ไข | ค้นหา ชื่อ เบอร์โทร | set do not call list ได้

			<div>
				<ul>
					<li> Dynamic search field </li>
					<li> ถ้า field type เป็น varchar search ได้หมด ok </li>
					<li> ทำอะไรได้บ้าง | set do not call </li>
				</ul>
				Search | set do not call | New | update = | delete => set status to 0
				<br />



			</div>

			<!-- 
			<div style="padding:10px; float:right; padding: 10px 10px 0 10px">
					<button class="btn" style="float:right;background-color: #16a085 ; color:#fff;  font-size:12px;  border-top-right-radius:3px; border-bottom-right-radius:3px;  height:34px;" id="calllist-search-btn"> Search  </button>
					<input type="text" placeholder="search name..." autocomplete="off" name="calllist_search" style="float:right;">
					<div style="clear:right"></div>
			</div>
	 -->
			<div style="clear:both"></div>
			<div style=" padding:10px;">

			</div>

		</div>
		<!--  end tab2 -->
		<!--  start tab3 -->
		<div style="clear:both"></div>
		<div id="tab3" class="tab-pane" style="background-color:#fff; border:1px solid #E2E2E2; border-top:0">
			<!--  wrapper -->

			<div style="padding:5px 10px;position:relative; border:0px solid red">

				<div style="background-color:#F2F2F2; margin:20px 0 0 0; border-radius:3px">
					<h3 style="color:#666;font-family:raleway;padding:15px 0 0 15px"><i class="icon-search"></i> Export
						Call List</h3>
					<hr style="margin:0 20px; padding:0; border:1px solid #AAA; " />
					<ul style="list-style:none; margin:15px 0 0 0;padding:15px 0; border:0px solid green"
						id="search-ul">
						<li style="margin:5px 0; border:0px solid red">
							<div style="float:left; width:50%; text-align:right">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> Lead Type </span>
								<span style="margin:0 10px;">
									<select name="leadtype" id="leadtype" style="width:150px; height:30px;">
									<?php
									/* 
										$sql = "select * from t_genesys_list where status=1";
										$result = mysqli_query($sql, $Conn) or die("ไม่สามารถเรียกดูข้อมูลได้");
										while ($row = mysqli_fetch_array($result)) {
											echo "<option value='".$row["list_id"]."'>".$row["list_name"]."</option>";
										}
									*/
									?>
									</select>
								</span>
							</div>
							<div style="float:right; width:50%; text-align:left;">
								<span style="margin:0 10px; font-size:16px; line-height:30px;"> Amount Lead : </span>
								<span style="margin:0 10px;"> <input type="text" name="genesys_amount"
										class="input_box"></span>
							</div>
							<div style="clear:both"></div>
						</li>
						<li style="margin:30px 0 0 10px;">
							<div style="float:left; width:50%; text-align:right;">
								<button class="btn btn-success genesys_export" style="width:100px"> Export </button>
								&nbsp;
							</div>
							<div style="float:right; width:50%; text-align:left">
								&nbsp;
								<button class="btn btn-default genesys_clear" style="width:100px"> Clear </button>
							</div>
							<div style="clear:both"></div>


							<div style="width:100%; text-align:center;">

							</div>
						</li>
					</ul>

				</div>

			</div>
			<!-- end wrapper -->

			<!--  start campaign list detail -->
			<div style="margin:0 10px 10px 10px; border:1px sold #000; background-color:#F2F2F2">
				<div style="padding:5px 10px 10px 10px;">

					<h3 style="color:#666;font-family:raleway">Call List In Genesys Detail </h3>
					<table class="table table-bordered" style="width:100%" id="listgenesys-table">
						<thead>
							<tr class="primary">
								<td style="text-align:center; vertical-align:middle; width:30%"> Campaign Name </td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Total List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Genesys AIG List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Genesys PVT List</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> AIG Non sponsor List
								</td>
								<td style="text-align:center; vertical-align:middle; width:10%"> Remain List </td>
								<!-- <td style="text-align:center; vertical-align:middle; width:8%"> Call Progress </td> -->
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>
			</div>
			<!--  end campaign list detail -->

		</div>
		<!--  end tab3 -->

	</div>
	<!--  end tab-content -->
</div>
<!--  end detail pane -->

<script>

	$(function () {

		$.callList.load();




		//click maintain more list
		$('#loadmoremnlist').click(function (e) {
			e.preventDefault();
			$.callList.detailMaintain();
		});

		//click tab2 maintain list
		$('#list-maintain-tab').click(function (e) {
			e.preventDefault();
			$('#loadmoremnlist').attr('data-read', '1');  //reset page 
			$('#calllistPage').text('0');								//reset seq
			$.callList.detailMaintain();




		});

		//click tab2 maintain list
		$('#list-export-tab').click(function (e) {
			e.preventDefault();
			$.callList.detailExport();
		});

		//click more list
		$('#loadmorelist').click(function (e) {
			e.preventDefault();
			$.callList.load();
		});

		//click back
		$('#calllist-back-main').click(function () {
			$('#calllist-detail-pane').hide();
			$('#calllist-main-pane').show();
		});

		//use
		$('.update_list').click(function (e) {
			e.preventDefault();
			$.callList.updateList();
		})

		$('.delete_list').click(function (e) {
			e.preventDefault();
			var confirm = window.confirm("Delete this list ?");
			if (confirm) {
				$.callList.remove();
			}
		})

		//new import list button
		$('.new_calllist').click(function (e) {
			e.preventDefault();

			$('#calllist-main-pane').hide();
			$('#calllist-detail-pane').hide();

			//init pane
			$('#calllist-import-wizard').show();
			//init stepper
			//comment for debug
			$('#stepper1').show();
			$('#stepper2').hide();
			$('#stepper3').hide();
			$('#stepper4').hide();
			$('#stepper_end').hide();

		});

		$('.genesys_export').click(function (e) {
			e.preventDefault();
			$.callList.genesysExport();
		});

		$('.genesys_clear').click(function (e) {
			e.preventDefault();
			$.callList.genesysClear();
		});

		$('.search_mnlist').click(function (e) {
			e.preventDefault();
			$.callList.search();
		});

		$('.clear_mnlist').click(function (e) {
			e.preventDefault();
			// $.callList.search();
		});

		$('.new_mnlist').click(function (e) {
			e.preventDefault();
			$.callList.new_mnlist();

		});
		$('.save_mnlist').click(function (e) {
			e.preventDefault();
			$.callList.save_mnlist();
		});
		$('.delete_mnlist').click(function (e) {
			e.preventDefault();
			//var confirm = window.confirm(" Are you sure to delete  this list ?");
			//	if( confirm ){
			$.callList.delete_mnlist();
			//	}


		});

		$('.cancel_mnlist').click(function (e) {
			e.preventDefault();
			$.callList.cancel_mnlist();

		});




	});

</script>