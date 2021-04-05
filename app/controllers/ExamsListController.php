<?php

class ExamsListController extends \BaseController {

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
		$toReturn['exams'] = examsList::get()->toArray();
		$toReturn['classes'] = classes::get()->toArray();
		$toReturn['subjects'] = subject::get()->toArray();
		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		examsList::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$examsList = new examsList();
		$examsList->examTitle = Input::get('examTitle');
		$examsList->examDescription = Input::get('examDescription');
		$examsList->examDate = Input::get('examDate');
		$examsList->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addExam'],"jsMessage"=>$this->panelInit->language['examCreated'],"list"=>examsList::get()->toArray() ));
	}

	function fetch($id){
		return examsList::where('id',$id)->first();
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$examsList = examsList::find($id);
		$examsList->examTitle = Input::get('examTitle');
		$examsList->examDescription = Input::get('examDescription');
		$examsList->examDate = Input::get('examDate');
		$examsList->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editExam'],"jsMessage"=>$this->panelInit->language['examModified'],"list"=>examsList::get()->toArray() ));
	}

	function fetchMarks($exam,$class,$subject){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$toReturn = array();
		$toReturn['exam'] = examsList::where('id',$exam)->first()->toArray();
		$toReturn['class'] = classes::where('id',$class)->first()->toArray();
		$toReturn['subject'] = subject::where('id',$subject)->first()->toArray();
		
		$toReturn['students'] = array();
		$studentArray = User::where('role','student')->where('studentClass',$class)->get();
		foreach ($studentArray as $stOne) {
			$toReturn['students'][$stOne->id] = array('id'=>$stOne->id,'name'=>$stOne->fullName,'studentRollId'=>$stOne->studentRollId,'examMark'=>'','attendanceMark'=>'','markComments'=>'');
		}

		$examMarks = examMarks::where('examId',$exam)->where('classId',$class)->where('subjectId',$subject)->get();
		foreach ($examMarks as $stMark) {
			if(isset($toReturn['students'][$stMark->studentId])){
				$toReturn['students'][$stMark->studentId]['examMark'] = $stMark->examMark;
				$toReturn['students'][$stMark->studentId]['attendanceMark'] = $stMark->attendanceMark;
				$toReturn['students'][$stMark->studentId]['markComments'] = $stMark->markComments;
			}
		}
		echo json_encode($toReturn);
		exit;
	}

	function saveMarks($exam,$class,$subject){
		if($this->data['users']->role == "student" || $this->data['users']->role == "parent") exit;
		$examMarksList = array();
		$examMarks = examMarks::where('examId',$exam)->where('classId',$class)->where('subjectId',$subject)->get();
		foreach ($examMarks as $stMark) {
			$examMarksList[$stMark->studentId] = array("examMark"=>$stMark->examMark,"attendanceMark"=>$stMark->attendanceMark,"markComments"=>$stMark->markComments);
		}

		$stMarks = Input::get('respStudents');
		while (list($key, $value) = each($stMarks)) {
			if(!isset($examMarksList[$key])){
				$examMarks = new examMarks;
				$examMarks->examId = $exam;
				$examMarks->classId = $class;
				$examMarks->subjectId = $subject;
				$examMarks->studentId = $key;
				$examMarks->examMark = $value['examMark']; 
				$examMarks->attendanceMark = $value['attendanceMark']; 
				$examMarks->markComments = $value['markComments']; 
				$examMarks->save();
			}else{
				$examMarks = examMarks::where('examId',$exam)->where('classId',$class)->where('subjectId',$subject)->where('studentId',$key)->first();
				$examMarks->examMark = $value['examMark']; 
				$examMarks->attendanceMark = $value['attendanceMark']; 
				$examMarks->markComments = $value['markComments']; 
				$examMarks->save();
			}
		}
		echo json_encode(array("jsTitle"=>$this->panelInit->language['editExam'],"jsMessage"=>$this->panelInit->language['examModified'],"list"=>examsList::get()->toArray() ));
		exit;
	}

	function notifications($id){
		if($this->data['users']->role != "admin") exit;
		if($this->panelInit->settingsArray['examDetailsNotif'] == "0"){
			return json_encode(array("jsTitle"=>$this->panelInit->language['examDetailsNot'],"jsMessage"=>$this->panelInit->language['adjustExamNot'] ));
			exit;
		}

		$examsList = examsList::where('id',$id)->first();

		$subjectArray = array();
		$subject = subject::get();
		foreach ($subject as $value) {
			$subjectArray[$value->id] = $value->subjectTitle;
		}

		$usersArray = array();
		if($this->data['panelInit']->settingsArray['examDetailsNotifTo'] == "parent" || $this->data['panelInit']->settingsArray['examDetailsNotifTo'] == "both"){
			$users = User::where('role','student')->orWhere('role','parent')->get();
		}else{
			$users = User::where('role','student')->get();
		}
		foreach ($users as $value) {
			if($value->parentOf == "" AND $value->role == "parent") continue;
			if(!isset($usersArray[$value->id])){
				$usersArray[$value->id] = array();
			}
			if($value->parentOf != ""){
				$value->parentOf = json_decode($value->parentOf);
				if(count($value->parentOf) > 0){
					$usersArray[$value->id]['parents'] = array();
				}				
				foreach ($value->parentOf as $parentOf) {
					$usersArray[$parentOf->id]['parents'][$value->id] = array('username'=>$value->username,"email"=>$value->email,"fullName"=>$value->fullName,"mobileNo"=>$value->mobileNo);
				}
			}
			$usersArray[$value->id]['student'] = array('username'=>$value->username,"studentRollId"=>$value->studentRollId,"mobileNo"=>$value->mobileNo,"email"=>$value->email,"fullName"=>$value->fullName);
		}

		$return['marks'] = array();
		$examMarks = examMarks::where('examId',$id)->get();
		foreach ($examMarks as $value) {
			if(!isset($return['marks'][$value->studentId])){
				$return['marks'][$value->studentId] = array();
			}
			if(isset($subjectArray[$value->subjectId])){
				$return['marks'][$value->studentId][ $subjectArray[$value->subjectId] ] = array("examMark"=>$value->examMark,"attendanceMark"=>$value->attendanceMark,"markComments"=>$value->markComments);
			}
		}

		$mailTemplate = mailsmsTemplates::where('templateTitle','Exam Details')->first();

		if($this->panelInit->settingsArray['examDetailsNotif'] == "mail" || $this->panelInit->settingsArray['examDetailsNotif'] == "mailsms"){
			$mail = true;
		}
		if($this->panelInit->settingsArray['examDetailsNotif'] == "sms" || $this->panelInit->settingsArray['examDetailsNotif'] == "mailsms"){
			$sms = true;
		}

		$MailSmsHandler = new MailSmsHandler();
		while (list($key, $value) = each($return['marks'])) {
			if(isset($mail)){
				$studentTemplate = $mailTemplate->templateMail;
				$examGradesTable = "";
				while (list($keyG, $valueG) = each($value)) {
					$examGradesTable .= $keyG. " Grade : ".$valueG['examMark']." - Attendance : ".$valueG['attendanceMark']." - Comments : ".$valueG['markComments'];
				}
				$searchArray = array("{studentName}","{studentRoll}","{studentEmail}","{studentUsername}","{examTitle}","{examDescription}","{examDate}","{schoolTitle}","{examGradesTable}");
				$replaceArray = array($usersArray[$key]['student']['fullName'],$usersArray[$key]['student']['studentRollId'],$usersArray[$key]['student']['email'],$usersArray[$key]['student']['username'],$examsList->examTitle,$examsList->examDescription,$examsList->examDate,$this->panelInit->settingsArray['siteTitle'],$examGradesTable);
				$studentTemplate = str_replace($searchArray, $replaceArray, $studentTemplate);
				$MailSmsHandler->mail($usersArray[$key]['student']['email'],"Exam grade details",$studentTemplate,$usersArray[$key]['student']['fullName']);
				if(isset($usersArray[$key]['parents'])){
					while (list($keyP, $valueP) = each($usersArray[$key]['parents'])) {
						$MailSmsHandler->mail($valueP['email'],"Exam grade details",$studentTemplate,$usersArray[$key]['student']['fullName']);
					}
				}
			}
			if(isset($sms)){
				$studentTemplate = $mailTemplate->templateSMS;
				$examGradesTable = "";
				while (list($keyG, $valueG) = each($value)) {
					$examGradesTable .= $keyG. " Grade : ".$valueG['examMark']." - Attendance : ".$valueG['attendanceMark'];
				}
				$searchArray = array("{studentName}","{studentRoll}","{studentEmail}","{studentUsername}","{examTitle}","{examDescription}","{examDate}","{schoolTitle}","{examGradesTable}");
				$replaceArray = array($usersArray[$key]['student']['fullName'],$usersArray[$key]['student']['studentRollId'],$usersArray[$key]['student']['email'],$usersArray[$key]['student']['username'],$examsList->examTitle,$examsList->examDescription,$examsList->examDate,$this->panelInit->settingsArray['siteTitle'],$examGradesTable);
				$studentTemplate = str_replace($searchArray, $replaceArray, $studentTemplate);
				if($usersArray[$key]['student']['mobileNo'] != ""){
					$MailSmsHandler->sms($usersArray[$key]['student']['mobileNo'],$studentTemplate);
				}
				if(isset($usersArray[$key]['parents'])){
					reset($usersArray[$key]['parents']);
					while (list($keyP, $valueP) = each($usersArray[$key]['parents'])) {
						if(trim($valueP['mobileNo']) != ""){
							$MailSmsHandler->sms($valueP['mobileNo'],$studentTemplate);
						}
					}
				}
			}
		}
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['examDetailsNot'],"jsMessage"=>$this->panelInit->language['examNotSent'] ));
		exit;
	}
}