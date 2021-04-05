<?php

class PaymentsController extends \BaseController {

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

		if($this->data['users']->role == "admin"){
			$toReturn['payments'] = \DB::table('payments')
						->leftJoin('users', 'users.id', '=', 'payments.paymentStudent')
						->select('payments.id as id',
						'payments.paymentTitle as paymentTitle',
						'payments.paymentDescription as paymentDescription',
						'payments.paymentAmount as paymentAmount',
						'payments.paymentStatus as paymentStatus',
						'payments.paymentDate as paymentDate',
						'payments.paymentStudent as studentId',
						'users.fullName as fullName')
						->get();
		}elseif($this->data['users']->role == "student"){
			$toReturn['payments'] = \DB::table('payments')
						->where('paymentStudent',$this->data['users']->id)
						->leftJoin('users', 'users.id', '=', 'payments.paymentStudent')
						->select('payments.id as id',
						'payments.paymentTitle as paymentTitle',
						'payments.paymentDescription as paymentDescription',
						'payments.paymentAmount as paymentAmount',
						'payments.paymentStatus as paymentStatus',
						'payments.paymentDate as paymentDate',
						'payments.paymentStudent as studentId',
						'users.fullName as fullName')
						->get();
		}elseif($this->data['users']->role == "parent"){
			$studentId = array();
			$parentOf = json_decode($this->data['users']->parentOf,true);
			if(is_array($parentOf)){
				while (list($key, $value) = each($parentOf)) {
					$studentId[] = $value['id'];
				}
			}
			$toReturn['payments'] = \DB::table('payments')
						->whereIn('paymentStudent',$studentId)
						->leftJoin('users', 'users.id', '=', 'payments.paymentStudent')
						->select('payments.id as id',
						'payments.paymentTitle as paymentTitle',
						'payments.paymentDescription as paymentDescription',
						'payments.paymentAmount as paymentAmount',
						'payments.paymentStatus as paymentStatus',
						'payments.paymentDate as paymentDate',
						'payments.paymentStudent as studentId',
						'users.fullName as fullName')
						->get();
		}

		$classes = classes::get();
		$toReturn['classes'] = array();
		foreach ($classes as $class) {
			$toReturn['classes'][$class->id] = $class->className ;
		}
		
