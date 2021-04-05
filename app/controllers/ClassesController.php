<?php

class ClassesController extends \BaseController {

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
		return json_encode($this->getClassesList());
	}

	public function delete($id){
		classes::find($id)->delete();	
		return 1;
	}

	public function create(){
		$classes = new classes();
		$classes->className = Input::get('className');
		$classes->classTeacher = json_encode(Input::get('classTeacher'));
		$classes->dormitoryId = Input::get('dormitoryId');
		$classes->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['addClass'],"jsMessage"=>$this->panelInit->language['classCreated'],"list"=>$this->getClassesList() ));
	}

	function fetch($id){
		$classDetail = classes::where('id',$id)->first()->toArray();
		$classDetail['classTeacher'] = json_decode($classDetail['classTeacher']);
		return $classDetail;
	}

	function edit($id){
		$classes = classes::find($id);
		$classes->className = Input::get('className');
		$classes->classTeacher = json_encode(Input::get('classTeacher'));
		$classes->dormitoryId = Input::get('dormitoryId');
		$classes->save();

		return json_encode(array("jsTitle"=>$this->panelInit->language['editClass'],"jsMessage"=>$this->panelInit->language['classUpdated'],"list"=>$this->getClassesList() ));
	}

	function getClassesList(){
		$toReturn = array();
		$teachers = User::where('role','teacher')->get()->toArray();
		$toReturn['dormitory'] =  dormitories::get()->toArray();
		$toReturn['classes'] = array();
		$classes = \DB::table('classes')
					->leftJoin('dormitories', 'dormitories.id', '=', 'classes.dormitoryId')
					->select('classes.id as id',
					'classes.className as className',
					'classes.classTeacher as classTeacher',
					'dormitories.id as dormitory',
					'dormitories.dormitory as dormitoryName')
					->get();

		$toReturn['teachers'] = array();
		while (list($teacherKey, $teacherValue) = each($teachers)) {
			$toReturn['teachers'][$teacherValue['id']] = $teacherValue;
		}

		while (list($key, $class) = each($classes)) {
			$toReturn['classes'][$key] = $class;
			if($toReturn['classes'][$key]->classTeacher != ""){
				$toReturn['classes'][$key]->classTeacher = json_decode($toReturn['classes'][$key]->classTeacher,true);
				if(is_array($toReturn['classes'][$key]->classTeacher)){
					while (list($teacherKey, $teacherID) = each($toReturn['classes'][$key]->classTeacher)) {
						if(isset($toReturn['teachers'][$teacherID]['fullName'])){
							$toReturn['classes'][$key]->classTeacher[$teacherKey] = $toReturn['teachers'][$teacherID]['fullName'];
						}else{
							unset($toReturn['classes'][$key]->classTeacher[$teacherKey]) ;
						}
					}
					$toReturn['classes'][$key]->classTeacher = implode($toReturn['classes'][$key]->classTeacher, ", ");
				}				
			}
		}

		return $toReturn;
	}
}