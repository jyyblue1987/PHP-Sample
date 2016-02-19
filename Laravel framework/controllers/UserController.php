<?php

require_once('openfire_api.php');

function convertMobileNumber($number)
{
	return "+" . str_replace("_", " ", $number);
}		
class UserController extends Controller
{
	function login()
	{
		return View::make('login'); //
	}
	
	function logout()
	{
		$_SESSION["login"] = '0';
		$_SESSION["email"] = '';
		unset($_SESSION['login']); 
			
		return Redirect::to('login');
	}
	
	public function postLogin()
	{
/* 		$default_email = 'admin@gmail.com';
		
		if (User::where('email', '=', $default_email)->exists() === false) {
			$user = new User();
			$user->email = $default_email;
			$user->password = Hash::make('healthcare');
			$user->save();
		} */
		
		$email = Input::get('email');
		$password = Input::get('password');
		
		if (Auth::attempt(['email' => $email, 'password' => $password])) {
			$_SESSION["email"] = $email;
			$_SESSION["login"] = '1';
			return Redirect::to('/');
        }
		else
		{
			$_SESSION["login"] = '0';
			$_SESSION["email"] = '';
			return Redirect::to('login');
		}	
	}
	
	function index()
	{	
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
				
		$item = Input::get('pageSize');
		
		if($item == null)
		{
			$item = 10;				
		}
			
		$users = OfUser::where('username', '<>', 'admin')->paginate($item);	
		foreach( $users as &$value )	
		{
			$value['mobile'] = convertMobileNumber($value['username']);	
			if( $value['email'] === 'false' )
				$value['email'] = '';
			if( $value['name'] === 'false' )
				$value['name'] = '';
		}
		
		
		return View::make('users.user')->with('users', $users)->with('item_v',$item);
	}
	
	function search()
	{	
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
		$input = Input::get('name');
		$item = Input::get('pageSize');
		if($item == null)
		{
			$item = 10;				
		}
		
		$user = OfUser::where('username', 'like', '%' . $input . '%')
						->orWhere('name', 'like', '%' . $input . '%')
						->orWhere('email', 'like', '%' . $input . '%')
							->paginate($item);
		foreach( $user as &$value )	
		{
			$value['mobile'] = convertMobileNumber($value['username']);	
			if( $value['email'] === 'false' )
				$value['email'] = '';
			if( $value['name'] === 'false' )
				$value['name'] = '';
		}
		
		return View::make('users.user')->with('users', $user)->with('item_v',$item);
	}
	
	function process($id = AUTH)	
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
		//echo $id;
		return View::make('users.process')->with('action', $id);
	}
	function email()
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
		
		$error = '';
		
		if( Request::isMethod('post') )
		{
			$admin = Admin::where('email', '=', $_SESSION['email'])->first();
			if( empty($admin) )
				return Redirect::to('login');
			
			if( Input::get('password1') !== Input::get('password2') )
				$error = Functions::GetMessage ('ACCOUNT_PASS_MISMATCH');
			else if( strlen(Input::get('password1')) < 6 || strlen(Input::get('password1')) > 32 )
				$error = Functions::GetMessage('ACCOUNT_PASS_CHAR_LIMIT', array(6, 32));
			else
			{
				$admin->email = Input::get('email');
				$admin->name = Input::get('username');
				$admin->password = Hash::make(Input::get('password1'));
				$admin->save();
				
				$_SESSION['email'] = $admin->email;	
				$error = 'SUCCESS';
			}
		}
		else
		{
			$email = $_SESSION["email"];
			$admin = Admin::where('email', '=', $email)->first();
		}
		return View::make('users.email')->with('admin', $admin)->with('error',$error);		
	}
	
	function update()
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
		if( !isset($_SESSION['email']) ) 
		{
			return Redirect::to('login');
		}
		
		return Redirect::to('/');	
	}
	
	function userprofile()
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return Redirect::to('login');
		}
		
		$username = Input::get('pname');
		$userinfo = UserProfile::where('username', '=', $username)->first();
		
		if( empty($userinfo) )
		{
			$profile = array();	
			$profile['mobile'] = convertMobileNumber($username);
			return View::make('users.exceptuserprofile')->with('profile',$profile);
		}
		
		$xml_parser = xml_parser_create() or die ("cannot create xml parser");
		xml_parse_into_struct($xml_parser, $userinfo->vcard, $value, $index);  
		xml_parser_free($xml_parser);  
		
		$middle = '';
		$family = '';
		foreach($value as $v){  
			if( $v['tag'] === 'MIDDLE' )
			{
				$middle = $v['value'];
			}
			if( $v['tag'] === 'FAMILY' )
			{
				$family = $v['value'];
			}
		}
	
		$profile = json_decode($middle, true);	
		$profile['mobile'] = convertMobileNumber($username);
		if( $profile['role'] === '0' )
			$profile['role'] = 'Patient';
		else
			$profile['role'] = 'Doctor';
	
		return View::make('users.userprofile')->with('profile',$profile);
	}
}
