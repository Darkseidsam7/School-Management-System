<?php

class EventsController extends \BaseController {

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
		if($this->data['users']->role == "admin" ){
			$toReturn['events'] = events::get()->toArray();
		}else{
			$toReturn['events'] = events::where('eventFor',$this->data['users']->role)->orWhere('eventFor','all')->get()->toArray();
		}

		foreach ($toReturn['events'] as $key => $item) {
			$toReturn['events'][$key]['eventDescription'] = strip_tags(htmlspecialchars_decode($toReturn['events'][$key]['eventDescription'],ENT_QUOTES));
		}

		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		events::find($id)->delete();
		return 1;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$events = new events();
		$events->eventTitle = Input::get('eventTitle');
		$events->eventDescription = htmlspecialchars(Input::get('eventDescription'),ENT_QUOTES);
		$events->eventFor = Input::get('eventFor');
		$events->enentPlace = Input::get('enentPlace');
		$events->eventDate = Input::get('eventDate');
		$events->save();
		
		return json_encode(array("jsTitle"=>$this->panelInit->language['addEvent'],"jsMessage"=>$this->panelInit->language['eventCreated'],"list"=>$this->listAll() ));
	}

	function fetch($id){
		$data = events::where('id',$id)->first()->toArray();
		$data['eventDescription'] = htmlspecialchars_decode($data['eventDescription'],ENT_QUOTES);
		return json_encode($data);
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$events = events::find($id);
		$events->eventTitle = Input::get('eventTitle');
		$events->eventDescription = htmlspecialchars(Input::get('eventDescription'),ENT_QUOTES);
		$events->eventFor = Input::get('eventFor');
		$events->enentPlace = Input::get('enentPlace');
		$events->eventDate = Input::get('eventDate');
		$events->save();

		return json_encode(array("jsTitle"=>$this->panelInit->language['editEvent'],"jsMessage"=>$this->panelInit->language['eventModified'],"list"=>$this->listAll() ));
	}
}