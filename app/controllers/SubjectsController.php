<?php

class SubjectsController extends \BaseController {

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
		return json_encode($this->getSubjectList());
	}

	public function delete($id){
		subject::find($id)->delete();	
		return 1;
	}

	public function create(){
		$subject = new subject();
		$subject->subjectTitle = Input::get('subjectTitle');
		$subject->classId = Input::get('classId');
		$subject->teacherId = Input::get('teacherId');
		$subject->save();

		return json_encode(array("jsTitle"=>$this->panelInit->language['addSubject'],"jsMessage"=>$this->panelInit->language['subjectCreated'],"list"=>$this->getSubjectList() ));
	}

	function fetch($id){
		return subject::where('id',$id)->first();
	}

	function edit($id){
		$subject = subject::find($id);
		$subject->subjectTitle = Input::get('subjectTitle');
		$subject->classId = Input::get('classId');
		$subject->teacherId = Input::get('teacherId');
		$subject->save();

		return json_encode(array("jsTitle"=>$this->panelInit->language['editSubject'],"jsMessage"=>$this->panelInit->language['subjectEdited'],"list"=>$this->getSubjectList() ));
	}

	function getSubjectList(){
		$toReturn = array();
		$toReturn['subjects'] = \DB::table('subject')
					->leftJoin('users', 'users.id', '=', 'subject.teacherId')
					->leftJoin('classes', 'classes.id', '=', 'subject.classId')
					->select('subject.id as id',
					'subject.subjectTitle as subjectTitle',
					'subject.classId as classId',
					'subject.teacherId as teacherId',
					'users.fullName as teacherName',
					'classes.className as className')
					->get();
		$toReturn['teachers'] = User::where('role','teacher')->get()->toArray();
		$toReturn['classes'] =  classes::get()->toArray();
		return $toReturn;
	}
}