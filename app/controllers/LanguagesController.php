<?php

class LanguagesController extends \BaseController {

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

	
	public function listAll()
	{
		return languages::get();
	}

	public function delete($id){
		languages::find($id)->delete();	
		return 1;
	}

	public function create(){
		$languages = new languages();
		$languages->languageTitle = Input::get('languageTitle');
		$languages->isRTL = Input::get('isRTL');
		$languages->languagePhrases = json_encode(Input::get('languagePhrases'));
		$languages->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addLanguage'],"jsMessage"=>$this->panelInit->language['langCreated'],"languages"=>languages::get()->toArray() ));
	}

	function fetch($id){
		$languages = languages::where('id',$id)->first()->toArray();
		$languages['languagePhrases'] = json_decode($languages['languagePhrases'],true);
		return $languages;
	}

	function edit($id){
		$languages = languages::find($id);
		$languages->languageTitle = Input::get('languageTitle');
		$languages->isRTL = Input::get('isRTL');
		$languages->languagePhrases = json_encode(Input::get('languagePhrases'));
		$languages->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editLanguage'],"jsMessage"=>$this->panelInit->language['langModified'],"languages"=>languages::get()->toArray() ));
	}
}