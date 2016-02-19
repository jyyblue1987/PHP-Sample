<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $department
 * @property string $jobtitle
 * @property string $address
 * @property string $telephone
 * @property string $fax
 * @property string $notes
 * @property string $email
 * @property string $website
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name', 'required'),
			array('user_id, telephone', 'length', 'max'=>20),
			array('name, department, jobtitle', 'length', 'max'=>100),
			array('address', 'length', 'max'=>250),
			array('fax', 'length', 'max'=>50),
			array('notes, email, website', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, department, jobtitle, address, telephone, fax, notes, email, website', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'department' => 'Department',
			'jobtitle' => 'Jobtitle',
			'address' => 'Address',
			'telephone' => 'Telephone',
			'fax' => 'Fax',
			'notes' => 'Notes',
			'email' => 'Email',
			'website' => 'Website',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('jobtitle',$this->jobtitle,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('website',$this->website,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}