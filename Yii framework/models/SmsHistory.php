<?php

/**
 * This is the model class for table "sms_history".
 *
 * The followings are the available columns in table 'sms_history':
 * @property string $id
 * @property string $from_mobile
 * @property string $to_mobile
 * @property string $content
 * @property string $sendtime
 * @property string $receivetime
 */
class SmsHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SmsHistory the static model class
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
		return 'sms_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_mobile, to_mobile, content, sendtime, receivetime', 'required'),
			array('from_mobile, to_mobile', 'length', 'max'=>20),
			array('sendtime, receivetime', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_mobile, to_mobile, content, sendtime, receivetime', 'safe', 'on'=>'search'),
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
			'sender'=>array(self::BELONGS_TO, 'User', '', 'foreignKey' => array('from_mobile'=>'mobile')),
			'receiver'=>array(self::BELONGS_TO, 'User', '', 'foreignKey' => array('to_mobile'=>'mobile')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_mobile' => 'From',
			'to_mobile' => 'To',
			'content' => 'Content',
			'sendtime' => 'Send Time',
			'receivetime' => 'Receive Time',
			'sender.name' => 'From User',
			'receiver.name' => 'To User',
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
		
		$criteria->with = array( 'sender', 'receiver' );

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from_mobile',$this->from_mobile,true);
		$criteria->compare('to_mobile',$this->to_mobile,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sendtime',$this->sendtime,true);
		$criteria->compare('receivetime',$this->receivetime,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'sender.name'=>array(
						'asc'=>'sender.name is null, sender.name ASC',
                		'desc'=>'sender.name DESC',
            		),
					'receiver.name'=>array(
						'asc'=>'receiver.name is null, receiver.name ASC',
                		'desc'=>'receiver.name DESC',
            		),
            		'*',
        		),
    		),
		));
	}
}