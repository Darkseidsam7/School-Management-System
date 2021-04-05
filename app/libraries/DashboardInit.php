<?php
class DashboardInit {
	
	public $panelItems;
	public $settingsArray = array();
	public $language;
	public $version = "1.4";
	public $teacherClasses = array();
	public $isRTL;
	
	public function __construct(){
		$this->panelItems = array(
									"dashboard"=>array("title"=>"dashboard","icon"=>"fa fa-dashboard","url"=> URL::to('#'),"permissions"=>array('admin','teacher','student','parent') ),
									"staticContent"=>array("title"=>"staticPages","icon"=>"fa fa-file-text","activated"=>"staticpagesAct","url"=> URL::to('#'),"permissions"=>array('admin','teacher','student','parent'),
													"children"=>array(
															"controlStatic"=>array("title"=>"controlPages","url"=>URL::to('#static'),"icon"=>"fa fa-cog","permissions"=>array('admin') )
														)
									),
									"messages"=>array("title"=>"Messages","url"=>URL::to('#messages'),"icon"=>"fa fa-envelope","permissions"=>array('admin','teacher','student','parent') ),
									"calender"=>array("title"=>"Calender","url"=>URL::to('#calender'),"icon"=>"fa fa-calendar","permissions"=>array('admin','teacher','student','parent') ),
									"classSchedule"=>array("title"=>"classSch","url"=>URL::to('#classschedule'),"icon"=>"fa fa-list","permissions"=>array('admin','teacher','student','parent') ),
									"attendance"=>array("title"=>"Attendance","url"=>URL::to('#attendance'),"icon"=>"fa fa-bar-chart","activated"=>"attendanceAct","permissions"=>array('admin','teacher'),
														"children"=>array(
															"controlAttendance"=>array("title"=>"Attendance","url"=>URL::to('#attendance'),"icon"=>"fa fa-check","permissions"=>array('admin','teacher') ),
															"statsAttendance"=>array("title"=>"attendanceStats","url"=>URL::to('#attendanceStats'),"icon"=>"fa fa-bar-chart","permissions"=>array('admin','teacher') ),
														)
									),
									"myAttendance"=>array("title"=>"Attendance","url"=>URL::to('#attendanceStats'),"icon"=>"fa fa-bar-chart","activated"=>"attendanceAct","permissions"=>array('student') ),
									"library"=>array("title"=>"Library","url"=>URL::to('#library'),"icon"=>"fa fa-folder-open","activated"=>"bookslibraryAct","permissions"=>array('admin','teacher','student','parent') ),
									
									"teachers"=>array("title"=>"teachers","url"=>URL::to('#teachers'),"icon"=>"fa fa-suitcase","permissions"=>array('admin') ),
									"students"=>array("title"=>"students","url"=>URL::to('#students'),"icon"=>"fa fa-users","permissions"=>array('admin','teacher','parent') ),
									"parents"=>array("title"=>"parents","url"=>URL::to('#parents'),"icon"=>"fa fa-user","permissions"=>array('admin') ),
									
									"gradelevels"=>array("title"=>"gradeLevels","url"=>URL::to('#gradeLevels'),"icon"=>"fa fa-check-square-o","permissions"=>array('admin') ),
									"assignments"=>array("title"=>"Assignments","url"=>URL::to('#assignments'),"icon"=>"fa fa-file-pdf-o","activated"=>"assignmentsAct","permissions"=>array('admin','teacher','student','parent') ),
									"examslist"=>array("title"=>"examsList","url"=>URL::to('#examsList'),"icon"=>"fa fa-graduation-cap","permissions"=>array('admin','teacher','student','parent') ),
									"onlineexams"=>array("title"=>"onlineExams","url"=>URL::to('#onlineExams'),"icon"=>"fa fa-graduation-cap","activated"=>"onlineexamsAct","permissions"=>array('admin','teacher','student') ),
									
									"newsboard"=>array("title"=>"newsboard","url"=>URL::to('#newsboard'),"icon"=>"fa fa-bullhorn","activated"=>"newsboardAct","permissions"=>array('admin','teacher','student','parent') ),
									"events"=>array("title"=>"events","url"=>URL::to('#events'),"icon"=>"fa fa-clock-o","activated"=>"eventsAct","permissions"=>array('admin','teacher','student','parent') ),
									
									"controlPayments"=>array("title"=>"Payments","url"=>URL::to('#payments'),"icon"=>"fa fa-money","activated"=>"paymentsAct","permissions"=>array('admin','student','parent') ),
								
									"transportations"=>array("title"=>"Transportation","url"=>URL::to('#transports'),"icon"=>"fa fa-bus","activated"=>"transportAct","permissions"=>array('admin','teacher','student','parent') ),
									"classes"=>array("title"=>"classes","url"=>URL::to('#classes'),"icon"=>"fa fa-sitemap","permissions"=>array('admin') ),
									"subjects"=>array("title"=>"Subjects","url"=>URL::to('#subjects'),"icon"=>"fa fa-book","permissions"=>array('admin') ),
									
									"adminTasks"=>array("title"=>"adminTasks","url"=>"","icon"=>"fa fa-cog","permissions"=>array('admin'),
																				"children"=>array(
																						"promotion"=>array("title"=>"promotion","url"=>URL::to('#promotion'),"icon"=>"fa fa-building-o","permissions"=>array('admin') ),
																						"mailsms"=>array("title"=>"mailsms","url"=>URL::to('#mailsms'),"icon"=>"fa fa-send","permissions"=>array('admin') ),	
																						"mailsmsTemplates"=>array("title"=>"mailsmsTemplates","url"=>URL::to('#mailsmsTemplates'),"icon"=>"fa fa-envelope-o","permissions"=>array('admin') ),	
																							
																						"dormitories"=>array("title"=>"Dormitories","url"=>URL::to('#dormitories'),"icon"=>"fa fa-building-o","permissions"=>array('admin') ),
																						"siteSettings" => array("title"=>"generalSettings","url"=>URL::to('#settings'),"icon"=>"fa fa-cog","permissions"=>array('admin') ),
																						"languages" => array("title"=>"Languages","url"=>URL::to('#languages'),"icon"=>"fa fa-font","permissions"=>array('admin') ),
																						"admins"=>array("title"=>"Administrators","url"=>URL::to('#admins'),"icon"=>"fa fa-gears","permissions"=>array('admin') ),
																						"terms"=>array("title"=>"schoolTerms","url"=>URL::to('#terms'),"icon"=>"fa fa-file-text-o","permissions"=>array('admin') ),
																					)
																				)
					);
		
		$settings = settings::get();
		foreach ($settings as $setting) {
			$this->settingsArray[$setting->fieldName] = $setting->fieldValue;
		}

		if($this->settingsArray['lastUpdateCheck']+86400 < time() ){
			$latestUpdate = @file_get_contents("http://cr-house.com/apps/Frelancers Group/latest");
			$latestUpdate = @json_decode($latestUpdate,true);

			$settings = settings::where('fieldName','lastUpdateCheck')->first();
			$settings->fieldValue = time();
			$settings->save();

			if(is_array($latestUpdate)){
				$settings = settings::where('fieldName','latestVersion')->first();
				$settings->fieldValue = $latestUpdate['v'];
				$settings->save();
			}
		}

		$staticPages = staticPages::where('pageActive','1')->get();
		foreach ($staticPages as $pages) {
			$this->panelItems['staticContent']['children'][md5(uniqid())] = array("title"=>$pages->pageTitle,"url"=>URL::to('#static')."/".$pages->id,"icon"=>"fa fa-file-text","permissions"=>array('admin','teacher','student','parent') );
		}
		
		//Languages
		$defLang = $defLang_ = $this->settingsArray['languageDef'];
		if(isset($this->settingsArray['languageAllow']) AND $this->settingsArray['languageAllow'] == "1" AND !Auth::guest() AND \Auth::user()->defLang != 0){
			$defLang = \Auth::user()->defLang;
		}

		$language = languages::whereIn('id',array($defLang,1))->get();
		if(count($language) == 0){
			$language = languages::whereIn('id',array($defLang_,1))->get();
		}

		foreach ($language as $value) {
			if($value->id == 1){
				$this->language = json_decode($value->languagePhrases,true);
			}else{
				$this->isRTL = $value->isRTL;
				$phrases = json_decode($value->languagePhrases,true);
				while (list($key, $value) = each($phrases)) {
					$this->language[$key] = $value;
				}
			}
		}
	}

