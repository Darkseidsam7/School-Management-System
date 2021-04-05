<?php

class DashboardController extends \BaseController {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';
	
	public function __construct(){
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['User Settings'] = \URL::to('/dashboard/user');
		$this->data['users'] = \Auth::user();
	}
	
	public function index($method = "main")
	{
		$languages = languages::where('id',1)->first()->toArray();
		$languages['languagePhrases'] = json_decode($languages['languagePhrases'],true);
		
		if($this->data['users']->role == "admin" AND $this->panelInit->version != $this->panelInit->settingsArray['latestVersion']){
			$this->data['latestVersion'] = $this->panelInit->settingsArray['latestVersion'];
		}
		$this->panelInit->viewop($this->layout,'welcome',$this->data);
	}

	public function baseUser()
	{
		return array("fullName"=>$this->data['users']->fullName,"username"=>$this->data['users']->username,"role"=>$this->data['users']->role);
	}

	public function dashboardData(){
		$toReturn = array();
		$toReturn['language'] = $this->panelInit->language;
		$toReturn['role'] = $this->data['users']->role;
		$toReturn['classes'] = classes::count();
		$toReturn['students'] = User::where('role','student')->where('activated',1)->count();
		$toReturn['teachers'] = User::where('role','teacher')->where('activated',1)->count();
		$toReturn['newMessages'] = messagesList::where('userId',$this->data['users']->id)->where('messageStatus',1)->count();

		$toReturn['teacherLeaderBoard'] = User::where('role','teacher')->where('isLeaderBoard','!=','')->where('isLeaderBoard','!=','0')->first();
		if(count($toReturn['teacherLeaderBoard'])){
			$toReturn['teacherLeaderBoard'] = $toReturn['teacherLeaderBoard']->toArray();
		}
		$toReturn['studentLeaderBoard'] = User::where('role','student')->where('isLeaderBoard','!=','')->where('isLeaderBoard','!=','0')->first();
		if(count($toReturn['studentLeaderBoard'])){
			$toReturn['studentLeaderBoard'] = $toReturn['studentLeaderBoard']->toArray();
		}
		
		$toReturn['newsEvents'] = array();
		$newsboard = newsboard::where('newsFor',$this->data['users']->role)->orWhere('newsFor','all')->orderBy('id','desc')->get();
		foreach ($newsboard as $event ) {
			$eventsArray['id'] =  $event->id;
			$eventsArray['title'] =  $event->newsTitle;
			$eventsArray['type'] =  "news";
	    	$eventsArray['start'] = date("F j, Y", strtotime($event->newsDate));
	    	$toReturn['newsEvents'][] = $eventsArray;
		}

		$events = events::orderBy('id','desc')->where('eventFor',$this->data['users']->role)->orWhere('eventFor','all')->get();
		foreach ($events as $event ) {
	    	$eventsArray['id'] =  $event->id;
			$eventsArray['title'] =  $event->eventTitle;
			$eventsArray['type'] =  "event";
		    $eventsArray['start'] = date("F j, Y", strtotime($event->eventDate));
		    $toReturn['newsEvents'][] = $eventsArray;
		}
		
		$toReturn['baseUser'] = array("id"=>$this->data['users']->id,"fullName"=>$this->data['users']->fullName,"username"=>$this->data['users']->username);

		$polls = polls::where('pollTarget',$this->data['users']->role)->orWhere('pollTarget','all')->where('pollStatus','1')->first();
		if(count($polls) > 0){
			$toReturn['polls']['title'] = $polls->pollTitle;
			$toReturn['polls']['id'] = $polls->id;
			$toReturn['polls']['view'] = "vote";
			$userVoted = json_decode($polls->userVoted,true);
			if(is_array($userVoted) AND in_array($this->data['users']->id,$userVoted)){
				$toReturn['polls']['voted'] = true;
				$toReturn['polls']['view'] = "results";
			}
			$toReturn['polls']['items'] = json_decode($polls->pollOptions,true);
			$toReturn['polls']['totalCount'] = 0;
			while (list($key, $value) = each($toReturn['polls']['items'])) {
				if(isset($value['count'])){
					$toReturn['polls']['totalCount'] += $value['count'];
				}
				if(!isset($toReturn['polls']['items'][$key]['prec'])){
					$toReturn['polls']['items'][$key]['prec'] = 0;
				}
			}

		}

		return json_encode($toReturn);
	}

