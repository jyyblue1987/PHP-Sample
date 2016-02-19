<?php

/**
 * This is the model class for table "call_history".
 *
 * The followings are the available columns in table 'call_history':
 * @property string $id
 * @property string $from_mobile
 * @property string $to_mobile
 * @property string $starttime
 * @property string $endtime
 */
class CallHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallHistory the static model class
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
		return 'call_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_mobile, to_mobile, starttime, endtime', 'required'),
			array('from_mobile, to_mobile', 'length', 'max'=>20),
			array('starttime, endtime', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_mobile, to_mobile, starttime, endtime', 'safe', 'on'=>'search'),
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
			'caller'=>array(self::BELONGS_TO, 'User', '', 'foreignKey' => array('from_mobile'=>'mobile')),
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
			'starttime' => 'Start Time',
			'endtime' => 'End Time',
			'caller.name' => 'From User',
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
		
		$criteria->with = array( 'caller', 'receiver' );//, 'classification' );

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from_mobile',$this->from_mobile,true);
		$criteria->compare('to_mobile',$this->to_mobile,true);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('endtime',$this->endtime,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'caller.name'=>array(
						'asc'=>'caller.name is null, caller.name ASC',
                		'desc'=>'caller.name DESC',
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