		$toReturn['students'] = User::where('role','student')->where('activated','1')->get()->toArray();
		return $toReturn;
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		payments::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$studentClass = Input::get('paymentStudent');
		while (list($key, $value) = each($studentClass)) {
			$payments = new payments();
			$payments->paymentTitle = Input::get('paymentTitle');
			$payments->paymentDescription = Input::get('paymentDescription');
			$payments->paymentStudent = $value;
			$payments->paymentAmount = Input::get('paymentAmount');
			$payments->paymentStatus = Input::get('paymentStatus');
			$payments->paymentDate = Input::get('paymentDate');
			$payments->paymentUniqid = uniqid();
			$payments->save();
		}
		return json_encode(array("jsTitle"=>$this->panelInit->language['addPayment'],"jsMessage"=>$this->panelInit->language['paymentCreated'],"payments"=>$this->listAll() ));
	}

	function invoice($id){
		$return = array();
		$return['payment'] = payments::where('id',$id)->first()->toArray();
		$return['siteTitle'] = $this->panelInit->settingsArray['siteTitle'];
		$return['baseUrl'] = URL::to('/');
		$return['address'] = $this->panelInit->settingsArray['address'];
		$return['address2'] = $this->panelInit->settingsArray['address2'];
		$return['phoneNo'] = $this->panelInit->settingsArray['phoneNo'];
		$return['phoneNo'] = $this->panelInit->settingsArray['phoneNo'];
		$return['paypalPayment'] = $this->panelInit->settingsArray['paypalPayment'];
		$return['paymentTax'] = $this->panelInit->settingsArray['paymentTax'];
		$return['amountTax'] = ($this->panelInit->settingsArray['paymentTax']*$return['payment']['paymentAmount']) /100;
		$return['totalWithTax'] = $return['payment']['paymentAmount'] + $return['amountTax'];
		$return['user'] = User::where('id',$return['payment']['paymentStudent'])->first()->toArray();
		
		return $return;
	}

	function fetch($id){
		return payments::where('id',$id)->first();
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$payments = payments::find($id);
		$payments->paymentTitle = Input::get('paymentTitle');
		$payments->paymentDescription = Input::get('paymentDescription');
		$payments->paymentAmount = Input::get('paymentAmount');
		$payments->paymentStatus = Input::get('paymentStatus');
		$payments->paymentDate = Input::get('paymentDate');
		$payments->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editPayment'],"jsMessage"=>$this->panelInit->language['paymentModified'],"payments"=>$this->listAll() ));
	}

	function paymentSuccess($uniqid){
		$payments = payments::where('paymentUniqid',$uniqid)->first();
		if(Input::get('verify_sign')){
			$payments->paymentStatus = 1;
			$payments->paymentSuccessDetails = json_encode(Input::all());
			$payments->save();
		}
		return Redirect::to('/#/payments');
	}

	function PaymentData($id){
		if($this->data['users']->role != "admin") exit;
		$payments = payments::where('id',$id)->first();
		if($payments->paymentSuccessDetails == ""){
			return json_encode(array("jsTitle"=>$this->panelInit->language['paymentDetails'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['noPaymentDetails'] ));
		}else{
			$paymentSuccessDetails = json_decode($payments->paymentSuccessDetails,true);
			return $paymentSuccessDetails;
		}
		exit;
	}

	function paymentFailed(){
		return Redirect::to('/#/payments');
	}

	function export($type){
		if($this->data['users']->role != "admin") exit;
		if($type == "excel"){
			$classArray = array();
			$classes = classes::get();
			foreach ($classes as $class) {
				$classArray[$class->id] = $class->className;
			}

			$data = array(1 => array ('Title','Description','Student','Amount','Date','Status'));
			$payments = \DB::table('payments')
					->leftJoin('users', 'users.id', '=', 'payments.paymentStudent')
					->select('payments.id as id',
					'payments.paymentTitle as paymentTitle',
					'payments.paymentDescription as paymentDescription',
					'payments.paymentAmount as paymentAmount',
					'payments.paymentStatus as paymentStatus',
					'payments.paymentDate as paymentDate',
					'payments.paymentStudent as studentId',
					'users.fullName as fullName')
					->get();
			foreach ($payments as $value) {
				if($value->paymentStatus == 1){
					$paymentStatus = "PAID";
				}else{
					$paymentStatus = "UNPAID";
				}
				$data[] = array ($value->paymentTitle,$value->paymentDescription , $value->fullName,$value->paymentAmount,$value->paymentDate,$paymentStatus );
			}

			$xls = new Excel_XML('UTF-8', false, 'Students Sheet');
			$xls->addArray($data);
			$xls->generateXML('Students-Sheet');
		}elseif ($type == "pdf") {
			$classArray = array();
			$classes = classes::get();
			foreach ($classes as $class) {
				$classArray[$class->id] = $class->className;
			}

			$header = array ('Title','Description','Student','Amount','Date','Status');
			$data = array();
			$payments = \DB::table('payments')
					->leftJoin('users', 'users.id', '=', 'payments.paymentStudent')
					->select('payments.id as id',
					'payments.paymentTitle as paymentTitle',
					'payments.paymentDescription as paymentDescription',
					'payments.paymentAmount as paymentAmount',
					'payments.paymentStatus as paymentStatus',
					'payments.paymentDate as paymentDate',
					'payments.paymentStudent as studentId',
					'users.fullName as fullName')
					->get();
			foreach ($payments as $value) {
				if($value->paymentStatus == 1){
					$paymentStatus = "PAID";
				}else{
					$paymentStatus = "UNPAID";
				}
				$data[] = array ($value->paymentTitle,$value->paymentDescription , $value->fullName,$value->paymentAmount,$value->paymentDate,$paymentStatus );
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
		}
		exit;
	}
}