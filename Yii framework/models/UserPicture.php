<?php

/**
 * This is the model class for table "user_picture".
 *
 * The followings are the available columns in table 'user_picture':
 * @property string $id
 * @property string $user_id
 * @property string $img_path
 * @property integer $reg_stamp
 */
class UserPicture extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPicture the static model class
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
		return 'user_picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, img_path, reg_stamp', 'required'),
			array('reg_stamp', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('img_path', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, img_path, reg_stamp', 'safe', 'on'=>'search'),
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
			'img_path' => 'Img Path',
			'reg_stamp' => 'Reg Stamp',
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
		$criteria->compare('img_path',$this->img_path,true);
		$criteria->compare('reg_stamp',$this->reg_stamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}