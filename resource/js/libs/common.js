$(function(){
	
	/*onload events*/
	
	common.radioToggler('banner_radio','banner_option');
	common.fileChange()
	common.fileRemove();
	
	
	/*redirect*/
	$('.btncreate').click(function(){
		var sUrl = "[link=admin/Register]";
		common.redirect(sUrl);
	});
	$('.btnCancel').click(function(){
		var sUrl = "[link=admin/Index]";
		common.redirect(sUrl);
	});
	
	
	/*events*/
	$(".btn_view").live('click', function() {
		common.viewImage(this);
	});
	$(".preview_img").live('click', function() {
		common.preview_img(this);
	});
	
});

var common = {
		
	/*common submit form*/
	submitForm: function(fname,process){
		var self = this;
		/*extra validation*/
		$.each($('form .inputbtn'),function(){
			if($(this).val() !== ''){
				$(this).closest('div').next().find('input.banner_image_url').attr('validate','required|url');
			}else{
				$(this).closest('div').next().find('input.banner_image_url').removeAttr('validate');
			}
		});
		
		var bValid = $('#'+fname).validateForm();
		
		if ( bValid ) {
	        [SDKJS]
	        var fCallback = function(){};
	        Cafe24_SDK_Upload_Submit( $(document.getElementById(fname)), {'callback':fCallback} );
	        return false;
	    }
	},
	
	/*input file event*/
	fileChange: function(){
		$('form input[type=file]').live('change',function(){
			var sRealName = $(this).val();
			sRealName = sRealName.split(/(\\|\/)/g).pop();
			
			/*give data*/
			var elemParent = $(this).parent().parent();
			elemParent.children('input[type=text]').val(sRealName);
			
			/*remove preview*/
			if(elemParent.children('a.preview_title_img').length > 0){
				elemParent.children('a.preview_title_img ').remove();
			}
			
		});
	},
	
	fileRemove: function(){
		
		$(".btnDelFile ").live('click', function() {
			
			/*replace the input file*/
			var targetFileElem = $(this).parent().children('div.inputbrowse'); //target
			var newFileName = targetFileElem.children('input').attr('name'); //get original name
			
			targetFileElem.children('input[type="file"]').remove();
			var sInputFileHtml = '<input type="file" class="file" name="'+newFileName+'" />Browse...'; //replacement html
			targetFileElem.html(sInputFileHtml);
			
			/*remove realname*/
			$(this).parent().children('input[type="text"]').val('');
			
			/*remove preview*/
			if($(this).parent().children('a.preview_title_img').length > 0){
				$(this).parent().children('a.preview_title_img ').remove();
			}
			
			/*remove url*/
			$(this).parent().next('div.container').children('div').children('input[type="text"]').val('');
			
			
		});
	},
		
	
	
	preview_img: function(elem){
		
		var sPathName = $(elem).attr('alt');
		var sTitleData = $(elem).attr('title');
		var aTitleData = sTitleData.split('/');
		
		var content = '<center><img src="'+sPathName+'" /></center>';
		var option = {
			title: aTitleData[0],
		    modal: true,
		    resizable: false,
		    position: "top"
		}
		
		/*safe with image previewing*/
		if(aTitleData[1]){
			option.width = parseInt(aTitleData[1]) + 40;
			common.createDialog(option,content);
		}else{
			var tmpImg = new Image();
			tmpImg.src= sPathName; //or  document.images[i].src;
			$(tmpImg).one('load',function(){
			  orgWidth = tmpImg.width;
			  orgHeight = tmpImg.height;
			  option.width = orgWidth + 40;
			  common.createDialog(option,content);
			});
			
			
		}
		
		
	},
	
	
	/*
	 * @desc = toggle via radio button depending on radio and class(view) instance
	 * @param = (string)sRadioName = radio button name, (string)sClassView = class name of the view element to toggle
	 * @return = (boolean)bReturn = false if no checkbox is checked
	 * @note = radio must have default checked element ex('<input type="radio" name="banner_radio" value="upload" checked />')
	 * 
	 * */
	radioToggler: function(sRadioName, sClassView){
		
		var bReturn = true;
		var radionElem = $('input[name='+sRadioName+']');
		var contentElem = $('.'+sClassView);
		
		if(radionElem.length > 0){
			$(radionElem).each(function(k,v){
				$(this).is(':checked') ? contentElem.eq(k).show().find('input').attr('disabled',false) : contentElem.eq(k).hide().find('input').attr('disabled',true) ;
				
			});
		}else{
			bReturn = false;
		}
		
		return bReturn;
		
	},
	
	colorPicker: function(){
		
		$('#banner_ftcolor,#banner_bgcolor').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				
				$(el).css({
					'color' : common.getTextColor(hex),	
					'background-color' : '#' + hex,		
					'border' : '1px solid gray',
					'font' : '11px Tahoma,sans-serif',
					'text-transform' : 'uppercase'
				});
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			}
		});
		
	},
	
   getTextColor : function(hexcolor){
    	var r = parseInt(hexcolor.substr(0,2),16);
    	var g = parseInt(hexcolor.substr(2,2),16);
    	var b = parseInt(hexcolor.substr(4,2),16);
    	var yiq = ((r*299)+(g*587)+(b*114))/1000;
    	return (yiq >= 128) ? '#000000' : '#FFFFFF';
    },

	createDialog: function(option,content){
		
		$(".dialog_box").remove();
		$('body').append('<div class="dialog_box"  ></div>');
		$('.dialog_box').html(content);
		$( ".dialog_box" ).dialog(option);
	
		
		
	},
	
	/*
	 * @desc = to get the value of input type checkbox
	 * @return = array(value of checked checkebox)
	 * 
	 * */
	getCheckedId: function(){
		var aId = [];
		var checkedRows = $('input[type=checkbox]:checked:not(".check-all")');
		$(checkedRows).each(function() {
			aId.push($(this).val());
	     });
		
		return aId;
	},
	
	/*
	 * @desc = to redirect to selected url
	 * @param = (string)sUrl = url path
	 * 
	 * */
	redirect: function(sUrl){
		window.location.href = sUrl;
	}
		
}