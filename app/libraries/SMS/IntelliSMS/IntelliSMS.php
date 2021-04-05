<?php

// IntelliSoftware IntelliSMS PHP Library
// Release: v1.0


class IntelliSMS
{

	//User Properties:


	//Set the Username and Password properties with your account details
	var $Username = "";
	var $Password = "";

	//Maximum multipart messages that will be used
	var $MaxConCatMsgs = 1;

	//Service URLs (change to https for secure connection)
	//NOTE: To use https you will need the OpenSSL extension module
	var $PrimaryGateway = "http://www.intellisoftware.co.uk";
	var $BackupGateway = "http://www.intellisoftware2.co.uk";




	//User Methods:


	//Send regular text message
	public function SendMessage ( $to, $text, $from ) 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password,
					'to'=>$to,
					'from'=>$from,
					'text'=>$text,
					'maxconcat'=>$this->MaxConCatMsgs );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequest ( $FormData );

		$SendStatusCollection = $this->IntelliSMS_ParseHTTPResponse ( $Response, $to );

		return $SendStatusCollection;
	}


	//Send WAP Push message
	public function SendWapPushMessage ( $to, $text, $href, $from) 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password,
					'to'=>$to,
					'type'=>'4',
					'from'=>$from,
					'text'=>$text,
					'href'=>$href );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequest ( $FormData );

		$SendStatusCollection = $this->IntelliSMS_ParseHTTPResponse ( $Response, $to );

		return $SendStatusCollection;
	}


	//Send Unicode message
	public function SendUnicodeMessageHex ( $to, $unicodehex, $from ) 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password,
					'to'=>$to,
					'type'=>'2',
					'from'=>$from,
					'hex'=>$unicodehex,
					'maxconcat'=>$this->MaxConCatMsgs );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequest ( $FormData );

		$SendStatusCollection = $this->IntelliSMS_ParseHTTPResponse ( $Response, $to );

		return $SendStatusCollection;
	}


	//Send Binary message
	public function SendBinaryMessage ( $to, $userdataheaderhex, $userdatahex, $from ) 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password,
					'to'=>$to,
					'type'=>'3',
					'from'=>$from,
					'udh'=>$userdataheaderhex,
					'ud'=>$userdatahex );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequest ( $FormData );

		$SendStatusCollection = $this->IntelliSMS_ParseHTTPResponse ( $Response, $to );

		return $SendStatusCollection;
	}


	//Send regular text message with UserContext
	public function SendMessageWithUserContext ( $to, $text, $usercontext ) 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password,
					'to'=>$to,
					'usercontext'=>$usercontext ,
					'text'=>$text,
					'maxconcat'=>$this->MaxConCatMsgs );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequest ( $FormData, $to );

		$SendStatusCollection = $this->IntelliSMS_ParseHTTPResponse ( $Response, $to );

		return $SendStatusCollection;
	}


	//Get account balance
	public function GetBalance () 
	{
		$FormParams = array ( 	'username'=>$this->Username,
					'password'=>$this->Password );

		$FormData = http_build_query($FormParams, '', '&');

		$Response = $this->IntelliSMS_MakeHTTPRequestToURL ( $FormData, "/smsgateway/getbalance.aspx" );

		$Results = $this->IntelliSMS_ParseHTTPResponse_GetBalance ( $Response );

		return $Results;
	}




	//Implementation Functions:


	private function IntelliSMS_MakeHTTPRequest ( $data )
	{
		return $this->IntelliSMS_MakeHTTPRequestToURL ( $data, "/smsgateway/sendmsg.aspx" );
	}

	private function IntelliSMS_MakeHTTPRequestToURL ( $data, $urlpath )
	{
		try
		{
			$Response = $this->IntelliSMS_MakeHTTPRequestUsingGateway ( 1, $data, $urlpath );
		}
		catch (Exception $e) 
		{
			try
			{
				//Try backup gateway SMSGateway
				$Response = $this->IntelliSMS_MakeHTTPRequestUsingGateway ( 2, $data, $urlpath );
			}
			catch (Exception $e2) 
			{
				//Throw first exception
				throw $e;
			}
		}

		return $Response;
	}


	private function IntelliSMS_MakeHTTPRequestUsingGateway ( $gatewayid, $data, $urlpath )
	{
		if ( $gatewayid == 1 )
		{
			$gatewayurl = $this->PrimaryGateway . $urlpath;
		}
		else if ( $gatewayid == 2 )
		{
			$gatewayurl = $this->BackupGateway . $urlpath;
		}
		else
		{
			throw new Exception("Gateway Id invalid $gatewayid");
		}

		return $this->MakeHTTPFormPost ( $gatewayurl, $data, "Content-Type: application/x-www-form-urlencoded\r\n" );
	}


	private function IntelliSMS_ParseHTTPResponse ( $response, $to )
	{
		$const_IdPrefix = "ID:";
		$const_ErrPrefix = "ERR:";

		$SendStatusCollection = array();

		$msgresponses = @split("\n", $response );

		$idx = 0;

		foreach ( $msgresponses as $msgresponse )
		{
		   $msgresponse = trim($msgresponse);

		   if ( strlen($msgresponse) > 0 )
		   {
			$msgresponseparts = @split(",", $msgresponse );

			$msisdn = null;
			$msgid = null;
			$errorstatus = null;

			if ( count($msgresponseparts) >= 2 )
			{
				$msisdn  = $msgresponseparts[0];
				$msgresult = $msgresponseparts[1];
			}
			else
			{
				if ( count( @split(",",$to))==1 )
				{
					$msisdn = $to;
				}
				else
				{
					$msisdn = "";
				}
				$msgresult = $msgresponseparts[0];
			}

			if ( strncmp($msgresult,$const_IdPrefix,strlen($const_IdPrefix))==0 )
			{
				$msgid = substr($msgresult,strlen($const_IdPrefix));
				$errorstatus = "OK";
			}
			else if ( strncmp($msgresult,$const_ErrPrefix,strlen($const_ErrPrefix))==0 )
			{
				$msgid = "NoId";
				$errorstatus = substr($msgresult,strlen($const_ErrPrefix));
			}

			$SendStatusCollection[$idx]["To"] = $msisdn;
			$SendStatusCollection[$idx]["MessageId"] = $msgid;
			$SendStatusCollection[$idx]["Result"] = $errorstatus;

			$idx++;
		    }
		}

		return $SendStatusCollection;
	}


	private function IntelliSMS_ParseHTTPResponse_GetBalance ( $response )
	{
		$const_BalancePrefix = "BALANCE:";
		$const_ErrPrefix = "ERR:";

		$Results = array();

		if ( strncmp($response,$const_BalancePrefix,strlen($const_BalancePrefix))==0 )
		{
			$Results["Balance"] = substr($response,strlen($const_BalancePrefix));
			$Results["ErrorStatus"] = "OK";
		}
		else if ( strncmp($response,$const_ErrPrefix,strlen($const_ErrPrefix))==0 )
		{
			$Results["Balance"] = -1;
			$Results["ErrorStatus"] = substr($response,strlen($const_ErrPrefix));
		}

		return $Results;
	}


	private function MakeHTTPFormPost ( $url, $data, $optional_headers = null)
	{
		 $params = array ( 'http' => array ( 'method' => 'POST', 'content' => $data ) );

		 if ($optional_headers !== null) 
		 {
			$params['http']['header'] = $optional_headers;
		 }

		 $ctx = stream_context_create($params);

		 $fp = @fopen($url, 'rb', false, $ctx);
		 if (!$fp) {
			throw new Exception("Problem making HTTP request $url, $php_errormsg");
		 }

		 $response = @stream_get_contents($fp);
		 if ($response === false) {
			throw new Exception("Problem reading HTTP Response $url, $php_errormsg");
		 }

		 return $response;
	}

}



