<?php 

function generateRandomNumber($length = 10) {
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';	
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class User extends Eloquent { 
	protected $table = 'hc_user';
	
	protected $fillable = array('username', 'email', 'vcode', 'expire');
	public $timestamps = false;
	
	public function comments()
    {
        return $this->hasMany('App\Models\OfflineMessage', 'username', 'username');
    }
	
	public static function registerUser($number, $device, $pushkey)
	{
		$user = User::where('username', '=', $number)->first();
		
		if( empty($user) )	// user does not exist
		{
			// create user
			$user = new User();
			$user->username = $number;			
			$user->active = 0;
		}
		else
		{			
			if( $user->active === 1 ) // user is activated
			{
				// set device and pushkey, token
				$user->device = $device;
				
				if( !empty($pushkey) )
					$user->pushkey = $pushkey;

				$user->token = generateRandomString(20);
			
				$user->save();
				
				return $user;			
			}
			$user->active = 0;	
		}
		
		$user->vcode = generateRandomNumber(6);		
		$user->expire = time() + 600;		
			
		$user->save();
		
		return $user;
	}
	
	public static function isRightVerifyCode($number, $vcode)
	{
		$user = User::where('username', '=', $number)->first();
		
		if( empty($user) )	// no user
			return 1;
		
		if( $user->vcode !== $vcode ) // verify code is not correct
			return 2;
		
		
		if( $user->expire < time() ) // expire
			return 3;
					
		return 0;			
	}
	
	public static function activateUser($number, $device, $pushkey)
	{
		$user = User::where('username', '=', $number)->first();
		
		if( empty($user) )
			return;
		
		$user->active = 1;				
		$user->device = $device;
		if( !empty($pushkey) )
			$user->pushkey = $pushkey;
		$user->token = generateRandomString(20);
			
		$user->save();
		
		return $user;
	}
	
	public static function deleteUser($number)
	{
		$user = User::where('username', '=', $number)->first();
		
		if( empty($user) )
			return;
		
		$user->delete();
		
		return $user;
	}
	
	public static function login($number, $device, $pushkey)
	{
		$user = User::where('username', '=', $number)->first();
		
		if( empty($user) )
			return;
		
		if( $user->active !== 1 )	// inactive
		{
			$user->vcode = generateRandomNumber(6);		
			$user->expire = time() + 120;						
			$user->save();
		
			return $user;
		}
		
		$user->device = $device;
		if( !empty($pushkey) )
			$user->pushkey = $pushkey;
		$user->token = generateRandomString(20);
			
		$user->save();
		
		return $user;
	}
}