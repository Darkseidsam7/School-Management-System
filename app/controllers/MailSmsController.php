<?php

class MailSmsController extends \BaseController {

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
		$return = array();
		$mailsms = mailsms::get()->toArray();
		foreach ($mailsms as $value) {
			$value['messageData'] = htmlspecialchars_decode($value['messageData'],ENT_QUOTES);
			$return[] = $value;
		}
		return $return;
	}

	public function create(){
		$mailsms = new mailsms();
		$mailsms->mailTo = Input::get('userType');
		$mailsms->mailType = Input::get('sendForm');

		$messageData = " ";
		if(Input::get('messageTitle') != ""){
			$messageData .= Input::get('messageTitle');
		}
		if(Input::get('messageContent') != ""){
			$messageData .= htmlspecialchars(Input::get('messageContent'),ENT_QUOTES);
		}
		$mailsms->messageData = $messageData;
		
		$mailsms->messageDate = date("F j, Y, g:i a");
		$mailsms->messageSender = $this->data['users']->fullName . " [ " . $this->data['users']->id . " ] ";
		$mailsms->save();

		if(Input::get('userType') == "teachers"){ 
			$sedList = User::where('role','teacher')->get();
		}
		if(Input::get('userType') == "students"){
			if(!Input::get('classId') || Input::get('classId') == "" || Input::get('classId') == "0"){
				$sedList = User::where('role','student')->get();
			}else{
				$sedList = User::where('role','student')->where('studentClass',Input::get('classId'))->get();
			}		
		}
		if(Input::get('userType') == "parents"){
			$sedList = User::where('role','parent')->get();
		}
		
		$SmsHandler = new MailSmsHandler();

		if(Input::get('sendForm') == "email"){
			foreach ($sedList as $user) {
				$SmsHandler->mail($user->email,Input::get('messageTitle'),Input::get('messageContent'),$user->fullName);  
			}
		}

		if(Input::get('sendForm') == "sms"){
			foreach ($sedList as $user) {
				if($user->mobileNo != ""){
					$SmsHandler->sms($user->mobileNo,strip_tags(Input::get('messageContent')));
				}
			}
		}

		return $this->listAll();
		exit;
	}

	public function settings(){
		$toReturn = array();
		$toReturn['sms'] = json_decode($this->panelInit->settingsArray['smsProvider']);
		$toReturn['mail'] = json_decode($this->panelInit->settingsArray['mailProvider']);
		return $toReturn;
		exit;
	}

	public function settingsSave(){
		if(Input::get('mailProvider')){
			$settings = settings::where('fieldName','mailProvider')->first();
			$settings->fieldValue = json_encode(Input::all());
			$settings->save();
		}else{
			$settings = settings::where('fieldName','smsProvider')->first();
			$settings->fieldValue = json_encode(Input::all());
			$settings->save();
		}
		echo "1";
		exit;
	}
}