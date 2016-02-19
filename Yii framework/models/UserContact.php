<?php

/**
 * This is the model class for table "user_contact".
 *
 * The followings are the available columns in table 'user_contact':
 * @property string $id
 * @property string $user_id
 * @property string $contact_id
 * @property string $pname
 */
class UserContact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserContact the static model class
	 */
	public static $_user_id;

	public static function model($userid, $className=__CLASS__)
	{
		$_user_id = $user_id;
	
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact' . $_user_id;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, contact_id', 'required'),
			array('user_id, contact_id', 'length', 'max'=>20),
			array('pname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, contact_id, pname', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'contact_id' => 'Contact',
			'pname' => 'Pname',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('pname',$this->pname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getConatactIDList($id)
	{
		$contactList = $this->findAll("user_id='" . $id . "'");
	}
}