<?php

/**
 * This is the model class for table "admin".
 *
 * The followings are the available columns in table 'admin':
 * @property string $id
 * @property string $email
 * @property string $username
 * @property string $contactno
 * @property string $password
 * @property string $reg_stamp
 * @property string $status
 */
class Admin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, username, contactno, password, reg_stamp, status', 'required'),
			array('email', 'length', 'max'=>100),
			array('username', 'length', 'max'=>50),
			array('contactno', 'length', 'max'=>20),
			array('password', 'length', 'max'=>225),
			array('reg_stamp, status', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, username, contactno, password, reg_stamp, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'username' => 'Admin Name',
			'contactno' => 'Contact No',
			'password' => 'Password',
			'reg_stamp' => 'Registered',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('contactno',$this->contactno,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('reg_stamp',$this->reg_stamp,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}

	public static function findByEmail( $email )
	{
		//$user = $this->find("email='" . $email . "'");
		$user = Admin::model()->find("email='" . $email . "'");
		
		return $user;
	}
	
	public function addAdmin( $admin_info )
	{
		$email_user = $this->findByEmail( $admin_info['email'] );
		
		if( $email_user !== null )
			return Functions::GetMessage ('ACCOUNT_EMAIL_IN_USE', array($admin_info['email']));
		
		if( $admin_info['password1'] !== $admin_info['password2'] )
			return Functions::GetMessage ('ACCOUNT_PASS_MISMATCH');
		
		if( strlen($admin_info['password1']) < 6 || strlen($admin_info['password1']) > 32 )
			return Functions::GetMessage ('ACCOUNT_PASS_CHAR_LIMIT', array(6, 32));
		
		$admin_info['password'] = Functions::generateHash($admin_info['password1'] );
		$admin_info['reg_stamp'] = time(); 

		$this->attributes=$admin_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
	
	public function saveAdmin( $admin_info )
	{
		// if change the email
		if( $admin_info['email'] !== $this->email )
		{
			$email_user = $this->findByEmail( $admin_info['email'] );
		
			if( $email_user !== null && $email_user->id !== $this->id )
				return Functions::GetMessage ('ACCOUNT_EMAIL_IN_USE', array($admin_info['email']));
		}
		
		if( $admin_info['password1'] !== $admin_info['password2'] )
			return Functions::GetMessage ('ACCOUNT_PASS_MISMATCH');
		
		if( strlen($admin_info['password1']) < 6 || strlen($admin_info['password1']) > 32 )
			return Functions::GetMessage ('ACCOUNT_PASS_CHAR_LIMIT', array(6, 32));
		
		if( strlen($admin_info['contactno']) > 20 )
			return "Contact No must be less than 20 characters in length.";
		
		$admin_info['password'] = Functions::generateHash($admin_info['password1'] );

		$this->attributes=$admin_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
}