<?php

/**
 * This is the model class for table "classification".
 *
 * The followings are the available columns in table 'classification':
 * @property string $id
 * @property string $name
 */
class Classification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Classification the static model class
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
		return 'classification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			'criteria'=>$criteria,
		));
	}
	
	public function findByName( $name )
	{
		$country = $this->find("name='" . $name . "'");
		
		return $country;
	}
	
	public function addClassification( $class_info )
	{
		$find_class = $this->findByName( $class_info['name'] );
		if( $find_class !== null )
			return "Classification name " . $class_info['name'] . " is already in use.";

		$this->attributes=$class_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
	
	public function saveClassification( $class_info )
	{
		if( $class_info['name'] !== $this->name )
		{
			$find_class = $this->findByName( $class_info['name'] );
		
			if( $find_class !== null && $find_class->id !== $this->id )
				return "Classification name " . $class_info['name'] . " is already in use.";
		}

		$this->attributes=$class_info;
		if( !$this->save() )
			return 'Unknown Error';

		return 'SUCCESS';
	}
}