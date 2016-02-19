<?php

//--------------------------------------------------------------//
//-------------------	Return Code ----------------------------//
//--------------------------------------------------------------//
define("SUCCESS", "0"); 			// successfully

define("MISSING_PARAMETER", "100"); // Parameter missing
define("INVALID_PARAMETER", "101"); // Parameter is invacheckUserValiditylid

define("USER_EXIST", "201");		// user already exist
define("NO_VERIFIED", "202"); 		// not verified user
define("STATUS_INACTIVE", "203"); 	// status inactive

define("NO_USER_EXIST", "301"); 	// user not exist
define("INVALID_PASSWORD", "302");	// user or password is not valid
define("INVALID_VCODE", "303");		// verify code is invalid
define("NO_PERMISSIONS", "304"); 	// no permissions
define("SERVER_INTERNAL_ERROR", "401"); // server process error
define("CHAT_SERVER_ERROR", "402"); // chat server down

//--------------------------------------------------------------//
//-------------------	Parameter Names ------------------------//
//--------------------------------------------------------------//

define("P_USERID", "userid");		// user primary key value
define("P_MOBILE", "mobile");		// country local mobile number
define("P_PASSWORD", "password"); 	// password
define("P_COUNTRY", "country_id");	// country id
define("P_VCODE", "vcode");			// verify code
define("P_DEVICE", "device");		// device type
define("P_PUSHKEY", "pushkey");		// push device token
define("P_SECUREKEY", "securekey");	// secure key
define("P_PARAMS", "params");		// base64 encoded json parameters
define("P_ACTION", "action");		// upload method action code


define("DEVICE_IPHONE", "iphone");	// device type iPhone
define("DEVICE_ANDROID", "android");// device type Android

require_once('openfire_api.php');

class ProcessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/service';
	
	//actionGetCountryList
	//actionGetClassificationList

	//actionRegister		: user register
	//actionVerify			: user verify
	//actionLogin			: user login
	//actionUpdateMobile	: user update mobile (change sim card or lose phone )
	//actionGetProfile		: get profile
	//actionUpdateProfile	: update user profile
	//actionUpload			: upload file
	//actionAddContact		: add one contact
	//actionDeleteContact	: delete one contact
	//actionUpdateContact	:
	//actionGetContactDetail:
	//actionGetContactList	:
	//actionAddGroup		:
	//actionDeleteGroup		:
	//actionUpdateGroup		:
	//actionGetGroupList	:
	//actionAddGroupContacts:
	//actionDeleteGroupContacts:
	//actionSendReport		:
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('getInfo'),
				'actions'=>array('*'),
				'users'=>array('*'),
			),
		);
	}

	public function outputResult( $retcode, $content = '', $error_msg = null )
	{
		//header('Content-type: application/json');

		if( $error_msg == null )
		{
			switch ($retcode)
			{
			case SUCCESS:
				$error_msg = '';
				break;
			case MISSING_PARAMETER:
				$error_msg = 'Parameter is missing';
				break;
			case INVALID_PARAMETER:
				$error_msg = 'Parameter is invalid';
				break;
			case USER_EXIST:
				$error_msg = 'User is already exist';
				break;
			case NO_USER_EXIST:
				$error_msg = 'User is not exist';
				break;
			case INVALID_PASSWORD:
				$error_msg = 'Your input password is not correct';
				break;
			case INVALID_VCODE:
				$error_msg = 'Verification code is invalid';
				break;
			case STATUS_INACTIVE:
				$error_msg = 'You can not login, you are disabled by administrator';
				break;
			case NO_VERIFIED:
				$error_msg = 'You are not verified yet.';
				break;
			case NO_PERMISSIONS:
				$error_msg = 'You have no permission';
				break;
			case CHAT_SERVER_ERROR:
				$error_msg = 'Chat server is not responding.';
				break;
			case SERVER_INTERNAL_ERROR:
				$error_msg = 'Server internal process error.';// . $content;
				/*
				if( is_string($content) )
					$error_msg = $error_msg . ' ' . $content;
				else if( is_array($content) )
					$error_msg = $error_msg . ' ' . CJSON::encode($content);
				//$error_msg = $content;
				*/
				break;
			default :
				$error_msg = '';
				break;
			}
		}

		$response = array( 'retcode'=>$retcode, 'content'=>$content, 'error_msg'=>$error_msg );

		echo CJSON::encode($response);
		
		Yii::app()->end();
	}
	
	// Push functions
	// Google GCM
	function push2Android($push_keys, $msg, $push_type = "Common")
	{
		$ret = true;
	
		$apiKey = "AIzaSyCfJ_4O6jIVOZwUF_x-M6tVU5EBvyHvqwQ";
		$headers = array(
			'Authorization: key=' . $apiKey,
			'Content-Type: application/json'
		);
	
		$arr = array();
		$arr['data'] = array();
		$arr['data']['msg'] = urlencode($msg);
		$arr['data']['type'] = $push_type;
		$arr['registration_ids'] = array();
	
		$total = sizeof($push_keys);
		$count = (int) ($total / 500);
		$remain = $total % 500;
		if ($remain !== 0)
		{
			$count = $count + 1;
		}
	
		if ($total > 0)
		{
			for ($i = 0; $i < $count; $i++)
			{
				$registrationIDs = array();
				$k = 0;
				if (($i === ($count - 1)) && $remain != 0)
				{
					for ($j = $i * 500; $j < $i * 500 + $remain; $j++)
					{
						$registrationIDs[$k] = $push_keys[$j];
						$k ++;
					}
				}
				else
				{
					for ($j = $i * 500; $j < ($i + 1) * 500; $j++)
					{
						$registrationIDs[$k] = $push_keys[$j];
						$k ++;
					}
				}
	
				$arr['registration_ids'] = $registrationIDs;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://android.googleapis.com/gcm/send');
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
	
				// Execute post
				$reponse = curl_exec($ch);
	
				// Close connection
				curl_close($ch);
	
				// Get message from GCM server
				//$obj = json_decode($reponse, true);
				//var_dump($registrationIDs);
	
				sleep(1);
			}
		}
		else
		{
			$ret = false;
		}
	
		return $ret;
	}

	// iphone APNS
	function push2IPhone($tokens, $msg, $push_type = "Common", $badge = 0)
	{
		$ret = true;
	
		//$apnsCert = 'D:\xampp\htdocs\smartaxa\models\masix_apns_for_dev.pem';
		//$apnsCert = '/var/www/html/ws/img/first/test/models/masix_apns_for_dev.pem';
		$apnsCert = '/home/axasmart/public_html/models/axaapns.pem';

		$passphrase = 'kgsiospush'; //carepetpush2014';
		$payload['aps'] = array('alert' => $msg, 'badge' => $badge, 'sound' => 'default', 'type' => $push_type);
		$message = json_encode($payload);
	
		$index = 0;
		$remain = 0;
		$apns = NULL;
		foreach ($tokens as $token)
		{
			$remain = $index % 500;
	
			if ($remain === 0)
			{
				if ($apns)
				{
					// Close connection
					fclose($apns);
					sleep(1);
				}
	
				// Create stream context
				$streamContext = stream_context_create();
				stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert); //ssl
				stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
	
				$apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 100, STREAM_CLIENT_CONNECT, $streamContext);
				if (!$apns)
				{
					return false;
				}
			}
	
			// Send push
			//$apnsMessage = chr ( 0 ) . chr ( 0 ) . chr ( 32 ) . pack ( 'H*', str_replace ( ' ', '', $token ) ) . chr ( 0 ) . chr ( strlen ( $message ) ) . $message;
			$apnsMessage = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $token)) . pack("n", strlen($message)) . $message;
			//$apnsMessage = chr(0) . pack("n", 32) . pack('H*', trim($token)) . pack("n", strlen($message)) . $message;
			$writeResult = fwrite($apns, $apnsMessage);
	
			$index ++;
	
	//            echo $apnsMessage . "<br>";
	//            echo sizeof($apnsMessage) . "<br>";
	//            echo $writeResult . "<br>";
		}
	
		if ($apns)
		{
			// Close connection
			fclose($apns);
		}
	
		return $ret;
	}
	
	public function sendSMS( $mobile, $content )
	{
		$key = "your_app_key";    
		$secret = "your_app_secret"; 
		$phone_number = $mobile;
		
		$user = "application\\" . $key . ":" . $secret;    
		$message = array("message"=>$content);    
		$data = json_encode($message);

		$ch = curl_init('https://messagingapi.sinch.com/v1/sms/' . $phone_number);
		curl_setopt($ch, CURLOPT_POST, true);    
		curl_setopt($ch, CURLOPT_USERPWD, $user);    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    
		
		$result = curl_exec($ch);    

		if(curl_errno($ch)) {    
		//	echo 'Curl error: ' . curl_error($ch);    
		} else {    
		//	echo $result;
		}
		
		curl_close($ch);    
	}
	
	public function sendVerifyCode( $mobile, $vcode )
	{
		$this->sendSMS( $mobile, 'You PhoneBook verification code is ' . $vcode );
	}
	
	public function getGlobalMobile( $country_id, $mobile )
	{
		$mobile = str_replace(' ', '', $mobile);
		$mobile = str_replace('(', '', $mobile);
		$mobile = str_replace(')', '', $mobile);
		$mobile = str_replace('-', '', $mobile);
		
		$country = Country::model()->findByPk($country_id);
		$prefix_code = $country->phone_prefix;
		
		if( strncmp( $prefix_code, $mobile, strlen($prefix_code) ) == 0 ) 
			$mobile = $prefix_code . ' ' . substr( $mobile, strlen($prefix_code) );
		else
			$mobile = $prefix_code . ' ' . $mobile; 	

		return $mobile;
	}
	
	public function getOpenfireID( $country_id, $mobile )
	{
		$mobile = str_replace(' ', '', $mobile);
		$mobile = str_replace('(', '', $mobile);
		$mobile = str_replace(')', '', $mobile);
		$mobile = str_replace('-', '', $mobile);
		
		$country = Country::model()->findByPk($country_id);
		$prefix_code = $country->phone_prefix;
		
		if( strncmp( $prefix_code, $mobile, strlen($prefix_code) ) == 0 ) 
			$id = $prefix_code . '_' . substr( $mobile, strlen($prefix_code) );
		else
			$id = $prefix_code . '_' . $mobile; 	

		$id = substr($id, 1);
		
		return $id;
	}
	
	public function actionGetCountryList()
	{
		$countries = Country::model()->findAllBySql('select * from country order by name ASC');
		 
		$this->outputResult( SUCCESS, $countries );
	}
	
	public function actionGetClassificationList()
	{		
		$classifications = Classification::model()->findAllBySql('select * from classification order by name ASC');
		 
		$this->outputResult( SUCCESS, $classifications );
	}
	
	public function actionGetStaticList()
	{
		$countries = Country::model()->findAllBySql('select * from country order by name ASC');
		$classifications = Classification::model()->findAllBySql('select * from classification order by name ASC');
		
		$list = array(
			'country' => $countries,
			'classification' => $classifications,
		);
		
		$this->outputResult( SUCCESS, $list );
	}
	
	// register user
	public function actionRegister()
	{
		$mobile = Yii::app()->request->getParam(P_MOBILE);
		$country_id = Yii::app()->request->getParam(P_COUNTRY);

		if( $mobile == null || $country_id == null )
		{
			$this->outputResult( MISSING_PARAMETER );
			return;
		}

		$mobile = $this->getGlobalMobile( $country_id, $mobile );
		$model = User::registerUser($country_id, $mobile, '');
		if( $model == null )
		{
			$this->outputResult( SERVER_INTERNAL_ERROR );
			return;
		}

		// send verification code to mobile phone
		$this->sendVerifyCode( $mobile, $model->vcode );

		$this->outputResult( NO_VERIFIED, array(P_VCODE=>$model->vcode) );
	}

	public function processLogin( $user, $device, $pushkey )
	{
		if( $user->status == '0' )
			$this->outputResult( STATUS_INACTIVE );
		
		if( $user->is_verified == '0' )
		{
			$user->vcode = Functions::generateVerifyCode();
			if( !$user->save() )
				$this->outputResult( SERVER_INTERNAL_ERROR, $user->getErrors() );
			
			// send verification code to mobile phone
			$this->sendVerifyCode( $user->mobile, $user->vcode );
		
			$this->outputResult( NO_VERIFIED, array( P_VCODE=>$user->vcode) );
		}
		
		$user->device = $device;
		$user->pushkey = $pushkey;
		$user->login_stamp = time();
		$user->is_online = 1;
		$user->securekey = Functions::generateActivationToken();
		if( !$user->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $user->getErrors() );
			
		$share_pictures = UserPicture::model()->findAll('user_id=' . $user->id);
		
		$profile = array(
			'id'=>$user->id,
			'country_id'=>$user->country_id,
			'mobile'=>$user->mobile,
			'name'=>$user->name,
			'pname'=>$user->pname,
			'email'=>$user->email,
			'homeaddr'=>$user->homeaddr,
			'housetel'=>$user->housetel,
			'birthday'=>$user->birthday,
			'class_id'=>$user->class_id,
			'photo_filename'=>$user->photo_filename,
			'company'=>$user->company,
			'share_pictures'=>$share_pictures,
		);

		$user_info = array(
			'userid' => $user->id,
			'securekey' => $user->securekey,
			'profile' => $profile,
		);
		
		$this->outputResult( SUCCESS, $user_info );
	}
	
	// verify user step
	public function actionVerify()
	{
		$mobile = Yii::app()->request->getParam(P_MOBILE);
		$vcode = Yii::app()->request->getParam(P_VCODE);
		$country_id = Yii::app()->request->getParam(P_COUNTRY);
		$device = Yii::app()->request->getParam(P_DEVICE);
		$pushkey = Yii::app()->request->getParam(P_PUSHKEY);

		if( $mobile == null || $vcode == null || $country_id == null || $device == null || $pushkey == null )
			$this->outputResult( MISSING_PARAMETER );
			
		if( $device != 'iphone' && $device != 'android' )
			$this->outputResult( INVALID_PARAMETER );
		
		$mobile = $this->getGlobalMobile( $country_id, $mobile );
		$user = User::model()->find('mobile=?',array($mobile));
		if( $user == null )
			$this->outputResult( NO_USER_EXIST );
		
		if( $user->vcode != $vcode )
			$this->outputResult( INVALID_VCODE );
			
		// get openfire id
		$openfire_id = $this->getOpenfireID( $country_id, $mobile );
		$openfire = getUser($openfire_id);
		
		switch( $openfire['code'] )
		{
			case 0:	// Openfire server is not responding
				$this->outputResult( CHAT_SERVER_ERROR );
				return;			
			default:
				break;
		}				

		// add openfire
		$ret = addUser($openfire_id, strrev($openfire_id));

		switch($ret['code'])
		{
			case 201: // add user is ok
			case 409: // user exist
				break;				
			default:
				$this->outputResult( CHAT_SERVER_ERROR );
				return;
				break;
		}
		
		$user->is_verified = 1;
		if( !$user->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $user->getErrors() );
		
		$this->processLogin( $user, $device, $pushkey );
	}
	
	// user login
	public function actionLogin()
	{
		$country_id = Yii::app()->request->getParam(P_COUNTRY);
		$mobile = Yii::app()->request->getParam(P_MOBILE);
		$device = Yii::app()->request->getParam(P_DEVICE);
		$pushkey = Yii::app()->request->getParam(P_PUSHKEY);
		
		if( $mobile == null || $country_id == null || $device == null || $pushkey == null )
			$this->outputResult( MISSING_PARAMETER );
			
		if( $device != 'iphone' && $device != 'android' )
			$this->outputResult( INVALID_PARAMETER );
		
		// get openfire id
		$openfire_id = $this->getOpenfireID( $country_id, $mobile );
		
		$user = getUser($openfire_id);
		
		$mobile = $this->getGlobalMobile( $country_id, $mobile );
		
		switch( $user['code'] )
		{
			case 0:	// Openfire server is not responding
				$this->outputResult( CHAT_SERVER_ERROR );
				break;
			case 200: // get user is ok
				$user = User::model()->find('mobile=?',array($mobile));
				if( $user == null || $user->is_verified !== '1' )	// user is not exist or not activated
					$this->actionRegister();
				else
					$this->processLogin( $user, $device, $pushkey );
				break;
			default:			
				$this->actionRegister();
				break;				
		}
	}
	
	public function actionUpdateMobile( )
	{
		$old_country_id = Yii::app()->request->getParam('old_country_id');
		$old_mobile = Yii::app()->request->getParam('old_mobile');
		$old_password = Yii::app()->request->getParam('old_password');
		
		$country_id = Yii::app()->request->getParam(P_COUNTRY);
		$mobile = Yii::app()->request->getParam(P_MOBILE);
		$password = Yii::app()->request->getParam(P_PASSWORD);
		$device = Yii::app()->request->getParam(P_DEVICE);
		
		if( $old_mobile == null || $old_password == null || $old_country_id == null ||
			$mobile == null || $password == null || $country_id == null || $device == null )
			$this->outputResult( MISSING_PARAMETER );
			
		if( $device != 'iphone' && $device != 'android' )
			$this->outputResult( INVALID_PARAMETER );

		$old_mobile = $this->getGlobalMobile( $old_country_id, $old_mobile );
		$user = User::model()->find('mobile=?',array($old_mobile));
		if( $user == null )
			$this->outputResult( NO_USER_EXIST );

		$old_password = Functions::generateHash( $old_password, $user->password );
		if( $old_password != $user->password )
			$this->outputResult( INVALID_PASSWORD );
			
		$mobile = $this->getGlobalMobile( $country_id, $mobile );
		$user->mobile = $mobile;
		$user->country_id = $country_id;
		$user->is_verified = 0;
		
		$user->update_stamp = time();
		$user->vcode = Functions::generateVerifyCode();
		
		if( !$user->save() )
			$this->outputResult( SUCCESS, $user->getErrors() );
		
		// send verification code to mobile phone
		$this->sendVerifyCode( $user, $user->vcode );

		$this->outputResult( SUCCESS, array(P_VCODE=>$user->vcode) );
	}
	
	// check login user and security key
	public function checkUserValidity()
	{
		$userid = Yii::app()->request->getParam(P_USERID);
		$securekey = Yii::app()->request->getParam(P_SECUREKEY);

		if( $userid == null || $securekey == null )
			$this->outputResult( MISSING_PARAMETER );

		$user = User::model()->findByPk($userid);
		if( $user == null )
			$this->outputResult( INVALID_PARAMETER );

		if( $user->securekey != $securekey )
			$this->outputResult( NO_PERMISSIONS );

		return $user;
	}
	
	public function actionGetProfile()
	{
		$user = $this->checkUserValidity();
		
		$share_pictures = UserPicture::model()->findAll('user_id=' . $user->id);
		
		$result = array(
			'id'=>$user->id,
			'country_id'=>$user->country_id,
			'mobile'=>$user->mobile,
			'name'=>$user->name,
			'pname'=>$user->pname,
			'email'=>$user->email,
			'homeaddr'=>$user->homeaddr,
			'housetel'=>$user->housetel,
			'birthday'=>$user->birthday,
			'class_id'=>$user->class_id,
			'photo_filename'=>$user->photo_filename,
			'company'=>$user->company,
			'share_pictures'=>$share_pictures,
		);
		
		$this->outputResult( SUCCESS, $result );
	}
	
	public function actionUpdateProfile()
	{
		$user = $this->checkUserValidity();
		
		$params = Yii::app()->request->getParam(P_PARAMS);
		if( $params == null )
			$this->outputResult( MISSING_PARAMETER );

		$params = CJSON::decode(base64_decode($params));
		
		$user->attributes = $params;
		/*$user->pname = $params['pname'];
		$user->name = $params['name'];
		$user->email = $params['email'];
		$user->homeaddr = $params['homeaddr'];
		$user->housetel = $params['housetel'];
		$user->birthday = $params['birthday'];
		*/
		$user->update_stamp = time();
		if( !$user->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $user->getErrors() );
			
		$company_infos = $params['company'];
		$reg_companies = Company::model()->findAll('user_id=' . $user->id);
		$company_ids = array();
		
		foreach( $reg_companies as $reg_comp )
		{
			$company_ids[] = $reg_comp->id;
		}
		
		$reg_count = count($company_ids);
		$new_count = count($company_infos);
		$update_count = min( $reg_count, $new_count );

		for( $i = 0; $i < $update_count; $i++ )
		{
			$company = Company::model()->findByPk($company_ids[$i]);
			$company->attributes = $company_infos[$i];
			if( !$company->save() )
				$this->outputResult( SERVER_INTERNAL_ERROR, $company->getErrors() );		
		}
		
		for( $i = $update_count; $i < $reg_count; $i++ )
		{
			Company::model()->deleteByPk($company_ids[$i]);
		}
		
		for( $i = $update_count; $i < $new_count; $i++ )
		{
			$company = new Company;
			
			$company->attributes = $company_infos[$i];
			$company->user_id = $user->id;
			if( !$company->save() )
				$this->outputResult( SERVER_INTERNAL_ERROR, $company->getErrors());
		}

		$this->outputResult( SUCCESS );
	}
	
	public function actionUpdateTest()
	{
		$profile = array(
			'pname'=>'MaoMao',
			'name'=>'MaoZhong',
			'email'=>'maomao@gmail.com',
			'homeaddr'=>'Beijing chaoyangqu wangjing',
			'housetel'=>'024401234',
			'birthday'=>'1993/11/17',
			'class_id'=>'1',
			'companies'=>array(
				array(
					'name'=>'BST',
					'department'=>'depart A zuo',
					'jobtitle'=>'soft',
					'address'=>'yeqing 500',
					'telephone'=>'024444414',
					'fax'=>'fax101',
					'notes'=>'nnn',
					'email'=>'eee@gmail.com',
					'website'=>'www.bst.com',
				),
				array(
					'name'=>'TD Tech',
					'department'=>'ddd',
					'jobtitle'=>'ttt',
					'address'=>'aaa',
					'telephone'=>'024444404',
					'fax'=>'fax',
					'notes'=>'ok',
					'email'=>'tdemail@gmail.com',
					'website'=>'www.tdtech.com',
				),
				/*
				array(
					'name'=>'TD Tech2',
					'department'=>'DDD',
					'jobtitle'=>'TTT',
					'address'=>'aaa',
					'telephone'=>'024444404',
					'fax'=>'fax',
					'notes'=>'cancel',
					'email'=>'tdemail@gmail.com',
					'website'=>'www.tdtech.com',
				),*/
			),
		);
	
		$this->outputResult( SUCCESS, base64_encode(CJSON::encode($profile)) );
	}
	
	public function actionUploadTest()
	{
		$userid = Yii::app()->request->getParam(P_USERID);
		$securekey = Yii::app()->request->getParam(P_SECUREKEY);
		$params = Yii::app()->request->getParam(P_PARAMS);
		
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	
	public function getPhotoFilePath( $file_name )
	{
		$dir_path = "uploads/";
		$file_path = $dir_path . $file_name;

		return $file_path;
	}
	
	public function actionUpload()
	{
		$user = $this->checkUserValidity();

		$action = Yii::app()->request->getParam(P_ACTION);		
		if( $action == null )
			$this->outputResult( MISSING_PARAMETER );
			
		if( $action == 'uploadphoto' )
		{
			$file_ext	= pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
			$file_name = $user->id . '_' . time() . '.' . $file_ext;
			$file_path = $this->getPhotoFilePath( $file_name );
		
			if( !move_uploaded_file($_FILES["myfile"]["tmp_name"], $file_path) )
				$this->outputResult(SERVER_INTERNAL_ERROR, 'There was an error uploading your file.');
				
			if( $user->photo_filename != '' )
			{
				$old_filepath = $this->getPhotoFilePath( $user->photo_filename );
				
				if( file_exists($old_filepath) )
					unlink( $old_filepath );
			}

			$user->photo_filename = $file_name;
			if( !$user->save() )
				$this->outputResult(SERVER_INTERNAL_ERROR, $user->getErrors() );

			$this->outputResult(SUCCESS, $file_name );
		}
		else if( $action == 'sharepicture' )
		{
			$file_ext	= pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
			$file_name = $user->id . '_' . time() . '.' . $file_ext;
			$file_path = $this->getPhotoFilePath( $file_name );
		
			if( !move_uploaded_file($_FILES["myfile"]["tmp_name"], $file_path) )
				$this->outputResult(SERVER_INTERNAL_ERROR, 'There was an error uploading your file.');

			$model = new UserPicture;
			$model->user_id = $user->id;
			$model->img_path = $file_name;
			$model->reg_stamp = time();
			
			if( !$model->save() )
				$this->outputResult(SERVER_INTERNAL_ERROR, $model->getErrors() );

/*
			$this->outputResult(SUCCESS, array(
				'id'=>$model->id,
				'filename'=>$file_name
				)
			);*/
			
			$this->outputResult(SUCCESS, $model);
		}

		$this->outputResult( INVALID_PARAMETER );
	}
	
	public function actionAddContact( )
	{
		$user = $this->checkUserValidity();
		
		$params = Yii::app()->request->getParam(P_PARAMS);
		if( $params == null )
			$this->outputResult( MISSING_PARAMETER );

		$params = CJSON::decode(base64_decode($params));

		if( !isset($params['country_id']) || !isset($params['mobile']) )
			$this->outputResult( MISSING_PARAMETER );

		if( $params['country_id'] == '' || $params['mobile'] == '' )
			$this->outputResult( MISSING_PARAMETER );

		$mobile = $this->getGlobalMobile( $params['country_id'], $params['mobile'] );
		$model = Contact::modelById($user->id)->find('mobile=?',array($mobile));
		if( $model != null )
			$this->outputResult( USER_EXIST, '', 'Contact mobile number already exists' );

		$contact = Contact::newModel( $user->id );
		$contact->id = $params['id'];
		$contact->attributes = $params;
		$contact->mobile = $mobile;
		if( !$contact->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $contact->getErrors() );
		
		$photo_filename = '';
		$user = User::model()->find('mobile=?',array($mobile));		
		if( $user != null )
			$photo_filename = $user->photo_filename;
		
		$result = array( 'id'=>$contact->id,
			'name'=>$contact->name,
			'pname'=>$contact->pname,
			'email'=>$contact->email,
			'homeaddr'=>$contact->homeaddr,
			'housetel'=>$contact->housetel,
			'birthday'=>$contact->birthday,
			'class_id'=>$contact->class_id,
			'group_id'=>$contact->group_id,
			'mobile'=>$contact->mobile,
			'country_id'=>$contact->country_id,
			'photo_filename'=>$photo_filename,
		);
			
		$this->outputResult( SUCCESS, $result );
	}
	
	public function actionAddContactTest()
	{
		$profile = array(
			'mobile'=>'123456789',
			'country_id'=>'1',
			'pname'=>'Zao',
			'name'=>'WangZao',
			'email'=>'zao@gmail.com',
			'homeaddr'=>'Beijing chaoyangqu wangjing',
			'housetel'=>'024401234',
			'birthday'=>'1991/03/27',
			'class_id'=>'1',
			'group_id'=>'1',
		);
		$this->outputResult( SUCCESS, base64_encode(CJSON::encode($profile)) );
	}
	
	public function actionAddContactList( )
	{
		$user = $this->checkUserValidity();
		
		$params = Yii::app()->request->getParam(P_PARAMS);
		if( $params == null )
			$this->outputResult( MISSING_PARAMETER );

		$params = CJSON::decode(base64_decode($params));
		
		$result = array();
		
		for( $i = 0; $i < count($params); $i++ )
		{
			$contact_item = $params[$i];
			
			if( !isset($contact_item['country_id']) || !isset($contact_item['mobile']) )
			{
				$result = array_merge( $result, array(array('retcode' => MISSING_PARAMETER, 'content' => '', 'error_msg'=>'Missing Parameter')) );
				continue;
			}

			$mobile = $this->getGlobalMobile( $contact_item['country_id'], $contact_item['mobile'] );
			$contact = Contact::modelById($user->id)->find('mobile=?',array($mobile));
			if( $contact != null )
			{
				$photo_filename = '';
				$contact_user = User::model()->find('mobile=?',array($mobile));		
				if( $contact_user != null )
					$photo_filename = $contact_user->photo_filename;
			
				$contact_detail = array( 'id'=>$contact->id,
					'name'=>$contact->name,
					'pname'=>$contact->pname,
					'email'=>$contact->email,
					'homeaddr'=>$contact->homeaddr,
					'housetel'=>$contact->housetel,
					'birthday'=>$contact->birthday,
					'class_id'=>$contact->class_id,
					'group_id'=>$contact->group_id,
					'mobile'=>$contact->mobile,
					'country_id'=>$contact->country_id,
					'photo_filename'=>$photo_filename,
				);

				$contact_res = array(array( 'retcode' => USER_EXIST, 'content' => $contact_detail, 'error_msg' => 'Contact mobile number already exists' ));

				$result = array_merge( $result, $contact_res );
				continue;
			}

			$contact = Contact::newModel( $user->id );
			$contact->attributes = $contact_item;
			$contact->mobile = $mobile;
			if( !$contact->save() )
			{
				$result = array_merge( $result, array(array('retcode' => SERVER_INTERNAL_ERROR, 'content' => '', 'error_msg'=>$contact->getErrors())) );
				continue;
			}

			$photo_filename = '';
			$contact_user = User::model()->find('mobile=?',array($mobile));		
			if( $contact_user != null )
				$photo_filename = $contact_user->photo_filename;
		
			$contact_detail = array( 'id'=>$contact->id,
				'name'=>$contact->name,
				'pname'=>$contact->pname,
				'email'=>$contact->email,
				'homeaddr'=>$contact->homeaddr,
				'housetel'=>$contact->housetel,
				'birthday'=>$contact->birthday,
				'class_id'=>$contact->class_id,
				'group_id'=>$contact->group_id,
				'mobile'=>$contact->mobile,
				'country_id'=>$contact->country_id,
				'photo_filename'=>$photo_filename,
			);
			
			$contact_res = array(array( 'retcode' => SUCCESS, 'content' => $contact_detail, 'error_msg' => '' ));

			$result = array_merge( $result, $contact_res );
		}

		$this->outputResult( SUCCESS, $result );
	}
	
	public function actionUpdateContactList( )
	{
		$user = $this->checkUserValidity();
		
		$params = Yii::app()->request->getParam(P_PARAMS);
		if( $params == null )
			$this->outputResult( MISSING_PARAMETER );

		//$this->outputResult( SUCCESS, base64_decode($params) );
		//$this->outputResult( SUCCESS, $params );
			
		$params = CJSON::decode(base64_decode($params));
		
		$result = array();
		
		for( $i = 0; $i < count($params); $i++ )
		{
			$contact_item = $params[$i];
			
			//$this->outputResult( SUCCESS, $contact_item );
			
			if( !isset($contact_item['country_id']) || !isset($contact_item['mobile']) )
			{
				$result = array_merge( $result, array(array('retcode' => MISSING_PARAMETER, 'content' => '', 'error_msg'=>'Missing Parameter')) );
				continue;
			}

			$mobile = $this->getGlobalMobile( $contact_item['country_id'], $contact_item['mobile'] );
			//$contact = Contact::modelById($user->id)->find("id=" . $contact_item['id']);
			$contact = Contact::modelById($user->id)->findByPk( $contact_item['id'] );
			if( $contact == null )
				$contact = Contact::newModel( $user->id );
			
			$contact->attributes = $contact_item;
			
			$contact->mobile = $mobile;
			
			if( !$contact->save() )
			{
				$result = array_merge( $result, array(array('retcode' => SERVER_INTERNAL_ERROR, 'content' => '', 'error_msg'=>$contact->getErrors())) );
				continue;
			}

			$photo_filename = '';
			$contact_user = User::model()->find('mobile=?',array($mobile));		
			if( $contact_user != null )
				$photo_filename = $contact_user->photo_filename;
		
			$contact_detail = array( 'id'=>$contact->id,
				'name'=>$contact->name,
				'pname'=>$contact->pname,
				'email'=>$contact->email,
				'homeaddr'=>$contact->homeaddr,
				'housetel'=>$contact->housetel,
				'birthday'=>$contact->birthday,
				'class_id'=>$contact->class_id,
				'group_id'=>$contact->group_id,
				'mobile'=>$contact->mobile,
				'country_id'=>$contact->country_id,
				'photo_filename'=>$photo_filename,
			);
			
			$contact_res = array(array( 'retcode' => SUCCESS, 'content' => $contact_detail, 'error_msg' => '' ));

			$result = array_merge( $result, $contact_res );
		}

		$this->outputResult( SUCCESS, $result );
	}
	
	public function actionAddContactListTest()
	{
		$profile1 = array(
			'id'=>'1',
			'mobile'=>'1912462758',
			'country_id'=>'1',
			'pname'=>'song',
			'name'=>'songmi',
			'email'=>'zao@gmail.com',
			'homeaddr'=>'Beijing chaoyangqu wangjing',
			'housetel'=>'024401234',
			'birthday'=>'1991/03/27',
			'class_id'=>'1',
			'group_id'=>'1',
		);
		$profile2 = array(
			'id'=>'2',
			'mobile'=>'1913462544',
			'country_id'=>'1',
			'pname'=>'mingming',
			'name'=>'ryon',
			'email'=>'zao@gmail.com',
			'homeaddr'=>'Beijing chaoyangqu wangjing',
			'housetel'=>'024401234',
			'birthday'=>'1991/03/27',
			'class_id'=>'1',
			'group_id'=>'1',
		);
		$profile3 = array(
			'id'=>'3',
			'mobile'=>'1915454875',
			'country_id'=>'1',
			'pname'=>'Zao',
			'name'=>'WangZao',
			'email'=>'zao@gmail.com',
			'homeaddr'=>'Beijing chaoyangqu wangjing',
			'housetel'=>'024401234',
			'birthday'=>'1991/03/27',
			'class_id'=>'1',
			'group_id'=>'1',
		);
		
		$params = array( $profile1, $profile2, $profile3 );
		
		$this->outputResult( SUCCESS, base64_encode(CJSON::encode($params)) );
	}
	
	public function actionDeleteContact()
	{
		$user = $this->checkUserValidity();		
		$contact_id = Yii::app()->request->getParam('contact_id');
		if( $contact_id == null )
			$this->outputResult( MISSING_PARAMETER );
			
		Contact::modelById($user->id)->deleteByPk($contact_id);

		$this->outputResult( SUCCESS );
	}
	
	public function actionUpdateContact()
	{
		$user = $this->checkUserValidity();

		$contact_id = Yii::app()->request->getParam('contact_id');
		$params = Yii::app()->request->getParam(P_PARAMS);
		if( $params == null || $contact_id == null )
			$this->outputResult( MISSING_PARAMETER );

		$params = CJSON::decode(base64_decode($params));

		if( !isset($params['country_id']) || !isset($params['mobile']) )
			$this->outputResult( MISSING_PARAMETER );

		if( $params['country_id'] == '' || $params['mobile'] == '' )
			$this->outputResult( MISSING_PARAMETER );
			
		$contact = Contact::modelById($user->id)->findByPk($contact_id);
		if( $contact == null )
			$this->outputResult( INVALID_PARAMETER, '', 'Can not find the contact with input id' );
			
		$mobile = $this->getGlobalMobile( $params['country_id'], $params['mobile'] );
		$model = Contact::modelById($user->id)->find('id<>' . $contact_id . ' and mobile=?',array($mobile));
		if( $model != null )
			$this->outputResult( INVALID_PARAMETER, '', 'Contact mobile number already exists' );

		$contact->attributes = $params;
		$contact->mobile = $mobile;
		if( !$contact->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $contact->getErrors() );

		$this->outputResult( SUCCESS, $contact );
	}
			
	public function actionGetContactPhoto()
	{
		$user = $this->checkUserValidity();

		$contact_id = Yii::app()->request->getParam('contact_id');
		if( $contact_id == null )
			$this->outputResult( MISSING_PARAMETER );

		$contact = Contact::modelById($user->id)->with('user')->findByPk($contact_id);
		if( $contact == null )
			$this->outputResult( INVALID_PARAMETER, '', 'Can not find the contact with input id' );
		
		$photo_filename = '';
		if( isset($contact->user) && $contact->user != null )
			$photo_filename = $contact->user->photo_filename;

		$this->outputResult( SUCCESS, array('photo_filename'=>$photo_filename) );
	}
			
	public function actionGetContactDetail()
	{
		$user = $this->checkUserValidity();

		$contact_id = Yii::app()->request->getParam('contact_id');
		if( $contact_id == null )
			$this->outputResult( MISSING_PARAMETER );

		$contact = Contact::modelById($user->id)->with('user')->findByPk($contact_id);
		if( $contact == null )
			$this->outputResult( INVALID_PARAMETER, '', 'Can not find the contact with input id' );
		
		$result = array('offline'=>$contact);
		if( isset($contact->user) && $contact->user != null )
		{
			$contact_user_id = $contact->user->id;
			
			$share_pictures = UserPicture::model()->findAll('user_id=' . $contact_user_id);
			
			$result = array_merge( $result, array(
					'online'=>array(
						'user_id'=>$contact->user->id,
						'name'=>$contact->user->name,
						'mobile'=>$contact->user->mobile,
						'pname'=>$contact->user->pname,
						'email'=>$contact->user->email,
						'homeaddr'=>$contact->user->homeaddr,
						'housetel'=>$contact->user->housetel,
						'birthday'=>$contact->user->birthday,
						'photo_filename'=>$contact->user->photo_filename,
						'class_id'=>$contact->user->class_id,
						'company'=>$contact->user->company,
						'share_pictures'=>$share_pictures,
					)
				)
			);
		} 
		
		$this->outputResult( SUCCESS, $result );
	}
	
	public function actionGetContactList()
	{
		$user = $this->checkUserValidity();
		
		$contacts = Contact::modelById($user->id)->findAll();
		
		$this->outputResult( SUCCESS, $contacts );
	}
	
	public function actionAddGroup()
	{
		$this->actionUpdateGroup();
	}
	
	public function actionDeleteGroup( )
	{
		$user = $this->checkUserValidity();

		$group_id = Yii::app()->request->getParam('id');
		if( $group_id == null )
			$this->outputResult( MISSING_PARAMETER );
			
		Group::modelById($user->id)->deleteByPk($group_id);

		$this->outputResult( SUCCESS );
	}
	
	public function actionUpdateGroup( )
	{
		$user = $this->checkUserValidity();
		
		$group_id = Yii::app()->request->getParam('id');
		$group_name = Yii::app()->request->getParam('group_name');
		if( $group_id == null || $group_name == null )
			$this->outputResult( MISSING_PARAMETER );
			
		$group_name = base64_decode($group_name);
		$model = Group::modelById($user->id)->find('id<>' . $group_id . ' and name=?',array($group_name));
		if( $model != null )
			$this->outputResult( INVALID_PARAMETER, '', 'Group name is already exists' );
		
		$group = Group::modelById($user->id)->findByPk($group_id);
		if( $group == null )
		{
			$group = Group::newModel( $user->id );
			$group->id = $group_id;
		}

		$group->name = $group_name;
		if( !$group->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $group->getErrors() );

		$this->outputResult( SUCCESS, $group );
	}
	
	public function actionGetGroupList( )
	{
		$user = $this->checkUserValidity();
		
		$groups = Group::modelById($user->id)->findAll();
		
		$this->outputResult( SUCCESS, $groups );
	}
	
	public function actionAddGroupContacts( )
	{
		$user = $this->checkUserValidity();

		$group_id = Yii::app()->request->getParam('group_id');
		$contact_ids = Yii::app()->request->getParam('contact_ids');
		
		if( $group_id == null || $contact_ids == null )
			$this->outputResult( MISSING_PARAMETER );
		
		$contact_ids = str_replace(' ', '', $contact_ids);
		$contact_ids = explode(',', $contact_ids);
		
		for( $idx = 0; $idx < count($contact_ids); $idx++ )
		{
			$contact = Contact::modelById($user->id)->findByPk($contact_ids[$idx]);
			if( $contact == null )
				continue;
			
			$contact->group_id = $group_id;
			if( !$contact->save() )
				$this->outputResult( SERVER_INTERNAL_ERROR, $contact->getErrors() );
		}
	
		$this->outputResult( SUCCESS );
	}

	public function actionDeleteGroupContacts( )
	{
		$user = $this->checkUserValidity();

		$contact_ids = Yii::app()->request->getParam('contact_ids');
		
		if( $contact_ids == null )
			$this->outputResult( MISSING_PARAMETER );
		
		$contact_ids = str_replace(' ', '', $contact_ids);
		$contact_ids = explode(',', $contact_ids);

		for( $idx = 0; $idx < count($contact_ids); $idx++ )
		{
			$contact = Contact::modelById($user->id)->findByPk($contact_ids[$idx]);
			if( $contact == null )
				continue;
			
			$contact->group_id = 0;
			if( !$contact->save() )
				$this->outputResult( SERVER_INTERNAL_ERROR, $contact->getErrors() );
		}

		$this->outputResult( SUCCESS );
	}
	
	public function actionAddCallHistory( )
	{
		$user = $this->checkUserValidity();

		$to_mobile = Yii::app()->request->getParam('to_mobile');
		$starttime = Yii::app()->request->getParam('starttime');
		$endtime = Yii::app()->request->getParam('endtime');
		if( $to_mobile == null || $starttime == null || $endtime == null )
			$this->outputResult( MISSING_PARAMETER );
			
		$to_mobile = base64_decode($to_mobile);
		
		$model = new CallHistory();

		$model->from_mobile = $user->mobile;
		$model->to_mobile = $to_mobile;
		$model->starttime = $starttime;
		$model->endtime = $endtime;
		
		if( !$model->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $model->getErrors() );

		$this->outputResult( SUCCESS );
	}
	
	public function actionDeleteCallHistory( )
	{
		$user = $this->checkUserValidity();

		$to_mobile = Yii::app()->request->getParam('to_mobile');
		if( $to_mobile == null )
			$this->outputResult( MISSING_PARAMETER );
			
		$to_mobile = base64_decode($to_mobile);
		
		CallHistory::model()->deleteAll($condition,$params);

		$this->outputResult( SUCCESS );
	}
	
	public function actionGetCallHistory( )
	{
		$user = $this->checkUserValidity();
		
		$model = CallHistory::model()->findAll('from_mobile=?',array($user->mobile));

		$this->outputResult( SUCCESS, $model );
	}
	
	public function actionAddSmsHistory( )
	{
		$user = $this->checkUserValidity();

		$to_mobile = Yii::app()->request->getParam('to_mobile');
		$msg_content = Yii::app()->request->getParam('msg_content');
		$sendtime = Yii::app()->request->getParam('sendtime');
		if( $to_mobile == null || $msg_content == null || $sendtime == null )
			$this->outputResult( MISSING_PARAMETER );

		$to_mobile = base64_decode($to_mobile);
		$msg_content = base64_decode($msg_content);
		
		$model = new SmsHistory();

		$model->from_mobile = $user->mobile;
		$model->to_mobile = $to_mobile;
		$model->content = $msg_content;
		$model->sendtime = $sendtime;
		$model->receivetime = time();
		
		if( !$model->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $model->getErrors() );

		$this->outputResult( SUCCESS );
	}
	
	public function actionGetSmsHistory( )
	{
		$user = $this->checkUserValidity();
		
		$model = SmsHistory::model()->findAll('from_mobile=?',array($user->mobile));

		$this->outputResult( SUCCESS, $model );
	}
	
	public function actionUpdateLocation( )
	{
		$user = $this->checkUserValidity();

		$latitude = Yii::app()->request->getParam('latitude');
		$longitude = Yii::app()->request->getParam('longitude');
		if( $latitude == null || $longitude == null )
			$this->outputResult( MISSING_PARAMETER );
		
		$model = Location::model()->find('user_id=?',array($user->id));
		if( $model == null )
			$model = new Location();
			
		$model->user_id = $user->id;
		$model->latitude = $latitude;
		$model->longitude = $longitude;
		$model->update_stamp = time();

		if( !$model->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $model->getErrors() );

		$this->outputResult( SUCCESS );
	}
	
	public function actionGetContactLocations( )
	{
		$user = $this->checkUserValidity();
		
		$contacts = Contact::modelById($user->id)->findAll();
		
		$contact_list = array();
		
		foreach( $contacts as $contact )
		{
			$contact_info = array();
			
			$contact_info['id'] = $contact->id;
			
			$contact_info['mobile'] = $contact->mobile;
			
			if( $contact->user != null )
			{
				$location = Location::model()->find('user_id=?',array($contact->user->id));
				
				if( $location == null )
				{
					$contact_info['latitude'] = '-';
					$contact_info['longitude'] = '-';
				}
				else
				{
					$contact_info['latitude'] = $location->latitude;
					$contact_info['longitude'] = $location->longitude;
				}
			}
			else
			{
				$contact_info['latitude'] = '-';
				$contact_info['longitude'] = '-';
			}
			
			$contact_list[] = $contact_info;
		}
		
		$this->outputResult( SUCCESS, $contact_list );
	}
	
	public function actionRemoveSharePicture( )
	{
		$user = $this->checkUserValidity();
		$picture_id = Yii::app()->request->getParam('picture_id');
		if( $picture_id == null )
			$this->outputResult( MISSING_PARAMETER );
			
		
		$model = UserPicture::model()->findByPk($picture_id);
		if( $model == null )
			$this->outputResult( INVALID_PARAMETER, 'There is no picture with picture_id' );
				
		if( $model->img_path != '' )
		{
			$old_filepath = $this->getPhotoFilePath( $model->img_path );
			
			if( file_exists($old_filepath) )
				unlink( $old_filepath );
		}
		
		$model->delete();

		$this->outputResult(SUCCESS);
	}
	
	public function actionGetContactSharePictures( )
	{
		$user = $this->checkUserValidity();
		$contact_id = Yii::app()->request->getParam('contact_id');
		if( $contact_id == null )
			$this->outputResult( MISSING_PARAMETER );

		$contact = Contact::modelById($user->id)->with('user')->findByPk($contact_id);
		if( $contact == null )
			$this->outputResult( INVALID_PARAMETER, '', 'Can not find the contact with input id' );
		
		if( isset($contact->user) && $contact->user != null )
		{
			$contact_user_id = $contact->user->id;
			
			$model = UserPicture::model()->findAll('user_id=' . $contact_user_id);
			
			$this->outputResult( SUCCESS, $model );	
		}
		else
			$this->outputResult( SUCCESS, array() );
	}

	public function actionTest()
	{
		$mobile = "Hello! This is a test message.";
		$mobile = base64_encode($mobile);
		
		//$url = Yii::app()->baseUrl . "/phone_prefix/names.json";
                $url = "http://localhost/phonebook/phone_prefix/names.json";
		//$ch = curl_init( Yii::app()->baseUrl . "/phone_prefix/names.json");
		// Execute post
		//$file = curl_exec($ch);
                $file = file_get_contents($url);
		
		//$file = html_doc_file(Yii::app()->baseUrl . "/phone_prefix/names.json");
		$names = CJSON::decode($file);
		
		//$names = http_get(Yii::app()->baseUrl . "/phone_prefix/names.json");
	
		$this->outputResult( SUCCESS, $names['US'], $url );
	}

	public function actionSendReport( )
	{
		$user = $this->checkUserValidity();

		$msg_content = Yii::app()->request->getParam('content');		
	
		if( $msg_content == null )
			$this->outputResult( MISSING_PARAMETER );

		$msg_content = base64_decode($msg_content);

		$model = new Report();

		$model->user_id = $user->id;
		$model->content = $msg_content;
		$model->timestamp = time();
		
		if( !$model->save() )
			$this->outputResult( SERVER_INTERNAL_ERROR, $model->getErrors() );

		$this->outputResult( SUCCESS );
	}

	public function actionGetUserInfo()
	{
		$user = $this->checkUserValidity();
		
		$groups = Group::modelById($user->id)->findAll();
		$contacts = Contact::modelById($user->id)->findAll();
		$smshistory = SmsHistory::model()->findAll('from_mobile=?',array($user->mobile));
		$callhistory = CallHistory::model()->findAll('from_mobile=?',array($user->mobile));
		
		$info = array(
			'groups' => $groups,
			'contacts' => $contacts,
			'smshistory' => $smshistory,
			'callhistory' => $callhistory,
		);

		$this->outputResult( SUCCESS, $info );
	}
}