<?php
require_once('lib/Common.php');
require_once('lib/DB.php');
class frontDisplay extends Controller_Front
{
	protected function run($args)
	{
		$this->initTemplate();
		$this->setStatusCode('200');
		$iSeq = $this->getSequence();
		$aData = $this->getData($iSeq);
		
		$this->assign('Banner_event', $this->makeData(  $aData ) );
	}
	private function initTemplate()
	{
		//$this->importCSS('front');
		$this->importJS('libs/carousel');
	}
	private function getData($iSeq)
	{
		$libKey = libKey::BA_KEY;
		$aData = DB::select($libKey,$iSeq);
		return $aData;
	}
	private function makeData( $aData )
	{
		$sData = '';
		if($aData['active'] == 1){
			//$sData .= '<div class="eventbanner_box" >';#main div
            
            /*bullets*/	
			/*dot image paths*/
			$sDotImageEnabledPathName = $aData['banner_dotimage']['enabled']['img_path'].$aData['banner_dotimage']['enabled']['img_name'];
			$sDotImageDisabledPathName = $aData['banner_dotimage']['disabled']['img_path'].$aData['banner_dotimage']['disabled']['img_name'];
			
			/*dot image class for image background*/
			$this->writeCSS('.disabled_'.$aData['seq'].'{background:url([pfile='.str_replace('public_files/','',$aData['banner_dotimage']['disabled']['img_path']).$aData['banner_dotimage']['disabled']['img_name'] .']) no-repeat !important}');
			$this->writeCSS('.enabled_'.$aData['seq'].'{background:url([pfile='.str_replace('public_files/','',$aData['banner_dotimage']['enabled']['img_path']).$aData['banner_dotimage']['enabled']['img_name'] .']) no-repeat !important}');
			
			/*dot image class for image size*/
			$aImageSizeDisabled =  $this->Storage->getimagesize($sDotImageDisabledPathName );
			$aImageSizeEnabled =  $this->Storage->getimagesize($sDotImageEnabledPathName );
			$this->writeCSS('.disabled_'.$aData['seq'].' {width:'.$aImageSizeDisabled[0].'px;height:'.$aImageSizeDisabled[1].'px;}');
			$this->writeCSS('.enabled_'.$aData['seq'].' {width:'.$aImageSizeEnabled[0].'px;height:'.$aImageSizeEnabled[1].'px;}');
			
			/*event title*/
			if(isset($aData['banner_event']['img_path']) && isset($aData['banner_event']['img_name'])){
				
				$aImageSize =  $this->Storage->getimagesize($aData['banner_event']['img_path'].$aData['banner_event']['img_name'] );
				$sData .= '<div class="eventbanner_titlebox eventbanner_titlebox_'.$aData['seq'].'" style="width:'.$aImageSize[0].'px;height:'.$aImageSize[1].'px;"  >';#top div
				$sData .= '<img src="[pfile='.str_replace('public_files/','',$aData['banner_event']['img_path']).$aData['banner_event']['img_name'].']" />';#top div
				
				$iCssSliderTopHeight = ((int)$aImageSize[1]/2)-($aImageSizeDisabled[1]/2);
                $iCssSliderTopHeight = 'style="margin-top:'.$iCssSliderTopHeight.'px;"';
			}else{
				$iCssSliderTopHeight = ((int)$aData['banner_event']['height']/2)-($aImageSizeDisabled[1]/2);
                $iCssSliderTopHeight = 'style="margin-top:'.$iCssSliderTopHeight.'px;"';
                
				$sData .= '<div class="eventbanner_titlebox eventbanner_titlebox_'.$aData['seq'].'" style="width:'.$aData['banner_event']['width'].'px;';#top div
				$sData .= 'height:'.$aData['banner_event']['height'].'px;';
				$sData .= 'color:#'.$aData['banner_event']['ftcolor'].';';
				$sData .= 'background-color:#'.$aData['banner_event']['bgcolor'];
				$sData .= '" >';
				$sData .= '<strong class="eventbanner_title" '.$iCssSliderTopHeight.' >'.$aData['banner_event']['title'].'</strong>';
				
				 
			}
			
			
			
			
			$sData .= '<div class="slider_bullet" '.$iCssSliderTopHeight.'" >';#bullet div
			$sData .= '<ul>';
			
			foreach($aData['banner_image'] as $key=>$val){
				if($val != 0){
					$sCurrentBullet = ($key == 0) ? 'enabled_'.$aData['seq'] : 'disabled_'.$aData['seq'];
					$sData .= '<li><a href="#" class="'.$sCurrentBullet.' bullets_'.$aData['seq'].'" ><span>1</span></a></li>';
				}
				
			}
			
			$sData .= '</ul>';
			$sData .= '</div>';#end bullet div
			
			
			$sData .= '</div>';#end top div
			
			$sData .= '<div class="banner_event_images_'.$aData['seq'].'">';
			$sData .= '<ul class="image_slides">';#ul images
			
				foreach($aData['banner_image'] as $key=>$val){
					
					if($val != 0){
						$aImageBannerSize =  $this->Storage->getimagesize($val['img_path'].$val['img_name'] );
						
						$sData .= '<li>';
						$sData .= '<a href="http://'.$val['img_url'].'" target="_blank" >';
						$sData .= '<img src="[pfile='.str_replace('public_files/','',$val['img_path'].$val['img_name']).']" style="';
						
						
						if(!isset($aData['banner_event']['img_path']) && !isset($aData['banner_event']['img_name'])){
							$sData .= 'width:'.$aData['banner_event']['width'].'px;';
						}else{
							$sData .= 'width:'.$aImageSize[0].'px;';
							
						}
						
						$sData .= 'height:'.$aImageBannerSize[1].'px;';
						
						$sData .= '" />';
						
						$sData .= '</a>';
						$sData .= '</li>';
					}
				}
			
			$sData .= '</ul>';#end ul images
			$sData .= '</div>';#end top div
			
			//$sData .= '</div>';#end main div
			
		}
		
		$aJsData['seq']  = $aData['seq'];
		$aJsData['slidertop']  = $iCssSliderTopHeight;
		$this->importJS('front',$aJsData);
		
		return $sData;
		
	}
}
