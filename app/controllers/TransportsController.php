<?php

class TransportsController extends \BaseController {

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
		return transportation::get();
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		transportation::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$transportation = new transportation();
		$transportation->transportTitle = Input::get('transportTitle');
		$transportation->transportDescription = Input::get('transportDescription');
		$transportation->transportDriverContact = Input::get('transportDriverContact');
		$transportation->transportFare = Input::get('transportFare');
		$transportation->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addTransport'],"jsMessage"=>$this->panelInit->language['transportCreated'],"transportation"=>transportation::get()->toArray() ));
	}

	function fetch($id){
		return transportation::where('id',$id)->first();
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$transportation = transportation::find($id);
		$transportation->transportTitle = Input::get('transportTitle');
		$transportation->transportDescription = Input::get('transportDescription');
		$transportation->transportDriverContact = Input::get('transportDriverContact');
		$transportation->transportFare = Input::get('transportFare');
		$transportation->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editTransport'],"jsMessage"=>$this->panelInit->language['transportUpdated'],"transportation"=>transportation::get()->toArray() ));
	}

	function fetchSubs($id){
		return User::where('activated','1')->where('transport',$id)->get()->toArray();
	}
}