	public static function globalXssClean()
	{
	  $sanitized = static::arrayStripTags(Input::get());
	  Input::merge($sanitized);
	}

	public static function arrayStripTags($array)
	{
	    $result = array();
	 
	    foreach ($array as $key => $value) {
	        // Don't allow tags on key either, maybe useful for dynamic forms.
	        $key = strip_tags($key);
	 
	        // If the value is an array, we will just recurse back into the
	        // function to keep stripping the tags out of the array,
	        // otherwise we will set the stripped value.
	        if (is_array($value)) {
	            $result[$key] = static::arrayStripTags($value);
	        } else {
	            // I am using strip_tags(), you may use htmlentities(),
	            // also I am doing trim() here, you may remove it, if you wish.
	            $result[$key] = trim(strip_tags($value));
	        }
	    }
	 
	    return $result;
	}

	public function viewop($layout,$view,&$data,$div=""){
		if(Request::ajax()){
			if($div != ""){
				echo "DBArea('".htmlspecialchars($this->sanitize_output( View::make($view, $data) ),ENT_QUOTES)."','".$div."');";
			}else{
				echo "DBArea('".htmlspecialchars($this->sanitize_output( View::make($view, $data) ),ENT_QUOTES)."');";
			}
			exit;
		}else{
			$data['content'] = View::make($view, $data);
			$layout->with($data);
		}
	}

