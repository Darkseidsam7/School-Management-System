<?php

class PollsController extends \BaseController {

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
		return polls::get();
	}

	public function delete($id){
		polls::find($id)->delete();	
		return 1;
	}

	public function create(){
		$polls = new polls();
		$polls->pollTitle = Input::get('pollTitle');
		$polls->pollOptions = json_encode(Input::get('pollOptions'));
		$polls->pollTarget = Input::get('pollTarget');
		$polls->pollStatus = '0';
		$polls->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addPoll'],"jsMessage"=>$this->panelInit->language['pollCreated'],"polls"=>polls::get()->toArray() ));
	}

	function fetch($id){
		$polls = polls::where('id',$id)->first();
		$polls->pollOptions = json_decode($polls->pollOptions,true);
		return $polls;
	}

	function makeActive($id){
		$polls = polls::where('pollStatus','1')->update(array('pollStatus' => '0'));

		$polls = polls::where('id',$id)->first();
		$polls->pollStatus = 1;
		$polls->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['activatePoll'],"jsMessage"=>$this->panelInit->language['pollActivated'],"polls"=>polls::get()->toArray() ));
	}

	function edit($id){
		$polls = polls::find($id);
		$polls->pollTitle = Input::get('pollTitle');
		$polls->pollOptions = json_encode(Input::get('pollOptions'));
		$polls->pollTarget = Input::get('pollTarget');
		$polls->pollStatus = Input::get('pollStatus');
		$polls->save();
		return json_encode(array("jsTitle"=>['editPoll'],"jsMessage"=>$this->panelInit->language['pollUpdated'],"polls"=>polls::get()->toArray() ));
	}
}