<?php

class MessagesController extends \BaseController {

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

	
	public function listMessages($page = 1)
	{
		$toReturn = array();
		$toReturn['messages'] = DB::select(DB::raw("SELECT messagesList.id as id,messagesList.lastMessageDate as lastMessageDate,messagesList.lastMessage as lastMessage,messagesList.messageStatus as messageStatus,users.fullName as fullName,users.id as userId FROM messagesList LEFT JOIN users ON users.id=IF(messagesList.userId = '".$this->data['users']->id."',messagesList.toId,messagesList.userId) where userId='".$this->data['users']->id."' order by id DESC limit 20 offset " . 20 * ($page - 1) ));
		$toReturn['totalItems'] = messagesList::where('userId',$this->data['users']->id)->count();
		return json_encode($toReturn);
	}

	public function fetch($messageId,$page = 1)
	{
		$toReturn = array();
		$toReturn['user'] = $this->data['users'];
		$toReturn['messageDet'] = DB::select(DB::raw("SELECT messagesList.id as id,messagesList.lastMessageDate as lastMessageDate,messagesList.userId as fromId,messagesList.toId as toId,users.fullName as fullName,users.id as userId,users.photo as photo FROM messagesList LEFT JOIN users ON users.id=messagesList.toId where messagesList.id='$messageId' AND userId='".$this->data['users']->id."' order by id DESC"));
		if(count($toReturn['messageDet']) > 0){
			$toReturn['messageDet'] = $toReturn['messageDet'][0];
		}else{
			return json_encode(array("jsTitle"=>$this->panelInit->language['readMessage'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['messageNotExist'] ));
			exit;
		}
		$toReturn['messages'] = DB::select(DB::raw("SELECT messages.id as id,messages.fromId as fromId,messages.messageText as messageText,messages.dateSent as dateSent,users.fullName as fullName,users.id as userId,users.photo as photo FROM messages LEFT JOIN users ON users.id=messages.fromId where messages.userId='".$this->data['users']->id."' AND ( (messages.fromId='".$this->data['users']->id."' OR messages.fromId='".$toReturn['messageDet']->toId."' ) AND (messages.toId='".$this->data['users']->id."' OR messages.toId='".$toReturn['messageDet']->toId."' ) ) order by id DESC limit 20"));
		return json_encode($toReturn);
	}

	public function reply($id){
		$messages = new messages();
		$messages->messageId = $id;
		$messages->userId = $this->data['users']->id;
		$messages->fromId = $this->data['users']->id;
		$messages->toId = Input::get('toId');
		$messages->messageText = Input::get('reply');
		$messages->dateSent = time();
		$messages->save();
		
		$messages = new messages();
		$messages->messageId = $id;
		$messages->userId = Input::get('toId');
		$messages->fromId = $this->data['users']->id;
		$messages->toId = Input::get('toId');
		$messages->messageText = Input::get('reply');
		$messages->dateSent = time();
		$messages->save();

		$messagesList = messagesList::where('userId',$this->data['users']->id)->where('toId',Input::get('toId'));
		if($messagesList->count() == 0){
			$messagesList = new messagesList();
			$messagesList->userId = $this->data['users']->id;
			$messagesList->toId = Input::get('toId');
		}else{
			$messagesList = $messagesList->first();
		}
		$messagesList->lastMessage = Input::get('reply');
		$messagesList->lastMessageDate = time();
		$messagesList->messageStatus = 0;
		$messagesList->save();

		$messagesList_ = messagesList::where('userId',Input::get('toId'))->where('toId',$this->data['users']->id);
		if($messagesList_->count() == 0){
			$messagesList_ = new messagesList();
			$messagesList_->userId = Input::get('toId');
			$messagesList_->toId = $this->data['users']->id;
		}else{
			$messagesList_ = $messagesList_->first();
		}
		$messagesList_->lastMessage = Input::get('reply');
		$messagesList_->lastMessageDate = time();
		$messagesList_->messageStatus = 1;
		$messagesList_->save();

		echo 1;
		exit;
	}

	public function before($from,$to,$before = 0){
		return DB::select(DB::raw("SELECT messages.id as id,messages.fromId as fromId,messages.messageText as messageText,messages.dateSent as dateSent,users.fullName as fullName,users.id as userId,users.photo as photo FROM messages LEFT JOIN users ON users.id=messages.fromId where userId='".$this->data['users']->id."' AND ( (fromId='$from' OR fromId='$to' ) AND (toId='$from' OR toId='$to' ) ) AND dateSent < '$before' order by id DESC limit 20"));
	}

	public function ajax($from,$to,$after = 0){
		$messagesList = messagesList::where('userId',$this->data['users']->id)->where('toId',$to)->first();
		$messagesList->messageStatus = 0;
		$messagesList->save();
		return DB::select(DB::raw("SELECT messages.id as id,messages.fromId as fromId,messages.messageText as messageText,messages.dateSent as dateSent,users.fullName as fullName,users.id as userId,users.photo as photo FROM messages LEFT JOIN users ON users.id=messages.fromId where userId='".$this->data['users']->id."' AND ( (fromId='$from' OR fromId='$to' ) AND (toId='$from' OR toId='$to' ) ) AND dateSent>'$after' order by id DESC"));
	}

	public function read(){
		if(Input::get('items')){
			if(count(Input::get('items')) > 0){
				$items = implode(",",Input::get('items'));
				DB::update(DB::raw("UPDATE messagesList SET messageStatus='0' where id IN (".$items.")"));
			}
		}
		echo 1;
		exit;
	}

	public function unread(){
		if(Input::get('items')){
			if(count(Input::get('items')) > 0){
				$items = implode(",",Input::get('items'));
				DB::update(DB::raw("UPDATE messagesList SET messageStatus='1' where id IN (".$items.")"));
			}
		}
		echo 1;
		exit;
	}

	public function delete(){
		if(Input::get('items')){
			if(count(Input::get('items')) > 0){
				$arr = Input::get('items');
				while (list(, $value) = each($arr)) {
					$messagesList = messagesList::where('id',$value)->first();
					DB::delete(DB::raw("DELETE from messages where userId='".$this->data['users']->id."' AND ( (fromId = '".$messagesList->userId."' AND toId = '".$messagesList->toId."') OR (fromId = '".$messagesList->toId."' AND toId = '".$messagesList->userId."') ) "));
					DB::delete(DB::raw("DELETE from messagesList where id = '$value'"));
				}
			}
		}
		echo 1;
		exit;
	}

	public function create(){
		$users = User::where('username',Input::get('toId'))->orWhere('email',Input::get('toId'));
		if($users->count() == 0){
			echo $this->panelInit->language['userisntExist'];
			exit;
		}
		$users = $users->first();

		$messagesList = messagesList::where('userId',$this->data['users']->id)->where('toId',$users->id);
		if($messagesList->count() == 0){
			$messagesList = new messagesList();
			$messagesList->userId = $this->data['users']->id;
			$messagesList->toId = $users->id;
		}else{
			$messagesList = $messagesList->first();
		}
		$messagesList->lastMessage = Input::get('messageText');
		$messagesList->lastMessageDate = time();
		$messagesList->messageStatus = 0;
		$messagesList->save();
		$toReturnId = $messagesList->id;

		$messagesList_ = messagesList::where('userId',$users->id)->where('toId',$this->data['users']->id);
		if($messagesList_->count() == 0){
			$messagesList_ = new messagesList();
			$messagesList_->userId = $users->id;
			$messagesList_->toId = $this->data['users']->id;
		}else{
			$messagesList_ = $messagesList_->first();
		}
		$messagesList_->lastMessage = Input::get('messageText');
		$messagesList_->lastMessageDate = time();
		$messagesList_->messageStatus = 1;
		$messagesList_->save();
		$toReturnId_ = $messagesList_->id;		

		$messages = new messages();
		$messages->messageId = $toReturnId;
		$messages->userId = $this->data['users']->id;
		$messages->fromId = $this->data['users']->id;
		$messages->toId = $users->id;
		$messages->messageText = Input::get('messageText');
		$messages->dateSent = time();
		$messages->save();

		$messages = new messages();
		$messages->messageId = $toReturnId_;
		$messages->userId = $users->id;
		$messages->fromId = $this->data['users']->id;
		$messages->toId = $users->id;
		$messages->messageText = Input::get('messageText');
		$messages->dateSent = time();
		$messages->save();
		
		return json_encode(array('messageId'=>$toReturnId));
	}

}