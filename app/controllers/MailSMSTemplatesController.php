<?php

class MailSMSTemplatesController extends \BaseController {

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
		return mailsmsTemplates::get();
	}

	function fetch($id){
		return mailsmsTemplates::where('id',$id)->first();
	}

	function edit($id){
		$mailsmsTemplates = mailsmsTemplates::find($id);
		$mailsmsTemplates->templateMail = Input::get('templateMail');
		$mailsmsTemplates->templateSMS = Input::get('templateSMS');
		$mailsmsTemplates->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editTemplate'],"jsMessage"=>$this->panelInit->language['templateUpdated'] ));
	}
}