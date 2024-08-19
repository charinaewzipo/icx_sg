<!-- start agent-main-pane -->
<div id="news-main-pane"  >
<input type="hidden" name="nid">
<input type="hidden" name="mid">

<!--  for next  v2 -->
<input type="hidden" name="newstype" value="1">
<input type="hidden" name="newsstatus" value="1">	

 	<table class="table table-border" id="news-table">
			<thead> 
				<tr>
					<td colspan="2" style="font-size:20px;  color:#666"> <i class="icon-comments "  ></i>  What's going on </span>  </td>
				</tr>
				<tr>
					<td colspan="2"  style="margin:0;padding:10px 0">
						<ul style="margin:0;padding:0; list-style:none">
							<li><input type="text" name="newssubj" style="width:100%" placeholder="subject" autocomplete="off"></li>
							<li class="startnews" style="display:none;"><textarea name="newsdetail" style="width:100%; height:60px; " placeholder="detail" autocomplete="off"></textarea></li>
							<li class="startnews" style="display:none; padding: 10px 0 10px 10px; text-align:right"> <button class="btn btn-primary save_news">  Post  </button></li>
						</ul>
					<!--  <input type="text" value="all" name="newsvisibleto">  -->
					</td>
				</tr>
			</thead>			
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><a href="#" data-read="0" id="readmore" style="font-size:14px; font-family:raleway; weight:600;"><i class="icon-comments"></i> Read More... </a></td>
				</tr>
			</tfoot>
		</table>


</div>
<!--  end news-main-pane -->

<div id="news-detail-pane" style="display:none" class="content-overlay">
<div class="container">
	<div class="row">
	
	<div style="padding: 5px 5px;">
				<div style="display:inline-block; position:relative; top:-12px;">
				</div>
				<div style="display:inline-block; position:relative; float:right">
				        <span id="news-close" class="ion-ios-close-outline close-model" style=""></span>
				</div>
				<div style="clear:both"></div>
		</div>
		<div id="news-detail-panex"></div>
		
	</div> <!--  end div row -->
</div>	<!--  end div container -->
	

</div>

<script type="text/javascript" src="js/jquery.timeago.js"></script>
<script type="text/javascript" src="js/news.js"></script>