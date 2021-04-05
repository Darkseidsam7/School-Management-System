<?php

class SiteSettingsController extends \BaseController {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';
	
	public function __construct(){
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = \Auth::user();
		if($this->data['users']->role != "admin") exit;
	}
	
	public function index($method = "main")
	{
		$this->panelInit->viewop($this->layout,'languages',$this->data);
	}

	
	public function listAll($title)
	{
		if($title == "siteSettings"){
			$settingsArray = array(); 

			$languages = languages::get();
			foreach ($languages as $language) {
				$settingsArray['languages'][$language->id] = $language->languageTitle;
			}

			$settings = settings::get();
			foreach ($settings as $setting) {
				$settingsArray['settings'][$setting->fieldName] = $setting->fieldValue;
			}
			$settingsArray['settings']['activatedModules'] = json_decode($settingsArray['settings']['activatedModules'],true);
			if(!is_array($settingsArray['settings']['activatedModules'])){
				$settingsArray['settings']['activatedModules'] = array();
			}
			return $settingsArray;
		}
		if($title == "terms"){
			$settings = settings::where('fieldName','schoolTerms')->first()->toArray();
			$settings['fieldValue'] = htmlspecialchars_decode($settings['fieldValue'],ENT_QUOTES);
			return $settings;
		}
		
	}

	public function langs()
	{
		
		$settingsArray = array(); 

		$languages = languages::get();
		foreach ($languages as $language) {
			$settingsArray['languages'][$language->id] = $language->languageTitle;
		}
		return $settingsArray;
		
	}

	public function save($title){
		if($title == "siteSettings"){
			$settingsData = Input::All();
			while (list($key, $value) = each($settingsData)) {

				$settings = settings::where('fieldName',$key)->first();
				if($key == "activatedModules"){
					$settings->fieldValue = json_encode($value);
				}else{
					$settings->fieldValue = $value;
				}
				$settings->save();

			}
			echo "1";
			exit;
		}
		if($title == "terms"){
			$settings = settings::where('fieldName','schoolTerms')->first();
			$settings->fieldValue = htmlspecialchars(Input::get('fieldValue'),ENT_QUOTES);
			$settings->save();
			echo "1";
			exit;
		}
	}
}