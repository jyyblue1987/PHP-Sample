<?php

/**
 * This is the model class for table "report".
 *
 * The followings are the available columns in table 'report':
 * @property string $id
 * @property string $user_id
 * @property string $content
 * @property integer $timestamp
 */
class Push extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Report the static model class
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
		return 'push';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message, status', 'required'),
			array('reg_stamp', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, msg_id, message, category_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message' => 'Broadcast Message',
			'reg_stamp' => 'Last Modified',
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

		$criteria->compare('message',$this->message,true);
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'*',
        		),
				'defaultOrder'=> array(
					'reg_stamp'=>CSort::SORT_DESC,
				),
    		),
		));
	}
	
	public function searchByMessage($message)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array( 'push' );

		$criteria->compare('t.message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(					
            		'*',
        		),
    		),
		));
	}
	
	public function addPush( $push )
	{
		$push['reg_stamp'] = time();
		$this->attributes=$push;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
}