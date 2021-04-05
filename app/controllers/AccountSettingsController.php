<?php

class AccountSettingsController extends \BaseController {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';
	
	public function __construct(){
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = \Auth::user();
	}
	
	public function index($method = "main")
	{
		$this->panelInit->viewop($this->layout,'languages',$this->data);
	}

	
	public function listAll()
	{
		$data = User::where('id',Auth::user()->id)->first()->toArray();
		$data['birthday'] = date('m/d/Y',$data['birthday']);
		return $data;
	}

	public function langs()
	{
		$settingsArray = array(); 

		$languages = languages::get();
		foreach ($languages as $language) {
			$settingsArray['languages'][$language->id] = $language->languageTitle;
		}

		$settingsArray['languageAllow'] = $this->panelInit->settingsArray['languageAllow'];

		return $settingsArray;
	}

	function saveProfile(){
		$User = User::where('id',Auth::user()->id)->first();
		$User->fullName = Input::get('fullName');
		$User->gender = Input::get('gender');
		$User->address = Input::get('address');
		$User->phoneNo = Input::get('phoneNo');
		$User->mobileNo = Input::get('mobileNo');
		$User->defLang = Input::get('defLang');
		if(Input::get('birthday') != ""){
			$birthday = explode("/", Input::get('birthday'));
			$birthday = mktime(0,0,0,$birthday['0'],$birthday['1'],$birthday['2']);
			$User->birthday = $birthday;
		}
		if (Input::hasFile('photo')) {
			$fileInstance = Input::file('photo');
			$newFileName = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
			$file = $fileInstance->move('uploads/profile/',$newFileName);

			$User->photo = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
		}
		$User->save();

		$data = User::where('id',Auth::user()->id)->first()->toArray();
		$data['birthday'] = date('m/d/Y',$data['birthday']);
		return json_encode($data);
	}

	function saveEmail(){
		if(User::where('email',Input::get('email'))->count() > 0){
			echo $this->panelInit->language['mailAlreadyUsed'];
			exit;
		}
		$User = User::where('id',Auth::user()->id)->first();
		$User->email = Input::get('email');
		$User->save();
		echo "1";
		exit;
	}

	function savePassword(){
		if (Hash::check(Input::get('password'), $this->data['users']->password)) {
			$User = User::where('id',Auth::user()->id)->first();
			$User->password = Hash::make(Input::get('newPassword'));
			$User->save();
			return json_encode(array("jsTitle"=>$this->panelInit->language['editPassword'],"jsMessage"=>$this->panelInit->language['pwdChangedSuccess'] ));
		}else{
			echo $this->panelInit->language['oldPwdDontMatch'];
			exit;
		}
		exit;
	}
	
}