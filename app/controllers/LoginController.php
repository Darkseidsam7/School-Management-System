<?php

class LoginController extends BaseController {

	var $data = array();

	public function __construct(){
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
	}

	public function index()
	{
		$check = Schema::hasTable('users');
		if(!$check){
			return Redirect::to('/install');
			exit;
		}

		return View::make('login', $this->data);
	}

	public function attemp()
	{
		if (filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)) {
			if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'),'activated'=>1),Input::get('remember_me')))
			{
				return Redirect::to('/');
			}else{
				return Redirect::to('/login')->withErrors(array($this->panelInit->language['chkUserPass']));
			}
		}else{
			if (Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password'),'activated'=>1),Input::get('remember_me')))
			{
				return Redirect::to('/');
			}else{
				return Redirect::to('/login')->withErrors(array($this->panelInit->language['chkUserPass']));
			}
		}
		
	}
	
	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	public function forgetpwd()
	{
		return View::make('forgetpwd', $this->data);
	}

	public function forgetpwdStepOne()
	{
		if (filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)) {
			$ifUserExists = User::where('email',Input::get('email'));
		}else{
			$ifUserExists = User::where('username',Input::get('email'));
		}
		if($ifUserExists->count() == 0){
			return Redirect::to('/forgetpwd')->withErrors(array($this->panelInit->language['chkUserMail']));
		}else{
			$uniqid = uniqid().".".time();

			$ifUserExistsGet = $ifUserExists->first();
			$ifUserExistsGet->restoreUniqId = $uniqid;
			$ifUserExistsGet->save();

			$restoreUrl = URL::to('/forgetpwd/'.$uniqid);

			$messageBody = "Dear Sir, <br/><br/> Please follow the follwoing link to restore your password : <br/><br/>
			<a href='$restoreUrl'>$restoreUrl</a> <br/><br/>Regards,<br/> Management";
			
			$SmsHandler = new MailSmsHandler();
			$SmsHandler->mail($ifUserExistsGet->email,$this->panelInit->settingsArray['siteTitle']." | Restore Password",$messageBody,$ifUserExistsGet->fullName);  

			$this->data['success'] = $this->panelInit->language['chkMailRestore'];
			return View::make('forgetpwd', $this->data);
		}
	}

	public function forgetpwdStepTwo($uniqid){
		$ifUserExists = User::where('restoreUniqId',$uniqid);
		if($ifUserExists->count() > 0){
			$uniqidExploded = explode(".", $uniqid);
			if($uniqidExploded[1] + 86400 > time()){
				if(Input::get('password') || Input::get('rePassword')){
					if(Input::get('password') == "" || Input::get('rePassword') == "" || Input::get('password') != Input::get('rePassword')){
						$this->data['errorsList'] = $this->panelInit->language['chkInputFields'];
						return View::make('forgetpwdContinue', $this->data);
					}else{
						$ifUserExistsGet = $ifUserExists->first();
						$ifUserExistsGet->restoreUniqId = "";
						$ifUserExistsGet->password = Hash::make(Input::get('password'));
						$ifUserExistsGet->save();
						$this->data['success'] = $this->panelInit->language['pwdChangedSuccess'];
						return View::make('forgetpwd', $this->data);
					}
				}else{
					return View::make('forgetpwdContinue', $this->data);
				}
			}else{
				$this->data['success'] = $this->panelInit->language['expRestoreId'];
				return View::make('forgetpwd', $this->data);
			}
		}else{
			$this->data['success'] = $this->panelInit->language['invRstoreId'];
			return View::make('forgetpwd', $this->data);
		}
	}

	public function register(){
		return View::make('register', $this->data);
	}

	public function registerPost(){
		if(Input::get('role') == ""){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mustSelAccType'] ));
			exit;
		}
		if(Input::get('username') == ""){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mustSelUsername'] ));
			exit;
		}
		if(Input::get('password') == ""){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mustTypePwd'] ));
			exit;
		}
		if(Input::get('fullName') == ""){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mustTypeFullName'] ));
			exit;
		}
		if (!filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL) AND Input::get('email') != "") {
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['invEmailAdd'] ));
			exit;
		}
		if(User::where('username',trim(Input::get('username')))->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['usernameUsed'] ));
			exit;
		}
		if(User::where('email',Input::get('email'))->count() > 0){
			return json_encode(array("jsTitle"=>$this->panelInit->language['registerAcc'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['mailUsed'] ));
			exit;
		}
		
		$user = new User();
		$user->username = Input::get('username');
		if(Input::get('email') == ""){
			$user->email = "";
		}else{
			$user->email = Input::get('email');
		}
		$user->password = Hash::make(Input::get('password'));
		$user->fullName = Input::get('fullName');
		$user->role = Input::get('role');
		$user->activated = 0;
		$user->studentRollId = Input::get('studentRollId');
		if(Input::get('birthday') != ""){
			$birthday = explode("/", Input::get('birthday'));
			$birthday = mktime(0,0,0,$birthday['0'],$birthday['1'],$birthday['2']);
			$user->birthday = $birthday;
		}
		$user->gender = Input::get('gender');
		$user->address = Input::get('address');
		$user->phoneNo = Input::get('phoneNo');
		$user->mobileNo = Input::get('mobileNo');
		$user->studentClass = Input::get('studentClass');
		$user->parentProfession = Input::get('parentProfession');

		if(Input::get('studentInfo') != ""){
			$user->parentOf = json_encode(Input::get('studentInfo'));
		}

		$user->save();
		$array = array("id"=>$user->id);
		return $array;
		exit;
	}

	public function registerClasses(){
		return classes::get();
	}

	public function terms(){
		$settings = settings::where('fieldName','schoolTerms')->first()->toArray();
		$this->data['terms'] = htmlspecialchars_decode($settings['fieldValue'],ENT_QUOTES);
		return View::make('terms', $this->data);
	}

	public function searchStudents($student){
		$students = User::where('role','student')->where('fullName','like','%'.$student.'%')->orWhere('username','like','%'.$student.'%')->orWhere('email','like','%'.$student.'%')->get();
		$retArray = array();
		foreach ($students as $student) {
			$retArray[$student->id] = array("id"=>$student->id,"name"=>$student->fullName,"email"=>$student->email);
		}
		return json_encode($retArray);
	}

}