	function sanitize_output($buffer) {
		$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s','/\s\s+/');
		$replace = array('>','<',' ',' ');
		$buffer = preg_replace($search, $replace, $buffer);
	
		return $buffer;
	}

	public static function breadcrumb($breadcrumb){
		echo "<ol class='breadcrumb'>
					<li><a class='aj' href='".URL::to('/dashboard')."'><i class='fa fa-dashboard'></i> Home</a></li>";
		$i = 0;
		while (list($key, $value) = each($breadcrumb)) {
			$i++;
			if($i == count($breadcrumb)){
				echo "<li class='active'>".$key."</li>";
			}else{
				echo "<li class='bcItem'><a class='aj' href='$value' title='$key'>$key</a></li>";
			}
		}
		echo "</ol>";
	}
	
	public function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = false) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen ( preg_replace ( '/<.*?>/', '', $text ) ) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all ( '/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER );
			$total_length = strlen ( $ending );
			$open_tags = array ( );
			$truncate = '';
			foreach ( $lines as $line_matchings ) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (! empty ( $line_matchings [1] )) {
					// if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
					if (preg_match ( '/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings [1] )) {
						// do nothing
					// if tag is a closing tag (f.e. </b>)
					} else if (preg_match ( '/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings [1], $tag_matchings )) {
						// delete tag from $open_tags list
						$pos = array_search ( $tag_matchings [1], $open_tags );
						if ($pos !== false) {
							unset ( $open_tags [$pos] );
						}
						// if tag is an opening tag (f.e. <b>)
					} else if (preg_match ( '/^<\s*([^\s>!]+).*?>$/s', $line_matchings [1], $tag_matchings )) {
						// add tag to the beginning of $open_tags list
						array_unshift ( $open_tags, strtolower ( $tag_matchings [1] ) );
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings [1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen ( preg_replace ( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings [2] ) );
				if ($total_length + $content_length > $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all ( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings [2], $entities, PREG_OFFSET_CAPTURE )) {
						// calculate the real length of all entities in the legal range
						foreach ( $entities [0] as $entity ) {
							if ($entity [1] + 1 - $entities_length <= $left) {
								$left --;
								$entities_length += strlen ( $entity [0] );
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr ( $line_matchings [2], 0, $left + $entities_length );
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings [2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if ($total_length >= $length) {
					break;
				}
			}
		} else {
			if (strlen ( $text ) <= $length) {
				return $text;
			} else {
				$truncate = substr ( $text, 0, $length - strlen ( $ending ) );
			}
		}
		// if the words shouldn't be cut in the middle...
		if (! $exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos ( $truncate, ' ' );
			if (isset ( $spacepos )) {
				// ...and cut the text in this position
				$truncate = substr ( $truncate, 0, $spacepos );
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if ($considerHtml) {
			// close all unclosed html-tags
			foreach ( $open_tags as $tag ) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

	//Work with Date & Time
	public function ttime($time,$format='d-m-Y H:i a',$timeZone = "") {
		if($timeZone == ""){
			$timeZone = \Auth::user()->timezone;
		}
		$dd = DateTime::createFromFormat($format, $time, new DateTimeZone($timeZone));
		$dd->setTimeZone(new DateTimeZone('Europe/London'));
		return $dd->getTimestamp();
	}

	public function tdate($format,$timestamp = "",$timeZone = ""){
		if($timestamp == ""){
			$timestamp = time();
		}
		if($timeZone == ""){
			$timeZone = \Auth::user()->timezone;
		}
		$date = new DateTime("@".$timestamp);
		$date->setTimezone(new DateTimeZone($timeZone));
		return $date->format($format);
	}
}