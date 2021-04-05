<?php

class StudentsController extends \BaseController {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';
	
	public function __construct(){
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = \Auth::user();
		if($this->data['users']->role == "student") exit;
	}
	
	public function index($method = "main")
	{		
		$this->panelInit->viewop($this->layout,'languages',$this->data);
	}

	function waitingApproval(){
		if($this->data['users']->role != "admin") exit;
		return User::where('role','student')->where('activated','0')->orderBy('id','DESC')->get();
	}

	function approveOne($id){
		if($this->data['users']->role != "admin") exit;
		$user = User::find($id);
		$user->activated = 1;
		$user->save();
		return $this->waitingApproval();
	}

	function listAllData($page = 1){
		$toReturn = array();
		if($this->data['users']->role == "parent" ){
			$studentId = array();
			$parentOf = json_decode($this->data['users']->parentOf,true);
			if(is_array($parentOf)){
				while (list($key, $value) = each($parentOf)) {
					$studentId[] = $value['id'];
				}
			}
			if(count($studentId) > 0){
				$students = User::where('role','student')->whereIn('id', $studentId)->orderBy('studentRollId','ASC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
			}else{
				$students = array();
			}
		}else{
			$students = User::where('role','student')->orderBy('studentRollId','ASC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
		}
		$toReturn['classes'] = $classes = classes::get()->toArray();
		$classArray = array();
		while (list(, $value) = each($classes)) {
			$classArray[$value['id']] = $value['className'];
		}
		$toReturn['transports'] =  transportation::get()->toArray();
		$toReturn['totalItems'] = User::where('role','student')->count();
		$toReturn['userRole'] = $this->data['users']->role;
		
		$toReturn['students'] = array();
		while (list(, $student) = each($students)) {
			$toReturn['students'][] = array('id'=>$student['id'],"studentRollId"=>$student['studentRollId'],"fullName"=>$student['fullName'],"username"=>$student['username'],"email"=>$student['email'],"studentClass"=>isset($classArray[$student['studentClass']]) ? $classArray[$student['studentClass']] : "");
		}

		return $toReturn;
	}
	
	public function listAll($page = 1)
	{
		return $this->listAllData($page);
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		User::where('role','student')->find($id)->delete();	
		return 1;
	}

	public function export(){
		if($this->data['users']->role != "admin") exit;
		$classArray = array();
		$classes = classes::get();
		foreach ($classes as $class) {
			$classArray[$class->id] = $class->className;
		}

		$data = array(1 => array ('Roll', 'Full Name','User Name','E-mail','Gender','Address','Phone No','Mobile No','Class','password','activated','birthday','Class ID'));
		$student = User::where('role','student')->get();
		foreach ($student as $value) {
			$data[] = array ($value->studentRollId, $value->fullName,$value->username,$value->email,$value->gender,$value->address,$value->phoneNo,$value->mobileNo,isset($classArray[$value->studentClass]) ? $classArray[$value->studentClass] : "",$value->password,$value->activated,$value->birthday,$value->studentClass);
		}

		$xls = new Excel_XML('UTF-8', false, 'Payments Sheet');
		$xls->addArray($data);
		$xls->generateXML('Students Sheet');
		exit;
	}

	public function exportpdf(){
		if($this->data['users']->role != "admin") exit;
		$classArray = array();
		$classes = classes::get();
		foreach ($classes as $class) {
			$classArray[$class->id] = $class->className;
		}

		$header = array ('Full Name','User Name','E-mail','Gender','Address','Mobile No','Class');
		$data = array();
		$student = User::where('role','student')->get();
		foreach ($student as $value) {
			$data[] = array ($value->fullName,$value->username . "(".$value->studentRollId.")",$value->email,$value->gender,$value->address,$value->mobileNo, isset($classArray[$value->studentClass]) ? $classArray[$value->studentClass] : "" );
		}

		$pdf = new FPDF();
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();
		// Header
		foreach($header as $col)
			$pdf->Cell(40,7,$col,1);
		$pdf->Ln();
		// Data
		foreach($data as $row)
		{
			foreach($row as $col)
				$pdf->Cell(40,6,$col,1);
			$pdf->Ln();
		}
		$pdf->Output();
		exit;
	}

	public function exportcsv(){
		if($this->data['users']->role != "admin") exit;

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=students.csv');
		$output = fopen('php://output', 'w');
	
		$student = User::where('role','student')->get();
		foreach ($student as $value) {
			fputcsv($output, array($value->username,$value->email,$value->password,$value->fullName,$value->role,$value->activated,$value->studentRollId,$value->birthday,$value->gender,$value->address,$value->phoneNo,$value->mobileNo,$value->studentClass) );
		}
		exit;
	}

	public function import($type){
		if($this->data['users']->role != "admin") exit;

		if (Input::hasFile('excelcsv')) {
			if($type == "excel"){
				if ( $_FILES['excelcsv']['tmp_name'] )
			  {
				  $doms = new DOMDocument();
				  $doms->load( $_FILES['excelcsv']['tmp_name'] );
				  $rows = $doms->getElementsByTagName( 'Row' );
				  $first_row = true;
				  foreach ($rows as $row)
				  {
					  if ( !$first_row )
					  {						  
						  $cells = $row->getElementsByTagName( 'Cell' );
						  $User = new User();
						  $count = 0;
						  foreach( $cells as $cell )
						  { 
							  if($count == 0)$User->studentRollId = $cell->nodeValue;
							  if($count == 1)$User->fullName = $cell->nodeValue;
							  if($count == 2)$User->username = $cell->nodeValue;
							  if($count == 3)$User->email = $cell->nodeValue;
							  if($count == 4)$User->gender = $cell->nodeValue;
							  if($count == 5)$User->address = $cell->nodeValue;
							  if($count == 6)$User->phoneNo = $cell->nodeValue;
							  if($count == 7)$User->mobileNo = $cell->nodeValue;
							  if($count == 8)$User->studentClass = $cell->nodeValue;
							  if($count == 9 AND $cell->nodeValue != "")$User->password = $cell->nodeValue;
							  if($count == 10)$User->activated = $cell->nodeValue;
							  if($count == 11)$User->birthday = $cell->nodeValue;
							  if($count == 12)$User->studentClass = $cell->nodeValue;
							  
							  $User->role = "student";
								$count++;
						  }
						  $User->save();
					  }
					  $first_row = false;
				  }
			  } 

			}elseif($type == "csv"){
				if (($handle = fopen($_FILES['excelcsv']['tmp_name'], "r")) !== FALSE) { 
				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				        $num = count($data);
				        if($num != 13 || $data['4'] != "student"){
				        	return json_encode(array("jsTitle"=>$this->panelInit->language['Import'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['csvStudentInvalid'] ));
									exit;
				        }
								$User = new User();
								$User->email = $data['1'];
								$User->username = $data['0'];
								$User->fullName = $data['3'];
								$User->password = $data['2'];
								$User->role = "student";
								$User->activated = $data['5'];
								$User->studentRollId = $data['6'];
								$User->gender = $data['8'];
								$User->address = $data['9'];
								$User->phoneNo = $data['10'];
								$User->mobileNo = $data['11'];
								$User->studentClass = $data['12'];
								$User->birthday = $data['7'];
								$User->save();
				    }
				    fclose($handle);
				}
			}
			return json_encode(array("jsTitle"=>$this->panelInit->language['Import'],"jsStatus"=>"1","jsMessage"=>$this->panelInit->language['dataImported'] ));
		}else{
			return json_encode(array("jsTitle"=>$this->panelInit->language['Import'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['specifyFileToImport'] ));
			exit;
		}
		exit;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		if(User::where('username',trim(Input::get('username')))->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['addStudent'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['usernameUsed'] ));
			exit;
		}
		if(User::where('email',Input::get('email'))->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['addStudent'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mailUsed'] ));
			exit;
		}
		$User = new User();
		$User->email = Input::get('email');
		$User->username = Input::get('username');
		$User->fullName = Input::get('fullName');
		$User->password = Hash::make(Input::get('password'));
		$User->role = "student";
		$User->studentRollId = Input::get('studentRollId');
		$User->gender = Input::get('gender');
		$User->address = Input::get('address');
		$User->phoneNo = Input::get('phoneNo');
		$User->mobileNo = Input::get('mobileNo');
		$User->studentClass = Input::get('studentClass');
		$User->transport = Input::get('transport');
		if(Input::get('birthday') != ""){
			$birthday = explode("/", Input::get('birthday'));
			$birthday = mktime(0,0,0,$birthday['0'],$birthday['1'],$birthday['2']);
			$User->birthday = $birthday;
		}
		$User->save();
		
		if (Input::hasFile('photo')) {
			$fileInstance = Input::file('photo');
			$newFileName = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
			$file = $fileInstance->move('uploads/profile/',$newFileName);

			$User->photo = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
			$User->save();
		}
		return json_encode(array("jsTitle"=>$this->panelInit->language['addStudent'],"jsMessage"=>$this->panelInit->language['studentCreatedSuccess'],"list"=>$this->listAll() ));
		exit;
	}

	function fetch($id){
		$data = User::where('role','student')->where('id',$id)->first()->toArray();
		$data['birthday'] = date('m/d/Y',$data['birthday']);
		return json_encode($data);
	}

	function leaderboard($id){
		if($this->data['users']->role != "admin") exit;
		$user = User::where('role','student')->update(array('isLeaderBoard' => ''));;

		$user = User::where('id',$id)->first();
		$user->isLeaderBoard = Input::get('isLeaderBoard');
		$user->save();
		echo 1;
		exit;
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		if(User::where('username',trim(Input::get('username')))->where('id','<>',$id)->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['editStudent'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['usernameUsed'] ));
			exit;
		}
		if(User::where('email',Input::get('email'))->where('id','<>',$id)->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['editStudent'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mailUsed'] ));
			exit;
		}
		$User = User::find($id);
		$User->email = Input::get('email');
		$User->username = Input::get('username');
		$User->fullName = Input::get('fullName');
		if(Input::get('password') != ""){
			$User->password = Hash::make(Input::get('password'));
		}
		$User->studentRollId = Input::get('studentRollId');
		$User->gender = Input::get('gender');
		$User->address = Input::get('address');
		$User->phoneNo = Input::get('phoneNo');
		$User->mobileNo = Input::get('mobileNo');
		$User->studentClass = Input::get('studentClass');
		$User->transport = Input::get('transport');
		if(Input::get('birthday') != ""){
			$birthday = explode("/", Input::get('birthday'));
			$birthday = mktime(0,0,0,$birthday['0'],$birthday['1'],$birthday['2']);
			$User->birthday = $birthday;
		}

		if (Input::hasFile('photo')) {
			$fileInstance = Input::file('photo');
			$newFileName = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
			$file = $fileInstance->move('uploads/profile/',$newFileName);

			$User->photo = "profile_".$User->id.".".$fileInstance->getClientOriginalExtension();
		}
		$User->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editStudent'],"jsMessage"=>$this->panelInit->language['studentModified'],"list"=>$this->listAll() ));
		exit;
	}

	function marksheet($id){
		$marks = array();
		$examsList = examsList::get();
		$examMarks = examMarks::where('studentId',$id)->get();
		if(count($examMarks) == 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['Marksheet'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['studentHaveNoMarks'] ));
			exit;
		}
		$subject = subject::get();
		$gradeLevels = gradeLevels::get();

		$examArray = array();
		foreach ($examsList as $exam) {
			$marks[$exam->id] = array("title"=>$exam->examTitle);
		}

		$subjectArray = array();
		foreach ($subject as $sub) {
			$subjectArray[$sub->id] = $sub->subjectTitle;
		}

		$gradeLevelsArray = array();
		foreach ($gradeLevels as $grade) {
			$gradeLevelsArray[$grade->gradeName] = array('from'=>$grade->gradeFrom,"to"=>$grade->gradeTo,"points"=>$grade->gradePoints);
		}

		foreach ($examMarks as $mark) {
			if(!isset($marks[$mark->examId]['counter'])){
				$marks[$mark->examId]['counter'] = 0;
				$marks[$mark->examId]['points'] = 0;
				$marks[$mark->examId]['totalMarks'] = 0;
			}
			$marks[$mark->examId]['counter'] ++;
			$marks[$mark->examId]['data'][$mark->id]['subjectName'] = $subjectArray[$mark->subjectId];
			$marks[$mark->examId]['data'][$mark->id]['subjectId'] = $mark->subjectId;
			$marks[$mark->examId]['data'][$mark->id]['examMark'] = $mark->examMark;
			$marks[$mark->examId]['data'][$mark->id]['attendanceMark'] = $mark->attendanceMark;
			$marks[$mark->examId]['data'][$mark->id]['markComments'] = $mark->markComments;
			while (list($key, $value) = each($gradeLevelsArray)) {
				if($mark->examMark > $value['from'] AND $mark->examMark < $value['to']){
					$marks[$mark->examId]['points'] += $value['points'];
					$marks[$mark->examId]['data'][$mark->id]['grade'] = $key;
					$marks[$mark->examId]['totalMarks'] += $mark->examMark;
					break;
				}
			}
		}

		while (list($key, $value) = each($marks)) {
			if(isset($value['points']) AND $value['counter']){
				$marks[$key]['pointsAvg'] = $value['points'] / $value['counter'];
			}
		}

		return $marks;
		exit;
	}

	function attendance($id){ 
		$toReturn = array();
		$toReturn['attendanceModel'] = $this->data['panelInit']->settingsArray['attendanceModel'];
		$toReturn['attendance'] = attendance::where('studentId',$id)->get()->toArray();

		if($this->data['panelInit']->settingsArray['attendanceModel'] == "subject"){
			$subjects = subject::get();
			$toReturn['subjects'] = array();
			foreach ($subjects as $subject) {
				$toReturn['subjects'][$subject->id] = $subject->subjectTitle ;
			}
		}
		return $toReturn;
	}

	function profile($id){
		$data = User::where('role','student')->where('id',$id)->first()->toArray();
		$data['birthday'] = date('m/d/Y',$data['birthday']);

		if($data['studentClass'] != "" AND $data['studentClass'] != "0"){
			$class = classes::where('id',$data['studentClass'])->first();
		}
		
		$return = array();
		$return['title'] = $data['fullName']." ".$this->panelInit->language['Profile'];

		$return['content'] = "<div class='text-center'>";
		if($data['photo'] == ""){
			$return['content'] .= "<img src='uploads/profile/user.png'/>";
		}else{
			$return['content'] .= "<img width='200' src='uploads/profile/".$data['photo']."'/><br/>"."<h3>".$data['fullName']."</h3>";
		}
		$return['content'] .= "</div>";
		
		$return['content'] .= "<h4>".$this->panelInit->language['studentInfo']."</h4>";

		$return['content'] .= "<table class='table table-bordered'><tbody>
                          <tr>
                              <td>".$this->panelInit->language['FullName']."</td>
                              <td>".$data['fullName']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['rollid']."</td>
                              <td>".$data['studentRollId']."</td>
                          </tr>";
                          if(isset($class)){
	                          $return['content'] .= "<tr>
	                              <td>".$this->panelInit->language['class']."</td>
	                              <td>".$class->className."</td>
	                          </tr>";
	                        }
                          $return['content'] .= "<tr>
                              <td>".$this->panelInit->language['username']."</td>
                              <td>".$data['username']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['email']."</td>
                              <td>".$data['email']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['Birthday']."</td>
                              <td>".$data['birthday']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['Gender']."</td>
                              <td>".$data['gender']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['Address']."</td>
                              <td>".$data['address']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['phoneNo']."</td>
                              <td>".$data['phoneNo']."</td>
                          </tr>
                          <tr>
                              <td>".$this->panelInit->language['mobileNo']."</td>
                              <td>".$data['mobileNo']."</td>
                          </tr>

                          </tbody></table>";

		return $return;
	}
}