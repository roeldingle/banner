<?php
require_once('lib/Common.php');
require_once('lib/DB.php');

class adminRegisterExec extends Controller_AdminExec
{
	private $aFile;
	
	protected function run($aArgs){
		
		$this->aFile = $this->Upload->uploadedFiles();
		
		$bResult = $this->addBannerEvent($aArgs);
		
		if($bResult == true){
			$this->writeJS('alert("Registered successfully!");');
			$this->writeJS('location.href="[link=admin/index]";');
		}else{
			$this->writeJS('alert("Error saving.");');
			$this->writeJS('location.href="[link=admin/register]";');
			exit;
		}
	}
	
	
	private function addBannerEvent($aArgs){
		
		/*require data*/
		$aData['seq'] = $this->Redis->incr( libKey::BA_KEY_SEQ );
		$aData['active'] = '1';
		$aData['datereg'] = time();
		$aData['option'] = $aArgs['banner_radio'];
		
		if($aArgs['banner_radio'] == 'upload'){
			
			$aEventTitleImage = $this->aFile['banner_title_file'];
			
			$aImgInfo = Common::uploadImage($aEventTitleImage,true);
			
			if($aImgInfo != false){
				
				$aData['banner_event'] = array(
						'img_path' => $aImgInfo['upload_path'],
						'img_name' => $aImgInfo['upload_name'],
						'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_title_realname'] : ''
				);
			}else{
				$this->writeJS('alert("Error uploading title image file.");');
				$this->writeJS('location.href="[link=admin/register]";');
				exit;
			}
				
		}else{
			/*validate*/
			$aData['banner_event'] = array(
					'title' => (is_string($aArgs['banner_title']) && $aArgs['banner_title'] != '') ? htmlspecialchars(trim($aArgs['banner_title'])) : false,
					'width' => (is_string($aArgs['banner_width']) && $aArgs['banner_width'] != '') ? htmlspecialchars(trim($aArgs['banner_width'])) : false,
					'height' => (is_string($aArgs['banner_height']) && $aArgs['banner_height'] != '') ? htmlspecialchars(trim($aArgs['banner_height'])) : false,
					'ftcolor' => (is_string($aArgs['banner_ftcolor']) && $aArgs['banner_ftcolor'] != '') ? htmlspecialchars(trim($aArgs['banner_ftcolor'])) : false,
					'bgcolor' => (is_string($aArgs['banner_bgcolor']) && $aArgs['banner_bgcolor'] != '') ? htmlspecialchars(trim($aArgs['banner_bgcolor'])) : false
			);
			
			/*validate*/
			foreach($aData['banner_event'] as $k=>$v){
				if($v[$key] === false){
					$this->writeJS('alert("Invalid data ('.$key.').");');
					$this->writeJS('location.href="[link=admin/register]";');
					exit;
				}
			}
		}
		
		
		
		$aData['banner_dotimage'] = $this->addBannerDotImages($aArgs);
		$aData['banner_image'] = $this->addBannerImages($aArgs);
		
		return DB::insert(libKey::BA_KEY,$aData);
		
	}
	
	private function addBannerDotImages($aArgs){
	
		$aDotImageFile = array('enabled','disabled');
	
		foreach($aDotImageFile as $key=>$val){
				
			/*dot enabled image*/
			$aEventDotImage = $this->aFile['banner_dotimage_'.$val.'_file'];
			$aImgInfo = Common::uploadImage($aEventDotImage,true);
			
				
			if($aImgInfo != false){
				$aData[$val] =
				array(
						'img_path' => $aImgInfo['upload_path'],
						'img_name' => $aImgInfo['upload_name'],
						'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_dotimage_'.$val.'_realname'] : ''
				);
			}else{
				$aData[$val] = 0;
			}
		}
	
		return $aData;
	}
	
	private function addBannerImages($aArgs){
		
		$iBannerImageLimit = 5;
		
		for($i = 1;$i <= $iBannerImageLimit; $i++){
			
			$aEventImage = $this->aFile['banner_image_file_'.$i];
			$aImgInfo = Common::uploadImage($aEventImage,true);
			
			if($aImgInfo != false){
				
				$aData[($i-1)] =
					array(
							'img_path' => $aImgInfo['upload_path'],
							'img_name' => $aImgInfo['upload_name'],
							'img_realname' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_image_realname_'.$i] : '',
							'img_url' => ($aImgInfo['upload_path'] && $aImgInfo['upload_name'] ) ? $aArgs['banner_image_url_'.$i] : ''
					);
			}else{
				$aData[($i-1)] = 0;
			}
			
		}
		return $aData;
	}
	
	
}
