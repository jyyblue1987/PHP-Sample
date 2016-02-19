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
class Report extends CActiveRecord
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
		return 'report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, content', 'required'),
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, content, timestamp', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'content' => 'Content',
			'timestamp' => 'Time',
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

		$criteria->with = array( 'user' );

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.user_id',$this->user_id,true);
		$criteria->compare('t.content',$this->content,true);
		$criteria->compare('t.timestamp',$this->timestamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'user.name'=>array(
						'asc'=>'user.name is null, user.name ASC',
                		'desc'=>'user.name DESC',
						//'desc'=>'user.name is not null, user.name DESC',
            		),
					'user.mobile'=>array(
	                	'asc'=>'user.mobile',
                		'desc'=>'user.mobile DESC',
            		),
            		'*',
        		),
    		),
		));
	}
	
	public function searchByUser($user_name, $user_mobile)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array( 'user' );

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.content',$this->content,true);
		$criteria->compare('t.timestamp',$this->timestamp);
		
		$criteria->compare('user.name', $user_name, true);
		$criteria->compare('user.mobile',$user_mobile, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
					'user.name'=>array(
						'asc'=>'user.name is null, user.name ASC',
                		'desc'=>'user.name DESC',
						//'desc'=>'user.name is not null, user.name DESC',
            		),
					'user.mobile'=>array(
	                	'asc'=>'user.mobile',
                		'desc'=>'user.mobile DESC',
            		),
            		'*',
        		),
    		),
		));
	}
}