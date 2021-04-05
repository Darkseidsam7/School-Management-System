<?php

class promotionController extends \BaseController {

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
		$toReturn = array();
		$toReturn['classes'] = classes::get()->toArray();
		return $toReturn;
	}

	public function listStudents($class){
		$toReturn = array();
		$students = User::where('studentClass',$class)->where('role','student')->where('activated',1)->get();
		foreach ($students as $value) {
			$toReturn[$value->id] = $value->fullName;
		}
		return $toReturn;
	}

	public function promoteNow(){
		if(in_array(0, Input::get('studentsIds'))){
			$users = User::where('studentClass',Input::get('classId'))->where('role','student')->where('activated',1)->update(['studentClass' => Input::get('toClassId')]);
		}else{
			$users = User::whereIn('id',Input::get('studentsIds'))->where('role','student')->where('activated',1)->update(['studentClass' => Input::get('toClassId')]);
			print_r($users);
		}
		return 1;
	}

}