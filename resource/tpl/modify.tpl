
<?php 
	/* array shortener*/
	$BA_SEQ = $aBannerData['seq'];
	$BA_DOTIMAGE = $aBannerData['banner_dotimage'];
	$BA_EVENT = $aBannerData['banner_event'];
	$BA_IMAGE = $aBannerData['banner_image'];
?>

<div class="content">
	<form name="bannerManageForm" id="bannerManageForm" action="[link=ModifyExec]" enctype="multipart/form-data"  >
	<input name="banner_modify_seq" type="hidden" value="<?php echo $BA_SEQ;?>"  />
			
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
				
					<!-- Event title -->
					<tr>
						<td class="bggrey">Title and BG image<span class="required">*</span></td>
						<td>
							<div class="container mb10 fl" >
								<div class="holder"><input class="mr5" name="banner_radio" value="upload" <?php echo ($aBannerData['option']  === 'upload') ? 'checked' : '';?>  type="radio" />File Upload</div>
								<div class="holder"><input  class="mr5" name="banner_radio" value="manual" type="radio" <?php echo ($aBannerData['option'] === 'manual') ? 'checked' : '';?> />Manual Setting</div>
							</div>
							
							<!-- Event title (upload option) -->
							<div class="banner_upload-option banner_option" >
								<div class="container mb10 fl" >
								<input type="text"  name="banner_title_realname" value="<?php echo $BA_EVENT['img_realname'];?>" class="inputbtntitle bggrey" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
								<div class="inputbrowse">
					    			<input type="file" class="file" name="banner_title_file" />
					    			Browse...
					    		</div>
					    		
								<a class="btndelcreate btnDelFile ml10" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
								</div>
								<p class="grey">- Max. image file size : 2 MB</p>
								<div class="container mt20 pb50 fl">
								
									<?php if(isset($BA_EVENT['img_path']) && isset($BA_EVENT['img_name'])){?>
										<input type="hidden" name="banner_modify_title_img_path" value="<?php echo $BA_EVENT['img_path'];?>" />
										<input type="hidden" name="banner_modify_title_img_name" value="<?php echo $BA_EVENT['img_name'];?>" />
										<img src="[file=<?php echo $BA_EVENT['img_path'].$BA_EVENT['img_name'];?>]" class="frame_img_preview fl" height="50px"  />&nbsp;&nbsp;
									<?php }else{ ?>
										<img src="[IMG]/app/u331_normal.png" class="frame_img_preview fl"  />&nbsp;&nbsp;
									<?php } ?>
								
								</div>
							</div>
							<!--end Event title (upload option) -->
							
							<!-- Event title (manual option) -->
							<div class="banner_manual-option banner_option">
								<div class="container mt20 mb10 fl">
									<span class="fl w100">Event Title:</span>
									<input type="text"  name="banner_title" class="inputbtn" value="<?php echo $BA_EVENT['title'];?>" validate="required" maxlength="50" />
								</div>
								<div class="container mb10 fl">
									<span class="fl w100">Title BG Size:</span>
									<div class="holder"><span class="fl w75">Width (px)</span><input type="text" value="<?php echo $BA_EVENT['width'];?>" name="banner_width" class="inputbtn w50 mr10" validate="required|digits" /></div>
								</div>
								<div class="container mb10 fl">
									<span class="fl w100">&nbsp;</span>
									<div class="holder"><span class="fl w75">Height (px)</span><input type="text" value="<?php echo $BA_EVENT['height'];?>" name="banner_height" class="inputbtn w50 mr10" validate="required|digits" /></div>
								</div>
								
								<?php 
									$aColorField = array('ftcolor','bgcolor');
									$sDefaultColor = array('ffffff','000000');
									
									foreach($aColorField as $key=>$val){
										if(isset($BA_EVENT[$val])){
											$sFtColor[$val] = $BA_EVENT[$val];
											$sFtColorStyle[$val] = 'style="background:#'.$BA_EVENT[$val].';color:#'.adminModify::color_inverse($BA_EVENT[$val]).'"';
										}else{
											$sFtColor[$val] = $sDefaultColor[$key];
											$sFtColorStyle[$val] = 'style="background:#'.$sDefaultColor[$key].';color:#'.adminModify::color_inverse($sDefaultColor[$key]).'"';
										}
									}
								?>
								<div class="container mb10 pb5 fl">
									<div class="holder">
									<span class="fl w100">Font Color:</span>
										<input type="text" <?php echo $sFtColorStyle['ftcolor'];?> value="<?php echo $sFtColor['ftcolor'];?>"  name="banner_ftcolor" id="banner_ftcolor" readonly validate="required" class="inputbtn w75" />
									 </div>
									
								</div>
								<div class="container mb10 pb50 fl">
									<div class="holder">
									<span class="fl w100">BG Color:</span>
										<input type="text" <?php echo $sFtColorStyle['bgcolor'];?> value="<?php echo $sFtColor['bgcolor'];?>"  name="banner_bgcolor" id="banner_bgcolor" readonly validate="required" class="inputbtn w75" />
									</div>
								</div>
								
							</div>
							<!--end Event title (manual option) -->
							
						</td>
					</tr>
					<!-- end Event title -->
					
					<!-- Dot image -->
					<?php 
					
					$aDotImageFile = array('enabled','disabled');
    				$sImageSize = 200; //static 
    	
			    	foreach($aDotImageFile as $key=>$val){
			    		$sPathName = (isset($BA_DOTIMAGE[$val]['img_path']) && isset($BA_DOTIMAGE[$val]['img_name'])) ? $BA_DOTIMAGE[$val]['img_path'].$BA_DOTIMAGE[$val]['img_name'] : false;
			    		$sTitle = "Dot image ".$val;
			    		$aDotImageHtml[$val] = ($sPathName) ? '<a href="javascript:void(0);" title="'.$sTitle.'/'.$sImageSize.'" alt="[file='.$sPathName.']"  class="preview_img btn btn_search02"><em class="ir icoFind ml10">Search</em></a>' : '';
			    		
			    	}
					
					?>
					<tr>
						<td class="bggrey">Dot image<span class="required">*</span></td>
						<td>
						
							<div class="container mb10 fl">
								<span class="fl w100">Enabled</span>
								<input type="text"  name="banner_dotimage_enabled_realname"  class="inputdotimage bggrey" value="<?php echo $BA_DOTIMAGE['enabled']['img_realname'];?>" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
								<div class="inputbrowse">
					    			<input type="file" class="file" name="banner_dotimage_enabled_file" />
					    			Browse...
					    		</div>
					    			<?php echo $aDotImageHtml['enabled'];?>
						    		
						    		
						    		<input type="hidden" name="banner_modify_dotimage_enabled_img_path" value="<?php echo $BA_DOTIMAGE['enabled']['img_path'];?>" />
						    		<input type="hidden" name="banner_modify_dotimage_enabled_img_name" value="<?php echo $BA_DOTIMAGE['enabled']['img_name'];?>" />
					    		
								<a class="btndelcreate ml10 btnDelFile" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
							</div>
							
							<div class="container mb10 fl">
								<span class="fl w100">Disabled</span>
								<input type="text"  name="banner_dotimage_disabled_realname"  class="inputdotimage bggrey" value="<?php echo $BA_DOTIMAGE['disabled']['img_realname'];?>" readonly validate="required|accept[jpg,png,jpeg,gif,ico]" />
								<div class="inputbrowse">
					    			<input type="file" class="file" name="banner_dotimage_disabled_file" />
					    			Browse...
					    		</div>
					    		
					    		<?php echo $aDotImageHtml['disabled'];?>
						    	
						    		<input type="hidden" name="banner_modify_dotimage_disabled_img_path" value="<?php echo $BA_DOTIMAGE['disabled']['img_path'];?>" />
						    		<input type="hidden" name="banner_modify_dotimage_disabled_img_name" value="<?php echo$BA_DOTIMAGE['disabled']['img_name'];?>" />
					    		
								<a class="btndelcreate ml10 btnDelFile" href="javascript:void(0);"><span><em class="icoDel mr5"></em>Delete</span></a>
							</div>
						</td>
					</tr>
					<!--end Dot image -->
					
					
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
		 	
		 	<!-- Event Images -->
		 	 <table border="1" summary="" class="eTr">
				<colgroup>
					<col width="150px" />
					<col width="*"/>
				</colgroup>
				<tbody>
				
					<?php echo $sImageHtml;?>
					
			   </tbody>
	        </table>
		 	<!--end Event Images -->
	       
	       	<!-- Action buttons -->
			<div class="center mt20">
				 <a href="javascript:;" class="btn_save btnSubmit"><span class="pr25">Save</span></a>
				 <a href="javascript:void(0)" class="btnCancel ml10"><span class="pr20">Cancel</span></a>
			</div>
			<!--end Action buttons -->
			
	    </div>
	</div>
	</form>
</div>
					
					

<pre>
<?php var_dump($aBannerData);?>

</pre>
				
				