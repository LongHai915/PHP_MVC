<?php 
class Loader{
	// Load Library classes
	public function library($lib){
		include_once LIB_PATH."$lib.class.php";
	}

	public function helper($helper){
		include HELPER_PATH."{$helper}_helper.php";
	}
}
