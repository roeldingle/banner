<?php

/*include common class */
require_once('lib/DB.php');
require_once('lib/Common.php');

/* controller for uploading images via iframe*/
class adminImage extends Controller_Admin
{
	/*set class variable*/
	private $aFile;
	
	/*class construct*/
    protected function run($aArgs){
    	
    	$this->aFile = $this->Upload->uploadedFiles();
    	$bResult = $this->handleImage($aArgs);
    	
    	
    	/*must be set last*/
    	$this->initTemplate();
    	$this->setView();
    }
    
    /*template getter*/
    private function initTemplate(){
    	$this->importJS('libs/jquery.validate.mod');
    	$this->importJS('libs/common');
    	
    	$this->importJS('image');
    	$this->importCSS('eventbanner');
    	$this->importCSS('image');
    	
    }
    
    /*template setter*/
    private function setView(){
    	$bView = $this->View();
    	if ($bView!==false) {
    		$this->setStatusCode('200');
    	}
    }
    
    /*
     * will upload images in a temp folder 
     * and give necessary data from self(iframe) to its parent document
     * 
     * */
    private function handleImage($aArgs){
    	
    		$aImgInfo = Common::uploadImage($this->aFile['frame_img_file'],true);
    		
    		if(!isset($aImgInfo['upload_path']) || !isset($aImgInfo['upload_name']) ){
    			$aImage = '[IMG]/img_preview.png';
    			$this->writeJS('
		    	var elem_iframe = parent.$(parent.document.activeElement);
		    	elem_iframe.parent().children("div.frame_img_mess").show();
		    	');
    		}else{
    			$aImage = '[file='.$aImgInfo['upload_path'].$aImgInfo['upload_name'].']';
    			$this->writeJS('
		    	var elem_iframe = parent.$(parent.document.activeElement);
		    	elem_iframe.parent().children("div.frame_img_mess").hide();
		    	');
    		}
    		 
    		$this->writeJS('
		    	var elem_iframe = parent.$(parent.document.activeElement);
		    	elem_iframe.parent().children("img.frame_img_preview").attr("src","'.$aImage.'");
		    	elem_iframe.parent().children("input.frame_img_info").val("[file='.$aImgInfo['upload_path'].$aImgInfo['upload_name'].']|'.$aImgInfo['upload_path'].'|'.$aImgInfo['upload_name'].'");
		    	');
    		
    		$this->assign('aData',$aImgInfo);
    		
    }
    
    
}
