<?php
require_once('lib/Common.php');
require_once('lib/DB.php');

class apiClass extends Controller_Api
{
	protected function get($aArgs)
	{
		$sProcess = $aArgs['process'];
		$this->$sProcess($aArgs);
		
	}
	
	protected function changeStatus($aArgs){
	
		if(isset($aArgs['seq_id'])){
			
			$aBannerItem = DB::select(libKey::BA_KEY,$aArgs['seq_id']);
			
			if($aArgs['active'] == 1){
				$aBannerItem['active'] = 0;
			}else{
				$aBannerItem['active'] = 1;
			}
			
			$bModifyConfirm = DB::update(libKey::BA_KEY,$aArgs['seq_id'],$aBannerItem);
			
			return $bModifyConfirm;
		}
	
	}

}