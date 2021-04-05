<?php

class StaticPagesController extends \BaseController {

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
		if($this->data['users']->role != "admin") exit;
		$this->panelInit->viewop($this->layout,'languages',$this->data);
	}

	
	public function listAll()
	{
		if($this->data['users']->role != "admin") exit;
		return staticPages::get();
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		staticPages::find($id)->delete();	
		return 1;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$staticPages = new staticPages();
		$staticPages->pageTitle = Input::get('pageTitle');
		$staticPages->pageContent = Input::get('pageContent');
		$staticPages->pageActive = Input::get('pageActive');
		$staticPages->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['addPage'],"jsMessage"=>$this->panelInit->language['pageCreated'],"staticPages"=>staticPages::get()->toArray() ));
	}

	function fetch($id){
		return staticPages::where('id',$id)->first();
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$staticPages = staticPages::find($id);
		$staticPages->pageTitle = Input::get('pageTitle');
		$staticPages->pageContent = Input::get('pageContent');
		$staticPages->pageActive = Input::get('pageActive');
		$staticPages->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editPage'],"jsMessage"=>$this->panelInit->language['pageModified'],"staticPages"=>staticPages::get()->toArray() ));
	}

	function active($id){
		if($this->data['users']->role != "admin") exit;
		$staticPagesData = staticPages::find($id)->first();

		$staticPages = staticPages::find($id);
		if($staticPagesData->pageActive == 1){
			$staticPages->pageActive = 0;
		}else{
			$staticPages->pageActive = 1;
		}
		$staticPages->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['activeInactivePage'],"jsMessage"=>$this->panelInit->language['pageChanged'],"staticPages"=>staticPages::get()->toArray() ));
	}
}