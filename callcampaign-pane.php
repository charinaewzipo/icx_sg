<!--select campaign-->
<div id="callcampaign-main-pane">
    <h2 style="font-family:raleway; color:#666; font-weight:400"> Join Campaign</h2>
	<table class="table table-border" id="campaign-table" >
		<thead>
			<tr class="primary">
				<td class="text-center" style="width:5%"> # </td>
				<td style="width:20%"> Campaign Name  </td>
				<td class="text-center" style="width:10%"> Total List </td>
				<td class="text-center" style="width:10%"> New List </td>
				<td class="text-center" style="width:10%"> No Contact </td>
				<td class="text-center" style="width:10%"> Call Back List </td>
				<td class="text-center" style="width:10%"> Followup List </td>
				<td class="text-center" style="width:15%"> Last Join Date </td>
				<td class="text-center" style="width:20%"> &nbsp; </td>
			</tr>
		</thead>
		<tbody class="hover">
		</tbody>
		<tfoot>
	   </tfoot>
	</table>
	

</div>
<!--  end group-detail-pane -->
<script>
 $(function(){
	  $.call.init();

		 //init event
		 //add event dblclick to  tr
		 $('#campaign-table tbody').on('dblclick','tr',function(){
			
				var cmpid = $(this).attr('id');
				var cmpname = $(this).attr('data-name');
				$.call.cmp_initial( cmpid  );
				$.call.cmp_joinlog(cmpid , cmpname );
		 });
  })
</script>
