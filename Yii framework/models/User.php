<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $mobile
 * @property string $country_id
 * @property string $name
 * @property string $pname
 * @property string $password
 * @property string $email
 * @property string $homeaddr
 * @property string $housetel
 * @property integer $birthday
 * @property integer $status
 * @property string $vcode
 * @property integer $is_verified
 * @property integer $reg_stamp
 * @property integer $login_stamp
 * @property integer $is_online
 * @property string $securekey
 * @property integer $class_id
 * @property string $photo_filename
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobile, country_id, password, reg_stamp', 'required'),
			array('status, reg_stamp, login_stamp, is_online, class_id', 'numerical', 'integerOnly'=>true),
			array('mobile, housetel', 'length', 'max'=>20),
			array('birthday', 'length', 'max'=>30),
			array('country_id', 'length', 'max'=>11),
			array('name, pname, vcode, securekey, photo_filename', 'length', 'max'=>50),
			array('password', 'length', 'max'=>225),
			array('email', 'length', 'max'=>100),
			array('homeaddr', 'length', 'max'=>150),
			array('device', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mobile, country_id, name, pname, password, email, homeaddr, housetel, birthday, status, vcode, is_verified, reg_stamp, login_stamp, is_online, securekey, class_id, photo_filename, country.name', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'classification' => array(self::BELONGS_TO, 'Classification', 'class_id'),
			'company' => array(self::HAS_MANY, 'Company', 'user_id'),
			//'aCardHistoryComments' => array(self::HAS_MANY, 'ACardHistoryComments', 'a_card_history_id'),
            //'retouchHistory' => array(self::HAS_MANY, 'RetouchHistory', 'a_card_history_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mobile' => 'Mobile',
			'country_id' => 'Country',
			'name' => 'User Name',
			'pname' => 'Preferred Name',
			'password' => 'Password',
			'email' => 'Email',
			'homeaddr' => 'Home Address',
			'housetel' => 'House Tel',
			'birthday' => 'Birthday',
			'status' => 'Status',
			'vcode' => 'Vcode',
			'is_verified' => 'Is Verified',
			'reg_stamp' => 'Registered',
			'login_stamp' => 'Login Time',
			'update_stamp' => 'Updated',
			'is_online' => 'Is Online',
			'securekey' => 'Secure Key',
			'class_id' => 'Classification',
			'photo_filename' => 'Photo File Name',
			'country.name' => 'Country',
			'classification.name' => 'Classification',
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

		$criteria->with = array( 'country', 'classification' );
		
		$criteria->compare('id',$this->id,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('homeaddr',$this->homeaddr,true);
		$criteria->compare('housetel',$this->housetel,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('status',$this->status);
		$criteria->compare('vcode',$this->vcode,true);
		$criteria->compare('reg_stamp',$this->reg_stamp);
		$criteria->compare('login_stamp',$this->login_stamp);
		$criteria->compare('is_online',$this->is_online);
		$criteria->compare('securekey',$this->securekey,true);
		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('country.name','',true);
		
		//$criteria->addInCondition( 'a_card_id', $customerList );

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'name'=>array(
	                	'asc'=>'t.name="", t.name ASC',
                		'desc'=>'t.name DESC',
            		),
					'country.name'=>array(
	                	'asc'=>'country.name',
                		'desc'=>'country.name DESC',
            		),
					'classification.name'=>array(
						//'asc'=>'classification.name ASC',
						'asc'=>'classification.name is null, classification.name ASC',
                		'desc'=>'classification.name DESC',
						//'desc'=>'classification.name is not null, classification.name DESC',
            		),
            		'*',
        		),
    		),
		));
	}
	
	public function searchInContactList( $contactIDList)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id,true);
		$criteria->addInCondition( 'id', $contactIDList );
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('homeaddr',$this->homeaddr,true);
		$criteria->compare('housetel',$this->housetel,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('status',$this->status);
		$criteria->compare('vcode',$this->vcode,true);
		$criteria->compare('reg_stamp',$this->reg_stamp);
		$criteria->compare('login_stamp',$this->login_stamp);
		$criteria->compare('is_online',$this->is_online);
		$criteria->compare('securekey',$this->securekey,true);
		$criteria->compare('class_id',$this->class_id);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}
	
	public function saveUser( $user_info )
	{
		$this->attributes=$user_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
	
	public function setAsLogIn( )
	{
		//$this->
	}
	
	public static function registerUser( $country_id, $mobile )
	{
		$model = User::model()->find('mobile=?',array($mobile));
		
		$user_info['country_id'] = $country_id;
		$user_info['mobile'] = $mobile;
		$user_info['reg_stamp'] = time();
		$user_info['update_stamp'] = time();
		
		$user_info['vcode'] = Functions::generateVerifyCode();
		$user_info['password'] = Functions::generateHash('contact');
		
		if( $model != null )
		{
			$model->attributes = $user_info;
			
			if( !$model->save() )
				return null;			
		}
		else
		{
			$model = new User;
			$model->attributes = $user_info;
			if( !$model->save() )
				return null;
				
			Yii::app()->db->createCommand()->createTable( 'contact_' . $model->id, array(
					'id' => 'int(11) PRIMARY KEY NOT NULL',//'pk'
					'country_id'=>'int(11) NOT NULL',
					'mobile'=>'varchar(20) NOT NULL',
					'name'=>'varchar(50) NOT NULL default ""',
					'pname'=>'varchar(50) NOT NULL default ""',
					'email'=>'varchar(100) NOT NULL default ""',
					'homeaddr'=>'varchar(150) NOT NULL default ""',
					'housetel'=>'varchar(20) NOT NULL default ""',
					'birthday'=>'varchar(20) NOT NULL default ""',
					'class_id'=>'int default 0',
					'group_id'=>'int default 0',
				),
				'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci'
			);

			Yii::app()->db->createCommand()->createTable( 'group_' . $model->id, array(
					'id' => 'int(11) PRIMARY KEY NOT NULL',//'pk'
					'name'=>'varchar(50) NOT NULL',
				),
				'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci'
			);
		}
		
		return $model;
	}
}