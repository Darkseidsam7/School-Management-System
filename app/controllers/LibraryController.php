<?php

class LibraryController extends \BaseController {

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
		$toReturn['bookLibrary'] = bookLibrary::orderBy('id','DESC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
		$toReturn['totalItems'] = bookLibrary::count();
		$toReturn['userRole'] = $this->data['users']->role;
		return $toReturn;
	}

	public function delete($id){
		if($this->data['users']->role != "admin") exit;
		$found = bookLibrary::find($id);
		$foundGet = $found->get();
		@unlink('uploads/books/'.$foundGet->bookFile);
		$found->delete();	
		return 1;
		exit;
	}

	public function create(){
		if($this->data['users']->role != "admin") exit;
		$bookLibrary = new bookLibrary();
		$bookLibrary->bookName = Input::get('bookName');
		$bookLibrary->bookDescription = Input::get('bookDescription');
		$bookLibrary->bookAuthor = Input::get('bookAuthor');
		$bookLibrary->bookType = Input::get('bookType');
		$bookLibrary->bookPrice = Input::get('bookPrice');
		$bookLibrary->bookState = Input::get('bookState');
		$bookLibrary->save();

		if (Input::hasFile('bookFile')) {
			$fileInstance = Input::file('bookFile');
			$newFileName = "book_".uniqid().".".$fileInstance->getClientOriginalExtension();
			$fileInstance->move('uploads/books/',$newFileName);

			$bookLibrary->bookFile = $newFileName;
			$bookLibrary->save();
		}
		return json_encode(array("jsTitle"=>$this->panelInit->language['addBook'],"jsMessage"=>$this->panelInit->language['bookAdded'],"list"=>$this->listAll() ));
	}

	function fetch($id){
		$data = bookLibrary::where('id',$id)->first()->toArray();
		return json_encode($data);
	}

	function edit($id){
		if($this->data['users']->role != "admin") exit;
		$bookLibrary = bookLibrary::find($id);
		$bookLibrary->bookName = Input::get('bookName');
		$bookLibrary->bookDescription = Input::get('bookDescription');
		$bookLibrary->bookAuthor = Input::get('bookAuthor');
		$bookLibrary->bookType = Input::get('bookType');
		$bookLibrary->bookPrice = Input::get('bookPrice');
		$bookLibrary->bookState = Input::get('bookState');
		if (Input::hasFile('bookFile')) {
			@unlink("uploads/books/".$bookLibrary->bookFile);
			$fileInstance = Input::file('bookFile');
			$newFileName = "book_".uniqid().".".$fileInstance->getClientOriginalExtension();
			$fileInstance->move('uploads/books/',$newFileName);

			$bookLibrary->bookFile = $newFileName;
		}
		$bookLibrary->save();
		return json_encode(array("jsTitle"=>$this->panelInit->language['editBook'],"jsMessage"=>$this->panelInit->language['bookModified'],"list"=>$this->listAll() ));
	}
}