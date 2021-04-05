<?php
class MailSmsHandler {

	var $settings ;
	var $title;

	public function mail($to,$title,$message,$fullName=""){
		$panelInit = new \DashboardInit();
		$settings = $panelInit->settingsArray;
		$this->title = $settings['siteTitle'];

		$this->settings = json_decode($settings['mailProvider'],true);
		if($this->settings['mailProvider'] == "" || !isset($this->settings['mailProvider'])){
			exit;
		}

		if($this->settings['mailProvider'] == "mail"){
			$header = "From: ".$settings['systemEmail']."\r\n"; 
			$header.= "MIME-Version: 1.0\r\n"; 
			$header.= "Content-Type: text/html; charset=utf-8\r\n"; 
			$header.= "X-Priority: 1\r\n"; 

			mail($to, $title, $message, $header);
		}elseif($this->settings['mailProvider'] == "phpmailer"){
			$mail = new PHPMailer;
			$mail->From = $settings['systemEmail'];
			$mail->FromName = $settings['siteTitle'];
			$mail->addAddress($to, $fullName);
			$mail->Subject = $title;
			$mail->Body    = $message;
			$mail->IsHTML(true);
			return $mail->send();
		}elseif($this->settings['mailProvider'] == "smtp"){
			$mail             = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 2;
			$mail->SMTPAuth   = true;
			$mail->Host       = $this->settings['smtpHost'];
			$mail->Port       = $this->settings['smtpPort'];
			$mail->Username   = $this->settings['smtpUserName'];
			$mail->Password   = $this->settings['smtpPassWord'];
			
			if(isset($this->settings['smtpTLS']) && $this->settings['smtpTLS'] != ""){
				if($this->settings['smtpTLS'] == "TLS"){
					$mail->SMTPSecure = 'tls';
				}elseif($this->settings['smtpTLS'] == "SSL"){
					$mail->SMTPSecure = 'ssl';
				}
			}

			$mail->SetFrom($settings['systemEmail'], $settings['siteTitle']);
			$mail->Subject = $title;
			$mail->Body    = $message;
			$mail->addAddress($to, $fullName);
			$mail->IsHTML(true);
			$mail->Send();
			echo $mail->ErrorInfo;
		}elseif($this->settings['mailProvider'] == "ses"){
			$amazonSES = new SimpleEmailService($this->settings['AmazonSESAccessKey'],$this->settings['AmazonSESSecretKey']);
			$m = new SimpleEmailServiceMessage();
			$m->addTo($to);
			$m->setFrom($this->settings['AmazonSESVerifiedSender']);
						
			$m->setSubject($title);
			$m->setMessageFromString(strip_tags($message),$message);
			return $amazonSES->sendEmail($m);
		}
	}

	public function sms($to,$message){
		$panelInit = new \DashboardInit();
		$settings = $panelInit->settingsArray;
		$this->title = $settings['siteTitle'];

		$this->settings = json_decode($settings['smsProvider'],true);

		if($this->settings['smsProvider'] == "" || !isset($this->settings['smsProvider'])){
			exit;
		}

		if($this->settings['smsProvider'] == "nexmo"){
			$this->nexmo($to,$message);
		}elseif($this->settings['smsProvider'] == "twilio"){
			$this->twilio($to,$message);
		}elseif($this->settings['smsProvider'] == "hoiio"){
			$this->hoiio($to,$message);
		}elseif($this->settings['smsProvider'] == "clickatell"){
			$this->clickatell($to,$message);
		}elseif($this->settings['smsProvider'] == "intellisms"){
			$this->intellisms($to,$message);
		}elseif($this->settings['smsProvider'] == "bulksms"){
			$this->bulksms($to,$message);
		}elseif($this->settings['smsProvider'] == "concepto"){
			$this->concepto($to,$message);
		}elseif($this->settings['smsProvider'] == "msg91"){
			$this->msg91($to,$message);
		}
	}

	public function nexmo($to,$message){
		$nexmo_sms = new NexmoMessage($this->settings['nexmoApiKey'], $this->settings['nexmoApiSecret']);
		$info = $nexmo_sms->sendText( $to, $this->title,$message );
	}

	public function twilio($to,$message){
		$client = new Services_Twilio($this->settings['twilioSID'], $this->settings['twilioToken']);
		$message = $client->account->messages->create(array("From" => $this->settings['twilioFN'],"To" => $to,"Body" => $message));
	}

	public function hoiio($to,$message){
		$client = new HoiioService($this->settings['hoiioAppId'], $this->settings['hoiioAccessToken']);
		$client->sms($to,$message);
	}

	public function clickatell($to,$message){
    $baseurl ="http://api.clickatell.com";
    $url = "$baseurl/http/auth?user=".$this->settings['clickatellUserName']."&password=".$this->settings['clickatellPassword']."&api_id=".$this->settings['clickatellApiKey'];
    $ret = file($url);
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK") {
 			  $sess_id = trim($sess[1]);
        $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=".$to."&text=".urlencode($message);
 
        $ret = file($url);
        $send = explode(":",$ret[0]);
    }
	}

	public function intellisms($to,$message){
		$objIntelliSMS = new IntelliSMS();
		$objIntelliSMS->Username = $this->settings['intellismsUserName'];
		$objIntelliSMS->Password = $this->settings['intellismsPassword'];
		$objIntelliSMS->SendMessage ( $to,$message, $this->settings['intellismsSenderNumber'] );
	}

	public function bulksms($to,$message){
		$url = 'http://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';
		$data = 'username='.$this->settings['bulksmsUserName'].'&password='.$this->settings['bulksmsPassword'].'&message='.urlencode($message).'&msisdn='.urlencode($to);

		$this->bulksms_post_request($url, $data);
	}

	public function concepto($to,$message){
		file_get_contents("http://premium.liveair.in/httpapi/smsapi?uname=".$this->settings['conceptoUserName']."&password=".$this->settings['conceptoPassword']."&sender=".$this->settings['conceptoSenderId']."&receiver=".$to."&route=T&msgtype=1&sms=".urlencode($message));
	}

	public function msg91($to,$message){
		file_get_contents("http://api.msg91.com/api/sendhttp.php?authkey=".$this->settings['msg91Authkey']."&mobiles=".$to."&message=".urlencode($message)."&sender=".$this->settings['msg91SenderId']."&route=4");
	}

	public function bulksms_post_request($url, $data, $optional_headers = 'Content-type:application/x-www-form-urlencoded') {
		$params = array('http'      => array(
			'method'       => 'POST',
			'content'      => $data,
			));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
	
		$ctx = stream_context_create($params);


		$response = @file_get_contents($url, false, $ctx);
		if ($response === false) {
			print "Problem reading data from $url, No status returned\n";
		}
	
		return $response;
	}
}
?>