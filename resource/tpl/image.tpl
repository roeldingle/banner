<form id="image_preview_form"  name="image_preview_form" action="[link=admin/Image]"  enctype='multipart/form-data' style="height:0;">
	
	<table>
		<tr>
			<td valign="top"  >
				<div class="up_file">
				<input type="hidden" id="file_field"  /> 
					<div class="file_upload file_upload2">
					
						<input type="file" size="24" id="browser_hidden"  name="frame_img_file" onchange="getElementById('file_field').value = getElementById('browser_hidden').value;" >
							
					       <div class="browser_visible"></div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	
</form>
