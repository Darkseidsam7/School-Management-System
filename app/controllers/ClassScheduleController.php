<?php

class ClassScheduleController extends \BaseController {

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
		$toReturn['subject'] = subject::get()->toArray();
		$toReturn['days'] = $arrayOfDays = array(0=>$this->panelInit->language['Sunday'],1=>$this->panelInit->language['Monday'],2=>$this->panelInit->language['Tuesday'],3=>$this->panelInit->language['Wednesday'],4=>$this->panelInit->language['Thurusday'],5=>$this->panelInit->language['Friday'],6=>$this->panelInit->language['Saturday']);
		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
	}

	function fetch($id){
		$arrayOfDays = array(0=>$this->panelInit->language['Sunday'],1=>$this->panelInit->language['Monday'],2=>$this->panelInit->language['Tuesday'],3=>$this->panelInit->language['Wednesday'],4=>$this->panelInit->language['Thurusday'],5=>$this->panelInit->language['Friday'],6=>$this->panelInit->language['Saturday']);

		$subjectArray = array();
		$subjectObject = subject::get();
		foreach ($subjectObject as $subject) {
			$subjectArray[$subject->id] = $subject->subjectTitle;
		}

		$toReturn = array(0=>array('dayName'=>$arrayOfDays[0],'data'=>array()),1=>array('dayName'=>$arrayOfDays[1]),2=>array('dayName'=>$arrayOfDays[2]),3=>array('dayName'=>$arrayOfDays[3]),4=>array('dayName'=>$arrayOfDays[4]),5=>array('dayName'=>$arrayOfDays[5]),6=>array('dayName'=>$arrayOfDays[6]) );
		$classSchedule = classSchedule::where('classId',$id)->orderBy('startTime')->get();
		foreach ($classSchedule as $schedule) {
			$toReturn[$schedule->dayOfWeek]['sub'][] = array('id'=>$schedule->id,'classId'=>$schedule->classId,'subjectId'=> isset($subjectArray[$schedule->subjectId])?$subjectArray[$schedule->subjectId]:"" ,'start'=>wordwrap($schedule->startTime,2,':',true),'end'=>wordwrap($schedule->endTime,2,':',true) );
		}

		return $toReturn;
	}

	function addSub($class){
		if($this->data['users']->role != "admin") exit;
		$classSchedule = new classSchedule();
		$classSchedule->classId = $class;
		$classSchedule->subjectId = Input::get('subjectId');
		$classSchedule->dayOfWeek = Input::get('dayOfWeek');
		
		$startTime = "";
		if(Input::get('startTimeHour') < 10){
			$startTime .= "0";
		}
		$startTime .= Input::get('startTimeHour');
		if(Input::get('startTimeMin') < 10){
			$startTime .= "0";
		}
		$startTime .= Input::get('startTimeMin');
		$classSchedule->startTime = $startTime;

		$endTime = "";
		if(Input::get('endTimeHour') < 10){
			$endTime .= "0";
		}
		$endTime .= Input::get('endTimeHour');
		if(Input::get('endTimeMin') < 10){
			$endTime .= "0";
		}
		$endTime .= Input::get('endTimeMin');
		$classSchedule->endTime = $endTime;
		$classSchedule->save();
		
		return $this->fetch($class);		
	}

	public function delete($class,$id){
		if($this->data['users']->role != "admin") exit;
		classSchedule::find($id)->delete();
		return $this->fetch($class);
	}

	function fetchSub($id){
		$sub = classSchedule::where('id',$id)->first()->toArray();
		$sub['startTime'] = str_split($sub['startTime'],2);
		$sub['startTimeHour'] = intval($sub['startTime'][0]);
		$sub['startTimeMin'] = intval($sub['startTime'][1]);
		
		$sub['endTime'] = str_split($sub['endTime'],2);
		$sub['endTimeHour'] = intval($sub['endTime'][0]);
		$sub['endTimeMin'] = intval($sub['endTime'][1]);

		return json_encode($sub);
	}

	function editSub($id){
		if($this->data['users']->role != "admin") exit;
		$classSchedule = classSchedule::find($id);
		$classSchedule->subjectId = Input::get('subjectId');
		$classSchedule->dayOfWeek = Input::get('dayOfWeek');
		
		$startTime = "";
		if(Input::get('startTimeHour') < 10){
			$startTime .= "0";
		}
		$startTime .= Input::get('startTimeHour');
		if(Input::get('startTimeMin') < 10){
			$startTime .= "0";
		}
		$startTime .= Input::get('startTimeMin');
		$classSchedule->startTime = $startTime;

		$endTime = "";
		if(Input::get('endTimeHour') < 10){
			$endTime .= "0";
		}
		$endTime .= Input::get('endTimeHour');
		if(Input::get('endTimeMin') < 10){
			$endTime .= "0";
		}
		$endTime .= Input::get('endTimeMin');
		$classSchedule->endTime = $endTime;
		$classSchedule->save();
		
		return $this->fetch(Input::get('classId'));		
	}

	function getClassesList(){
		
	}
}