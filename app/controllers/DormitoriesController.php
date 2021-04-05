<?php

class DormitoriesController extends \BaseController {

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
		return dormitories::get();
	}

	public function delete($id){
		dormitories::find($id)->delete();	
		return 1;
	}

	public function create(){
		$dormitories = new dormitories();
		$dormitories->dormitory = Input::get('dormitory');
		$dormitories->dormDesc = Input::get('dormDesc');
		$dormitories->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addDormitories'],"jsMessage"=>$this->panelInit->language['dormCreated'],"dormitories"=>dormitories::get()->toArray() ));
	}

	function fetch($id){
		return dormitories::where('id',$id)->first();
	}

	function edit($id){
		$dormitories = dormitories::find($id);
		$dormitories->dormitory = Input::get('dormitory');
		$dormitories->dormDesc = Input::get('dormDesc');
		$dormitories->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editDorm'],"jsMessage"=>$this->panelInit->language['dormUpdated'],"dormitories"=>dormitories::get()->toArray() ));
	}
}