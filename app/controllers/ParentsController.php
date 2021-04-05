<?php

class ParentsController extends \BaseController {

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

	function waitingApproval(){
		return User::where('role','parent')->where('activated','0')->orderBy('id','DESC')->get();
	}

	function approveOne($id){
		$user = User::find($id);
		$user->activated = 1;
		$user->save();
		return $this->waitingApproval();
	}
	
	function listAllData($page = 1){
		$toReturn = array();
		$toReturn['parents'] = User::where('role','parent')->orderBy('id','DESC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
		$toReturn['totalItems'] = User::where('role','parent')->count();
		return $toReturn;
	}
	
	public function listAll($page = 1)
	{
		return $this->listAllData($page);
	}

	public function export(){
		if($this->data['users']->role != "admin") exit;
		$data = array(1 => array ( 'Full Name','User Name','E-mail','Gender','Address','Phone No','Mobile No','birthday','Profession','password','activated','ParentOf'));
		$student = User::where('role','parent')->get();
		foreach ($student as $value) {
			$data[] = array ($value->fullName,$value->username,$value->email,$value->gender,$value->address,$value->phoneNo,$value->mobileNo,$value->birthday,$value->parentProfession,$value->password,$value->activated,$value->parentOf);
		}

		$xls = new Excel_XML('UTF-8', false, 'Parents Sheet');
		$xls->addArray($data);
		$xls->generateXML('Parents-Sheet');
		exit;
	}

	public function exportpdf(){
		if($this->data['users']->role != "admin") exit;
		$header = array ('Full Name','User Name','E-mail','Gender','Address','Phone No','Mobile No','Profession');
		$data = array();
		$student = User::where('role','parent')->get();
		foreach ($student as $value) {
			$data[] = array ($value->fullName,$value->username ,$value->email,$value->gender,$value->address,$value->phoneNo,$value->mobileNo,$value->parentProfession);
		}

		$pdf = new FPDF();
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();
		
		foreach($header as $col)
			$pdf->Cell(40,7,$col,1);
		$pdf->Ln();
		
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
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen('php://output', 'w');

		$student = User::where('role','parent')->get();
		foreach ($student as $value) {
			fputcsv($output, array($value->username,$value->email,$value->password,$value->fullName,$value->role,$value->activated,$value->birthday,$value->gender,$value->address,$value->phoneNo,$value->mobileNo,$value->parentProfession,$value->parentOf) );
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
						  	
							  if($count == 0)$User->fullName = $cell->nodeValue;
							  if($count == 1)$User->username = $cell->nodeValue;
							  if($count == 2)$User->email = $cell->nodeValue;
							  if($count == 3)$User->gender = $cell->nodeValue;
							  if($count == 4)$User->address = $cell->nodeValue;
							  if($count == 5)$User->phoneNo = $cell->nodeValue;
							  if($count == 6)$User->mobileNo = $cell->nodeValue;
							  if($count == 7)$User->birthday = $cell->nodeValue;
							  if($count == 8)$User->parentProfession = $cell->nodeValue;
							  if($count == 9 AND $cell->nodeValue != "")$User->password = Hash::make($cell->nodeValue);
							  if($count == 10)$User->activated = $cell->nodeValue;
							  if($count == 11)$User->parentOf = $cell->nodeValue;
							  
							  $User->role = "parent";
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
				        if($num != 13 || $data['4'] != "parent"){
				        	return json_encode(array("jsTitle"=>$this->panelInit->language['Import'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['csvParentInvalid'] ));
									exit;
				        }
				        
				        $User = new User();
						$User->email = $data['1'];
						$User->username = $data['0'];
						$User->fullName = $data['3'];
						$User->password = $data['2'];
						$User->role = "parent";
						$User->activated = $data['5'];
						$User->gender = $data['7'];
						$User->address = $data['8'];
						$User->phoneNo = $data['9'];
						$User->mobileNo = $data['10'];
						$User->parentProfession = $data['11'];
						$User->parentOf = $data['12'];
						$User->birthday = $data['6'];
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
	
	public function delete($id){
		User::where('role','parent')->find($id)->delete();	
		return 1;
	}

	public function searchStudents($student){
		$students = User::where('role','student')->where('fullName','like','%'.$student.'%')->orWhere('username','like','%'.$student.'%')->orWhere('email','like','%'.$student.'%')->get();
		$retArray = array();
		foreach ($students as $student) {
			$retArray[$student->id] = array("id"=>$student->id,"name"=>$student->fullName,"email"=>$student->email);
		}
		return json_encode($retArray);
	}

	public function create(){
		if(User::where('username',trim(Input::get('username')))->count() > 0){
			echo $this->panelInit->language['usernameUsed'];
			exit;
		}
		if(User::where('email',Input::get('email'))->count() > 0){
			echo $this->panelInit->language['mailUsed'];
			exit;
		}
		$User = new User();
		$User->username = Input::get('username');
		$User->email = Input::get('email');
		$User->fullName = Input::get('fullName');
		$User->password = Hash::make(Input::get('password'));
		$User->role = "parent";
		$User->gender = Input::get('gender');
		$User->address = Input::get('address');
		$User->phoneNo = Input::get('phoneNo');
		$User->mobileNo = Input::get('mobileNo');
		$User->parentProfession = Input::get('parentProfession');
		$User->parentOf = json_encode(Input::get('studentInfo'));
		$User->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['AddParent'],"jsMessage"=>$this->panelInit->language['parentCreated'],"list"=>$this->listAllData() ));
		exit;
	}

	function fetch($id){
		$data = User::where('role','parent')->where('id',$id)->first()->toArray();
		$data['parentOf'] = json_decode($data['parentOf']);
		return json_encode($data);
	}

	function edit($id){
		if(User::where('username',trim(Input::get('username')))->where('id','<>',$id)->count() > 0){
			echo $this->panelInit->language['usernameUsed'];
			exit;
		}
		if(User::where('email',Input::get('email'))->where('id','<>',$id)->count() > 0){
			echo $this->panelInit->language['mailUsed'];
			exit;
		}
		$User = User::find($id);
		$User->username = Input::get('username');
		$User->email = Input::get('email');
		$User->fullName = Input::get('fullName');
		if(Input::get('password') != ""){
			$User->password = Hash::make(Input::get('password'));
		}
		$User->gender = Input::get('gender');
		$User->address = Input::get('address');
		$User->phoneNo = Input::get('phoneNo');
		$User->mobileNo = Input::get('mobileNo');
		$User->parentProfession = Input::get('parentProfession');
		$User->parentOf = json_encode(Input::get('studentInfo'));
		$User->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['editParent'],"jsMessage"=>$this->panelInit->language['parentModified'],"list"=>$this->listAllData() ));
		exit;
	}

	function profile($id){
		$data = User::where('role','parent')->where('id',$id)->first()->toArray();
		$data['birthday'] = date('m/d/Y',$data['birthday']);

		$return = array();
		$return['title'] = $data['fullName']." ".$this->panelInit->language['Profile'];

		$return['content'] = "<div class='text-center'>";
		if($data['photo'] == ""){
			$return['content'] .= "<img src='uploads/profile/user.png'/>";
		}else{
			$return['content'] .= "<img width='200' src='uploads/profile/".$data['photo']."'/><br/>"."<h3>".$data['fullName']."</h3>";
		}
		$return['content'] .= "</div>";
		
		$return['content'] .= "<h4>".$this->panelInit->language['parentInfo']."</h4>";

		$return['content'] .= "<table class='table table-bordered'><tbody>
                          <tr>
                              <td>".$this->panelInit->language['FullName']."</td>
                              <td>".$data['fullName']."</td>
                          </tr>
                          <tr>
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