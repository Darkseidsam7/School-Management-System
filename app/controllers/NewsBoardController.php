<?php

class NewsBoardController extends \BaseController {

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

	
	public function listAll($page = 1)
	{
		$toReturn = array();
		if($this->data['users']->role == "admin" ){
			$toReturn['newsboard'] = newsboard::take('20')->skip(20* ($page - 1) )->get()->toArray();
		}else{
			 $toReturn['newsboard'] = newsboard::where('newsFor',$this->data['users']->role)->orWhere('newsFor','all')->take('20')->skip(20* ($page - 1) )->get()->toArray();
		}

		foreach ($toReturn['newsboard'] as $key => $item) {
			$toReturn['newsboard'][$key]['newsText'] = strip_tags(htmlspecialchars_decode($toReturn['newsboard'][$key]['newsText'],ENT_QUOTES));
		}

		$toReturn['userRole'] = $this->data['users']->role;
		$toReturn['totalItems'] = newsboard::count();
		return $toReturn;
	}

	public function delete($id){
		newsboard::find($id)->delete();	
		return 1;
		exit;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$newsboard = new newsboard();
		$newsboard->newsTitle = Input::get('newsTitle'); 
		$newsboard->newsText = htmlspecialchars(Input::get('newsText'),ENT_QUOTES);
		$newsboard->newsFor = Input::get('newsFor');
		if(Input::get('newsDate') != ""){
			$newsDate = explode("/", Input::get('newsDate'));
			$newsDate = mktime(0,0,0,$newsDate['0'],$newsDate['1'],$newsDate['2']);
			$newsboard->newsDate = $newsDate;
		}
		$newsboard->creationDate = time();
		$newsboard->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addNews'],"jsMessage"=>$this->panelInit->language['newsCreated'],"list"=>$this->listAll() ));
	}

	function fetch($id){
		$data = newsboard::where('id',$id)->first()->toArray();
		$data['newsText'] = htmlspecialchars_decode($data['newsText'],ENT_QUOTES);
		$data['newsDate'] = date('m/d/Y',$data['newsDate']);
		return json_encode($data);
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$newsboard = newsboard::find($id);
		$newsboard->newsTitle = Input::get('newsTitle');
		$newsboard->newsText = htmlspecialchars(Input::get('newsText'),ENT_QUOTES);
		$newsboard->newsFor = Input::get('newsFor');
		if(Input::get('newsDate') != ""){
			$newsDate = explode("/", Input::get('newsDate'));
			$newsDate = mktime(0,0,0,$newsDate['0'],$newsDate['1'],$newsDate['2']);
			$newsboard->newsDate = $newsDate;
		}
		$newsboard->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editNews'],"jsMessage"=>$this->panelInit->language['newsModified'],"list"=>$this->listAll() ));
	}
}