	public function savePolls(){
		$toReturn = array();

		$polls = polls::where('pollTarget',$this->data['users']->role)->orWhere('pollTarget','all')->where('pollStatus','1')->where('id',Input::get('id'))->first();
		if(count($polls) > 0){
			$userVoted = json_decode($polls->userVoted,true);
			if(!is_array($userVoted)){
				$userVoted = array();
			}
			if(is_array($userVoted) AND in_array($this->data['users']->id,$userVoted)){
				return json_encode(array("jsTitle"=>$this->panelInit->language['votePoll'],"jsMessage"=>$this->panelInit->language['alreadyvoted']));
				exit;
			}
			$userVoted[] = $this->data['users']->id;
			$polls->userVoted = json_encode($userVoted);


			$toReturn['polls']['items'] = json_decode($polls->pollOptions,true);
			$toReturn['polls']['totalCount'] = 0;
			while (list($key, $value) = each($toReturn['polls']['items'])) {
				if($value['title'] == Input::get('selected')){
					if(!isset($toReturn['polls']['items'][$key]['count'])) $toReturn['polls']['items'][$key]['count'] = 0;
					$toReturn['polls']['items'][$key]['count']++;
				}
				if(isset($toReturn['polls']['items'][$key]['count'])){
					$toReturn['polls']['totalCount'] += $toReturn['polls']['items'][$key]['count'];
				}				
			}
			reset($toReturn['polls']['items']);
			while (list($key, $value) = each($toReturn['polls']['items'])) {
				if(isset($toReturn['polls']['items'][$key]['count'])){
					$toReturn['polls']['items'][$key]['perc'] = ($toReturn['polls']['items'][$key]['count'] * 100) / $toReturn['polls']['totalCount'];
				}
			}
			$polls->pollOptions = json_encode($toReturn['polls']['items']);
			$polls->save();

			$toReturn['polls']['title'] = $polls->pollTitle;
			$toReturn['polls']['id'] = $polls->id;
			$toReturn['polls']['view'] = "results";
			$toReturn['polls']['voted'] = true;
		}

		return $toReturn['polls'];
		exit;
	}

	
	public function calender()
	{
		$toReturn = array();

		if($this->data['users']->role == "admin"){
			$assignments = assignments::get();
		}elseif($this->data['users']->role == "teacher"){
			$assignments = assignments::where('teacherId',$this->data['users']->id)->get();
		}elseif($this->data['users']->role == "student"){
			$assignments = assignments::where('classId','like','%"'.$this->data['users']->studentClass.'"%')->get();
		}
		if(isset($assignments)){
			foreach ($assignments as $event ) {
				$eventsArray['id'] =  $event->id;
				$eventsArray['title'] =  "Assignment : ".$event->AssignTitle;
		    $eventsArray['start'] = date("c", strtotime($event->AssignDeadLine));
		    $eventsArray['backgroundColor'] = 'green';
		    $eventsArray['textColor'] = '#fff';
		    $eventsArray['allDay'] = true;
		    $toReturn[] = $eventsArray;
			}
		}

		$events = events::where('eventFor',$this->data['users']->role)->orWhere('eventFor','all')->get();
		foreach ($events as $event ) {
			$eventsArray['id'] =  $event->id;
			$eventsArray['title'] =  "Event : ".$event->eventTitle;
	    $eventsArray['start'] = date("c", strtotime($event->eventDate));
	    $eventsArray['backgroundColor'] = 'blue';
	    $eventsArray['textColor'] = '#fff';
	    $eventsArray['allDay'] = true;
	    $toReturn[] = $eventsArray;
		}

		$examsList = examsList::get();
		foreach ($examsList as $event ) {
			$eventsArray['id'] =  $event->id;
			$eventsArray['title'] =  "Exam : ".$event->examTitle;
	    $eventsArray['start'] = date("c", strtotime($event->examDate));
	    $eventsArray['backgroundColor'] = 'red';
	    $eventsArray['textColor'] = '#fff';
	    $eventsArray['allDay'] = true;
	    $toReturn[] = $eventsArray;
		}

		$newsboard = newsboard::where('newsFor',$this->data['users']->role)->orWhere('newsFor','all')->get();
		foreach ($newsboard as $event ) {
			$eventsArray['id'] =  $event->id;
			$eventsArray['title'] =  "News : ".$event->newsTitle;
	    $eventsArray['start'] = date("c", strtotime($event->newsDate));
	    $eventsArray['backgroundColor'] = 'white';
	    $eventsArray['textColor'] = '#000';
	    $eventsArray['allDay'] = true;
	    $toReturn[] = $eventsArray;
		}

		if($this->data['users']->role == "admin"){
			$onlineExams = onlineExams::get();
		}elseif($this->data['users']->role == "teacher"){
			$onlineExams = onlineExams::where('examTeacher',$this->data['users']->id)->get();
		}elseif($this->data['users']->role == "student"){
			$onlineExams = onlineExams::where('examClass','like','%"'.$this->data['users']->studentClass.'"%')->get();
		}
		if(isset($onlineExams)){
			foreach ($onlineExams as $event ) {
				$eventsArray['id'] =  $event->id;
				$eventsArray['title'] =  "Online Exam : ".$event->examTitle;
		    $eventsArray['start'] = date("c", strtotime($event->examDate));
		    $eventsArray['backgroundColor'] = 'red';
		    $eventsArray['textColor'] = '#000';
		    $eventsArray['allDay'] = true;
		    $toReturn[] = $eventsArray;
			}
		}
		
		return $toReturn;
	}

	public function image($section,$image){
		if(!file_exists("uploads/".$section."/".$image)){
			$ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
			if ($ext == "jpg" || $ext == "jpeg") {
	    	header('Content-type: image/jpg');
	    } elseif ($ext == "png") {
	      header('Content-type: image/png');
	    } elseif ($ext == "gif") {
	      header('Content-type: image/gif');
	    }
	    if($section == "profile"){
				echo file_get_contents("uploads/".$section."/user.png");
			}
			if($section == "media"){
				echo file_get_contents("uploads/".$section."/default.png");
			}
		}
		exit;
	}

	public function readNewsEvent($type,$id){
		if($type == "news"){
			return newsboard::where('id',$id)->first();
		}
		if($type == "event"){
			return events::where('id',$id)->first();
		}
	}
}