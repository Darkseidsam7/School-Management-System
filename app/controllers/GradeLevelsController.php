<?php

class GradeLevelsController extends \BaseController {

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
		return gradeLevels::get();
	}

	public function delete($id){
		gradeLevels::find($id)->delete();	
		return 1;
	}

	public function create(){
		$gradeLevels = new gradeLevels();
		$gradeLevels->gradeName = Input::get('gradeName');
		$gradeLevels->gradeDescription = Input::get('gradeDescription');
		$gradeLevels->gradePoints = Input::get('gradePoints');
		$gradeLevels->gradeFrom = Input::get('gradeFrom');
		$gradeLevels->gradeTo = Input::get('gradeTo');
		$gradeLevels->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addLevel'],"jsMessage"=>$this->panelInit->language['gradeCreated'],"grades"=>gradeLevels::get()->toArray() ));
	}

	function fetch($id){
		return gradeLevels::where('id',$id)->first();
	}

	function edit($id){
		$gradeLevels = gradeLevels::find($id);
		$gradeLevels->gradeName = Input::get('gradeName');
		$gradeLevels->gradeDescription = Input::get('gradeDescription');
		$gradeLevels->gradePoints = Input::get('gradePoints');
		$gradeLevels->gradeFrom = Input::get('gradeFrom');
		$gradeLevels->gradeTo = Input::get('gradeTo');
		$gradeLevels->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editGrade'],"jsMessage"=>$this->panelInit->language['gradeUpdated'],"grades"=>gradeLevels::get()->toArray() ));
	}
}