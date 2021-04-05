<?php

class AssignmentsController extends \BaseController {

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
		$toReturn = array();
		$toReturn['classes'] = classes::get()->toArray();
		$classesArray = array();
		while (list(, $class) = each($toReturn['classes'])) {
			$classesArray[$class['id']] = $class['className'];
		}

		$toReturn['subject'] = subject::get()->toArray();
		$subjectArray = array();
		while (list(, $subject) = each($toReturn['subject'])) {
			$subjectArray[$subject['id']] = $subject['subjectTitle'];
		}

		$toReturn['assignments'] = array();
		$assignments = assignments::get();
		foreach ($assignments as $key => $assignment) {
			$classId = json_decode($assignment->classId);
			if($this->data['users']->role == "student" AND !in_array($this->data['users']->studentClass, $classId)){
				continue;
			}
			$toReturn['assignments'][$key]['id'] = $assignment->id;
			$toReturn['assignments'][$key]['subjectId'] = $assignment->subjectId;
			$toReturn['assignments'][$key]['subject'] = $subjectArray[$assignment->subjectId];
			$toReturn['assignments'][$key]['AssignTitle'] = $assignment->AssignTitle;
			$toReturn['assignments'][$key]['AssignDescription'] = $assignment->AssignDescription;
			$toReturn['assignments'][$key]['AssignFile'] = $assignment->AssignFile;
			$toReturn['assignments'][$key]['AssignDeadLine'] = $assignment->AssignDeadLine;
			$toReturn['assignments'][$key]['classes'] = "";

			while (list(, $value) = each($classId)) {
				if(isset($classesArray[$value])) {
					$toReturn['assignments'][$key]['classes'] .= $classesArray[$value].", ";
				}
			}
		}

		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
		exit;
	}

	public function delete($id){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		assignments::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$assignments = new assignments();
		$assignments->classId = json_encode(Input::get('classId'));
		$assignments->subjectId = Input::get('subjectId');
		$assignments->teacherId = Input::get('teacherId');
		$assignments->AssignTitle = Input::get('AssignTitle');
		$assignments->AssignDescription = Input::get('AssignDescription');
		$assignments->AssignDeadLine = Input::get('AssignDeadLine');
		$assignments->teacherId = $this->data['users']->id;
		$assignments->save();
		if (Input::hasFile('AssignFile')) {
			$fileInstance = Input::file('AssignFile');
			$newFileName = "assignments_".uniqid().".".$fileInstance->getClientOriginalExtension();
			$fileInstance->move('uploads/assignments/',$newFileName);

			$assignments->AssignFile = $newFileName;
			$assignments->save();
		}
		return json_encode(array("jsTitle"=>$this->panelInit->language['AddAssignments'],"jsMessage"=>$this->panelInit->language['assignmentCreated'],"list"=>$this->listAll() ));
		exit;
	}

	function fetch($id){
		return assignments::where('id',$id)->first();
	}

	function edit($id){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$assignments = assignments::find($id);
		$assignments->classId = json_encode(Input::get('classId'));
		$assignments->subjectId = Input::get('subjectId');
		$assignments->teacherId = Input::get('teacherId');
		$assignments->AssignTitle = Input::get('AssignTitle');
		$assignments->AssignDescription = Input::get('AssignDescription');
		$assignments->AssignDeadLine = Input::get('AssignDeadLine');
		if (Input::hasFile('AssignFile')) {
			@unlink("uploads/assignments/".$assignments->AssignFile);
			$fileInstance = Input::file('AssignFile');
			$newFileName = "assignments_".uniqid().".".$fileInstance->getClientOriginalExtension();
			$fileInstance->move('uploads/assignments/',$newFileName);

			$assignments->AssignFile = $newFileName;
			$assignments->save();
		}
		$assignments->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editAssignment'],"jsMessage"=>$this->panelInit->language['assignmentModified'],"list"=>$this->listAll() ));
		exit;
	}
}