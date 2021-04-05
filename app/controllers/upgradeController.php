<?php

class upgradeController extends \BaseController {

	var $data = array();
	var $panelInit ;
	
	public function __construct(){
		
	}
	
	public function index($method = "main")
	{
		try{
			if(!Schema::hasTable('settings')){
				return Redirect::to('/install');
			}

			if(Schema::hasTable('settings')){
				$testInstalled = settings::where('fieldName','thisVersion')->get();
				if($testInstalled->count() > 0){
					$testInstalled = $testInstalled->first();
					if($testInstalled->fieldValue >= 1.4){
						echo "Already upgraded or at higher version";
						exit;
					}
				}
			}
		}catch(Exception $e){  }

		$this->data['currStep'] = "welcome";
		return View::make('upgrade', $this->data);
	}

	public function proceed()
	{
		if(Input::get('nextStep') == "1"){
			if (filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)) {
				if (!Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'),'activated'=>1,'role'=>'admin')))
				{
					$loginError = false;
				}
			}else{
				if (!Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password'),'activated'=>1,'role'=>'admin')))
				{
					$loginError = false;
				}
			}
			$this->data['currStep'] = "welcome";
			if(!isset($loginError)) {
				$this->data['currStep'] = "1";
				$this->data['nextStep'] = "2";

				$testData = uniqid();

				@file_put_contents("uploads/assignments/test", $testData);
				@file_put_contents("uploads/books/test", $testData);
				@file_put_contents("uploads/cache/test", $testData);
				@file_put_contents("uploads/media/test", $testData);
				@file_put_contents("uploads/profile/test", $testData);

				@file_put_contents("app/storage/cache/test", $testData);
				@file_put_contents("app/storage/logs/test", $testData);
				@file_put_contents("app/storage/meta/test", $testData);
				@file_put_contents("app/storage/sessions/test", $testData);
				@file_put_contents("app/storage/views/test", $testData);
				
				if(@file_get_contents("uploads/assignments/test") != $testData){
					$this->data['perrors'][] = "uploads/assignments";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "uploads/assignments";
				}
				
				if(@file_get_contents("uploads/books/test") != $testData){
					$this->data['perrors'][] = "uploads/books";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "uploads/books";
				}

				if(@file_get_contents("uploads/cache/test") != $testData){
					$this->data['perrors'][] = "uploads/cache";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "uploads/cache";
				}

				if(@file_get_contents("uploads/media/test") != $testData){
					$this->data['perrors'][] = "uploads/media";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "uploads/media";
				}
				
				if(@file_get_contents("uploads/profile/test") != $testData){
					$this->data['perrors'][] = "uploads/profile";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "uploads/profile";
				}
				
				if(@file_get_contents("app/storage/cache/test") != $testData){
					$this->data['perrors'][] = "app/storage/cache";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "app/storage/cache";
				}
				
				if(@file_get_contents("app/storage/logs/test") != $testData){
					$this->data['perrors'][] = "app/storage/logs";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "app/storage/logs";
				}
				
				if(@file_get_contents("app/storage/meta/test") != $testData){
					$this->data['perrors'][] = "app/storage/meta";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "app/storage/meta";
				}
				
				if(@file_get_contents("app/storage/sessions/test") != $testData){
					$this->data['perrors'][] = "app/storage/sessions";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "app/storage/sessions";
				}
				
				if(@file_get_contents("app/storage/views/test") != $testData){
					$this->data['perrors'][] = "app/storage/views";
					$this->data['nextStep'] = "1";
				}else{
					$this->data['success'][] = "app/storage/views";
				}
			}
		}

		if(Input::get('nextStep') == "2"){
			$this->data['currStep'] = "2";
			$this->data['nextStep'] = "3";

			$testInstalled = settings::where('fieldName','thisVersion')->first();
			if($testInstalled->fieldValue == "1.2" || $testInstalled->fieldValue == "1.3"){
				//Upgrade from first version to 1.4
				DB::unprepared(file_get_contents('app/storage/dbsqlUp14'));
				$settings = settings::where('fieldName','thisVersion')->first();
				$settings->fieldValue = '1.4';
				$settings->save();
			}
		}

		if(Input::get('nextStep') == "3"){
			$this->data['currStep'] = "3";
			
			$settings = settings::where('fieldName','thisVersion')->first();
			$settings->fieldValue = '1.4';
			$settings->save();
		}

		return View::make('upgrade', $this->data);
	}

}