<?php

/*include common class */
require_once('lib/Common.php');
require_once('lib/DB.php');

/*
 * controller for multiple deletion of banner events
 * */

class adminDeleteExec extends Controller_AdminExec
{
	/*class construct*/
	protected function run($aArgs)
	{
		if($this->doDeleteEvent($aArgs) == true){
			$this->writeJS('alert("Deleted successfully");');
			$this->writeJS('location.href="[link=admin/index]";');
		}else{
			$this->writeJS('alert("error");');
		}

	}
	
	/*
	 * will get the id sequence of events to delete via $_GET($aArgs)
	 * explode array and loop through each element and unlink images
	 * 
	 * */
	private function doDeleteEvent($aArgs){
		$aSeqs = explode( ",",$aArgs['seqs']);
		$bResult = true;

		foreach($aSeqs as $k=>$v){
			
			$aBannerItem = DB::select(libKey::BA_KEY,$v);
			
			/*remove title image*/
			if($aBannerItem['option'] == 'upload'){
				if(isset($aBannerItem['banner_event']['img_path']) && isset($aBannerItem['banner_event']['img_name']) ){
					$sImagePathName = $aBannerItem['banner_event']['img_path'] . $aBannerItem['banner_event']['img_name'];
					Common::removeImage($sImagePathName);
				}
			}
			
			/*remove dot image*/
			$sImagePathName = $aBannerItem['banner_dotimage']["enabled"]['img_path'] . $aBannerItem['banner_dotimage']["enabled"]['img_name'];
			Common::removeImage($sImagePathName);
			
			$sImagePathName = $aBannerItem['banner_dotimage']["disabled"]['img_path'] . $aBannerItem['banner_dotimage']["disabled"]['img_name'];
			Common::removeImage($sImagePathName);
			
			
			/*remove banner image*/
			foreach($aBannerItem['banner_image'] as $ki=>$vi){
				$sImagePathName = $vi['img_path'] . $vi['img_name'];
				Common::removeImage($sImagePathName);
			}
			
			$bResult = DB::delete(libKey::BA_KEY,$v);
		}
		
		return $bResult;
	}
	
}