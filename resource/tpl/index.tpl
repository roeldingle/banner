<div class="section">
    <div class="mTitle mb30">
        <h2>Event List</h2>
    </div>
    <div class="mCtrl">
        <p class="gCtrlLeft">
            <a class="btn_delete_list btndelcreate btnDelFile ml10" href="javascript:void(0);"><span>Delete</span></a>
        </p>
        <p class="gCtrlRight">
            <a href="#" class="btncreate"><span>Create New Event</span></a>
        </p>
    </div>
    <div class="mBoard type1">
        <table border="1" summary="" class="eTr">
			<colgroup>
				<col class="chk" />
				<col style="width:6%;" />
				<col style="width:12%;" />
				<col class="subject" />
				<col style="width:8%;" />
				<col style="width:10%;" />
				<col style="width:10%;" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col" class="chk"><input type="checkbox" class="check-all allCk" /></th>
					<th scope="col">No</th>
					<th scope="col">Code</th>
					<th scope="col">Event Title</th>
					<th scope="col">Size <span>(Width px)</span></th>
					<th scope="col">Date</th>
					<th scope="col">Status</th>
				</tr>
			</thead>
			<tbody class="center">
			
				<?php echo $sHtmlTbData;?>
				
				<tr>
					<td colspan="7" class="pb40">&nbsp;</td>
				</tr>
		   </tbody>
        </table>
    </div>
    <div class="mCtrl typeBoard ">
        <p class="gCtrlLeft">
            <a class="btn_delete_list btndelcreate btnDelFile ml10" href="javascript:void(0);"><span>Delete</span></a>
        </p>
        <p class="gCtrlRight">
            <a href="#" class="btncreate"><span>Create New Event</span></a>
        </p>
    </div>
	<div class="pagination typeWhole">
		<?php echo $sPagination;?>
    </div>
    <pre>
    <?php //var_dump($aTest);?>
    </pre>
</div>

</body>
	
	
