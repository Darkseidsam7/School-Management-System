<?php

class OnlineExamsController extends \BaseController {

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
		$toReturn['classes'] = classes::get()->toArray();
		$classesArray = array();
		while (list(, $class) = each($toReturn['classes'])) {
			$classesArray[$class['id']] = $class['className'];
		}

		$toReturn['subjects'] = subject::get()->toArray();
		$subjectArray = array();
		while (list(, $subject) = each($toReturn['subjects'])) {
			$subjectArray[$subject['id']] = $subject['subjectTitle'];
		}

		$toReturn['onlineExams'] = array();
		$onlineExams = onlineExams::get();
		foreach ($onlineExams as $key => $onlineExam) {
			$classId = json_decode($onlineExam->examClass);
			if($this->data['users']->role == "student" AND !in_array($this->data['users']->studentClass, $classId)){
				continue;
			}
			$toReturn['onlineExams'][$key]['id'] = $onlineExam->id;
			$toReturn['onlineExams'][$key]['examTitle'] = $onlineExam->examTitle;
			$toReturn['onlineExams'][$key]['examDescription'] = $onlineExam->examDescription;
			if(isset($subjectArray[$onlineExam->examSubject])){
				$toReturn['onlineExams'][$key]['examSubject'] = $subjectArray[$onlineExam->examSubject];
			}
			$toReturn['onlineExams'][$key]['ExamEndDate'] = date("F j, Y",$onlineExam->ExamEndDate);
			$toReturn['onlineExams'][$key]['ExamShowGrade'] = $onlineExam->ExamShowGrade;
			$toReturn['onlineExams'][$key]['classes'] = "";
			while (list(, $value) = each($classId)) {
				if(isset($classesArray[$value])){
					$toReturn['onlineExams'][$key]['classes'] .= $classesArray[$value].", ";
				}
			}
		}
		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
		exit;
	}

	public function delete($id){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		onlineExams::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$onlineExams = new onlineExams();
		$onlineExams->examTitle = Input::get('examTitle');
		$onlineExams->examDescription = Input::get('examDescription');
		$onlineExams->examClass = json_encode(Input::get('examClass'));
		$onlineExams->examTeacher = $this->data['users']->id;
		$onlineExams->examSubject = Input::get('examSubject');
		$onlineExams->examDate = strtotime(Input::get('examDate'));
		$onlineExams->ExamEndDate = strtotime(Input::get('ExamEndDate'));
		if(Input::get('ExamShowGrade')){
			$onlineExams->ExamShowGrade = Input::get('ExamShowGrade');
		}
		$onlineExams->examQuestion = json_encode(Input::get('examQuestion'));
		$onlineExams->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['addExam'],"jsMessage"=>$this->panelInit->language['examCreated'],"list"=>$this->listAll() ));
		exit;
	}

	function fetch($id){
		$istook = onlineExamsGrades::where('examId',$id)->where('studentId',$this->data['users']->id)->count();

		$onlineExams = onlineExams::where('id',$id)->first()->toArray();
		$onlineExams['examClass'] = json_decode($onlineExams['examClass']);
		$onlineExams['examQuestion'] = json_decode($onlineExams['examQuestion']);
		if(time() > $onlineExams['ExamEndDate'] || time() < $onlineExams['examDate']){
			$onlineExams['finished'] = true;
		}
		if($istook > 0){
			$onlineExams['taken'] = true;
		}
		$onlineExams['examDate'] = date("m/d/Y",$onlineExams['examDate']);
		$onlineExams['ExamEndDate'] = date("m/d/Y",$onlineExams['ExamEndDate']);
		return $onlineExams;
	}

	function marks($id){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$grades = \DB::table('onlineExamsGrades')
					->where('examId',$id)
					->leftJoin('users', 'users.id', '=', 'onlineExamsGrades.studentId')
					->select('onlineExamsGrades.id as id',
					'onlineExamsGrades.examGrade as examGrade',
					'onlineExamsGrades.examDate as examDate',
					'users.fullName as fullName',
					'users.id as studentId')
					->get();

		return json_encode($grades);
	}

	function edit($id){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$onlineExams = onlineExams::find($id);
		$onlineExams->examTitle = Input::get('examTitle');
		$onlineExams->examDescription = Input::get('examDescription');
		$onlineExams->examClass = json_encode(Input::get('examClass'));
		$onlineExams->examTeacher = $this->data['users']->id;
		$onlineExams->examSubject = Input::get('examSubject');
		$onlineExams->examDate = strtotime(Input::get('examDate'));
		$onlineExams->ExamEndDate = strtotime(Input::get('ExamEndDate'));
		if(Input::get('ExamShowGrade')){
			$onlineExams->ExamShowGrade = Input::get('ExamShowGrade');
		}
		$onlineExams->examQuestion = json_encode(Input::get('examQuestion'));
		$onlineExams->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['editExam'],"jsMessage"=>$this->panelInit->language['examModified'],"list"=>$this->listAll() ));
		exit;
	}

	function took($id){
		$toReturn = array();
		$answers = Input::get('examQuestion');
		$score = 0;
		while (list($key, $value) = each($answers)) {
			if($value['answer'] == $value['Tans']){
				$score++;
			}
		}
		$onlineExamsGrades = new onlineExamsGrades();
		$onlineExamsGrades->examId = Input::get('id') ;
		$onlineExamsGrades->studentId = $this->data['users']->id ;
		$onlineExamsGrades->examQuestionsAnswers = json_encode($answers) ;
		$onlineExamsGrades->examGrade = $score ;
		$onlineExamsGrades->examDate = time() ;
		$onlineExamsGrades->save();

		if(Input::get('ExamShowGrade') == 1){
			$toReturn['grade'] = $score;
		}
		$toReturn['finish'] = true;
		return json_encode($toReturn);
	}

	function export($id,$type){
		if($this->data['users']->role != "admin") exit;
		if($type == "excel"){
			$classArray = array();
			$classes = classes::get();
			foreach ($classes as $class) {
				$classArray[$class->id] = $class->className;
			}

			$data = array(1 => array ('Student Roll','Full Name','Date took','Exam Grade'));
			$grades = \DB::table('onlineExamsGrades')
					->where('examId',$id)
					->leftJoin('users', 'users.id', '=', 'onlineExamsGrades.studentId')
					->select('onlineExamsGrades.id as id',
					'onlineExamsGrades.examGrade as examGrade',
					'onlineExamsGrades.examDate as examDate',
					'users.fullName as fullName',
					'users.id as studentId',
					'users.studentRollId as studentRollId')
					->get();
			foreach ($grades as $value) {
				$data[] = array ($value->studentRollId,$value->fullName,date("m/d/y",$value->examDate) , $value->examGrade );
			}

			$xls = new Excel_XML('UTF-8', false, 'Exam grades Sheet');
			$xls->addArray($data);
			$xls->generateXML('Exam grades Sheet');
		}elseif ($type == "pdf") {
			$classArray = array();
			$classes = classes::get();
			foreach ($classes as $class) {
				$classArray[$class->id] = $class->className;
			}

			$header = array ('Student Roll','Full Name','Date took','Exam Grade');
			$data = array();
			$grades = \DB::table('onlineExamsGrades')
					->where('examId',$id)
					->leftJoin('users', 'users.id', '=', 'onlineExamsGrades.studentId')
					->select('onlineExamsGrades.id as id',
					'onlineExamsGrades.examGrade as examGrade',
					'onlineExamsGrades.examDate as examDate',
					'users.fullName as fullName',
					'users.id as studentId',
					'users.studentRollId as studentRollId')
					->get();
			foreach ($grades as $value) {
				$data[] = array ($value->studentRollId,$value->fullName,date("m/d/y",$value->examDate) , $value->examGrade );
			}

			$pdf = new FPDF();
			$pdf->SetFont('Arial','',10);
			$pdf->AddPage();
			// Header
			foreach($header as $col)
				$pdf->Cell(60,7,$col,1);
			$pdf->Ln();
			// Data
			foreach($data as $row)
			{
				foreach($row as $col)
					$pdf->Cell(60,6,$col,1);
				$pdf->Ln();
			}
			$pdf->Output();
		}
		exit;
	}
}