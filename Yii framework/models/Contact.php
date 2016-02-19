<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property string $id
 * @property string $mobile
 * @property string $country_id
 * @property string $name
 * @property string $pname
 * @property string $email
 * @property string $homeaddr
 * @property string $housetel
 * @property integer $birthday
 * @property integer $class_id
 * @property string $group_id
 */
 
$_current_user_id = 0;

class Contact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	 
	public static function newModel($userid )
	{
		global $_current_user_id;
	
		$_current_user_id = $userid;

		return new Contact();
	}
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	 
	public static function modelById($userid, $className=__CLASS__)
	{
		global $_current_user_id;
	
		$_current_user_id = $userid;
	
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		global $_current_user_id;
	
		return 'contact_' . $_current_user_id;
		//return 'contact_7';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, mobile, country_id', 'required'),
			array('class_id', 'numerical', 'integerOnly'=>true),
			array('name, pname', 'length', 'max'=>50),
			array('mobile, housetel', 'length', 'max'=>20),
			array('birthday', 'length', 'max'=>30),
			array('country_id, group_id', 'length', 'max'=>11),
			array('email', 'length', 'max'=>100),
			array('homeaddr', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pid, id, mobile, country_id, name, pname, email, homeaddr, housetel, birthday, class_id, group_id', 'safe', 'on'=>'search'),
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
			//'user'=>array(self::HAS_MANY, 'user', '', 'on'=>'user.mobile=t.mobile'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'user'=>array(self::BELONGS_TO, 'User', '', 'foreignKey' => array('mobile'=>'mobile')),
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
			'email' => 'Email',
			'homeaddr' => 'Home Address',
			'housetel' => 'House Tel',
			'birthday' => 'Birthday',
			'class_id' => 'Classification',
			'group_id' => 'Group',
			'country.name' => 'Country',
			'group.name' => 'Group',
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
		
		$criteria->with = array( 'user', 'country', 'group');//, 'classification' );

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.mobile',$this->mobile,true);

		$criteria->compare('t.country_id',$this->country_id);
		$criteria->compare('user.name',$this->name,true);
		$criteria->compare('t.pname',$this->pname,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.homeaddr',$this->homeaddr,true);
		$criteria->compare('t.housetel',$this->housetel,true);
		$criteria->compare('t.birthday',$this->birthday);
		$criteria->compare('t.class_id',$this->class_id);
		$criteria->compare('t.group_id',$this->group_id);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'user.name'=>array(
	                	//'asc'=>'user.name',
						'asc'=>'user.name is null, user.name ASC',
                		'desc'=>'user.name DESC',
						//'desc'=>'user.name is not null, user.name DESC',
            		),
					'country.name'=>array(
	                	'asc'=>'country.name',
                		'desc'=>'country.name DESC',
            		),
					'group.name'=>array(
						'asc'=>'group.name is null, group.name ASC',
                		'desc'=>'group.name DESC',
            		),
					'user.reg_stamp'=>array(
						'asc'=>'user.reg_stamp is null, user.reg_stamp ASC',
                		'desc'=>'user.reg_stamp DESC',
            		),
					'user.status'=>array(
						'asc'=>'user.status is null, user.status ASC',
                		'desc'=>'user.status DESC',
            		),
					'user.email'=>array(
						'asc'=>'user.email is null, user.email ASC',
                		'desc'=>'user.email DESC',
            		),
            		'*',
        		),
    		),
		));
	}
}