//Unicode helper functions

function utf8toucs2hex($utf8)
{
	$utf8_hex = bin2hex( $utf8 );
	return utf8hextoucs2hex($utf8_hex);
}

function utf8hextoucs2hex($str)
{
       $ucs2 = "";

       for ($i=0;$i<strlen($str);$i+=2)
       {
                $char1hex = $str[$i].$str[$i+1]; 
               
		$char1dec = hexdec($char1hex);
                if ( $char1dec < 128)
		{
                        $results = $char1hex;
		}
                else if ( $char1dec < 224 )
                {
	               	$char2hex = $str[$i+2].$str[$i+3]; 
                        $results = dechex( ((hexdec($char1hex)-192)*64) + (hexdec($char2hex)-128) );
                        $i+=2;
                }
                else if ( $char1dec < 240 )
                {
	               	$char2hex = $str[$i+2].$str[$i+3]; 
	               	$char3hex = $str[$i+4].$str[$i+5]; 
                        $results = dechex( ((hexdec($char1hex)-224)*4096) + ((hexdec($char2hex)-128)*64) + (hexdec($char3hex)-128) );
                        $i+=4;
                }
		else
		{
			//Not supported: UCS-2 only
                        $i+=6;
		}

		while ( strlen($results) < 4 )
		{
			$results = '0' . $results;
		}

                $ucs2 .= $results;
        }

        return $ucs2;
}


?>

