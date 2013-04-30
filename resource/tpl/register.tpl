<div class="content">
<form name="bannerManageForm" id="bannerManageForm" action="[link=admin/RegisterExec]" enctype="multipart/form-data">
<div class="section">
    <div class="mTitle">
        <h2>Create New Event</h2>
		<p>- The width of the banner images in an event is automatically resized to fit the width of the title bg image.</p>
    </div>
	<div class="mTitle">
        <h3>Set Event Title</h3>
		<p>- The event title is displayed at the top of the banner images.</p>
		<p class="fr"><span class="required">*</span> Required field</p>
    </div>
	
    <div class="mBoard type1">
        <table border="1" summary="" class="eTr">
			<colgroup>
				<col width="150px" />
				<col width="*"/>
			</colgroup>
			<tbody>
				<tr>
					<td class="bggrey">Title and BG image<span class="required">*</span></td>
					<td>
						<div class="container mb10 fl" >
							<div class="holder"><input class="mr5" name="banner_radio" value="upload" checked  type="radio" />File Upload</div>
							<div class="holder"><input  class="mr5" name="banner_radio" value="manual" type="radio" />Manual Setting</div>
						</div>
						
						<div class="banner_upload-option banner_option" >
							<div class="container mb10 fl" >
							
							<input type="text"  name="banner_title_realname"  class="inputbtntitle bggrey" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
							<div class="inputbrowse">
				    			<input type="file" class="file" name="banner_title_file" />
				    			Browse...
				    		</div>
				    		
							<a class="btndelcreate btnDelFile ml10" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
							</div>
							<p class="grey">- Max. image file size : 2 MB</p>
							<div class="container mt20 pb50 fl"><img src="[IMG]/app/u331_normal.png" alt="Image Size" /></div>
						</div>
						
						<div class="banner_manual-option banner_option">
							<div class="container mt20 mb10 fl">
								<span class="fl w100">Event Title:</span>
								<input type="text"  name="banner_title" class="inputbtn" validate="required" maxlength="50" />
							</div>
							
							
							<div class="container mb10 fl">
								<span class="fl w100">Title BG Size:</span>
								<div class="holder"><span class="fl w75">Width (px)</span><input type="text"  name="banner_width" class="inputbtn w50 mr10" validate="required|digits" /></div>
							</div>
							<div class="container mb10 fl">
								<span class="fl w100">&nbsp;</span>
								<div class="holder"><span class="fl w75">Height (px)</span><input type="text"  name="banner_height" class="inputbtn w50 mr10" validate="required|digits" /></div>
							</div>
							<div class="container mb10 pb5 fl">
								<div class="holder"><span class="fl w100">Font Color:</span><input type="text"  name="banner_ftcolor" id="banner_ftcolor" value="ffffff" class="inputbtn w75 bgwhite fontblack" readonly validate="required"  /></div>
							</div>
							<div class="container mb10 pb50 fl">
								<div class="holder"><span class="fl w100">BG Color:</span><input type="text"  name="banner_bgcolor" id="banner_bgcolor" value="000000" class="inputbtn w75 fontwhite bgblack" readonly validate="required"  /></div>
							</div>
							
						</div>
						
						
					</td>
				</tr>
				
				<tr class="dot">
					<td class="bggrey">Dot image<span class="required">*</span></td>
					<td>
						<div class="container mb10 fl">
							<span class="fl w100">Enabled</span>
							<input type="text"  name="banner_dotimage_enabled_realname"  class="inputdotimage bggrey" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
							<div class="inputbrowse">
				    			<input type="file" class="file" name="banner_dotimage_enabled_file" />
				    			Browse...
				    		</div>
							<a class="btndelcreate ml10 btnDelFile" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
						</div>
						<div class="container mb10 fl">
							<span class="fl w100">Disabled</span>
							<input type="text"  name="banner_dotimage_disabled_realname"  class="inputdotimage bggrey" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
							<div class="inputbrowse">
				    			<input type="file" class="file" name="banner_dotimage_disabled_file" />
				    			Browse...
				    		</div>
							<a class="btndelcreate ml10 btnDelFile" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
						</div>
					</td>
				</tr>
				
		   </tbody>
        </table>
    </div>
    
	<div class="mTitle">
        <h3>Add Banner Image</h3>
		<p>- Up to 5 banner images can be added in an event.</p>
		<p>- The banner images are displayed in the order they are added.</p>
		<p class="fr"><span class="required">*</span> Required field</p>
    </div>
	 <div class="mBoard type1">
	 
	 	 <table border="1" summary="" class="eTr eventbanner">
			<colgroup>
				<col width="150px" />
				<col width="*"/>
			</colgroup>
			<tbody>
			
				<?php echo $sImageHtml;?>
				
		   </tbody>
        </table>
	 
       
		<div class="center mt20">
		 <a href="javascript:;" class="btn_save btnSubmit"><span class="pr25">Save</span></a>
		 <a href="javascript:void(0)" class="btnCancel ml10"><span class="pr20">Cancel</span></a></div>
    </div>
</div>
</form>
</div>
