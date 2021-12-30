<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "placement".
 *
 * @property int $id
 * @property int $id_position
 * @property int $id_employee
 * @property int $status
 * @property string $createdate
 * @property string $updatedate
 *
 * @property Employees $employee
 * @property Positions $position
 */
class Placement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'placement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_position', 'id_employee'], 'required'],
            [['id_position', 'id_refStatuses'], 'integer'],
            [['createdate', 'updatedate', 'name'], 'safe'],
            [['id_position'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['id_position' => 'id']],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_refStatuses'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatuses::className(), 'targetAttribute' => ['id_refStatuses' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_position' => 'Id Position',
            'id_employee' => 'Id Employee',
            'id_refStatuses' => 'id_refStatuses',
            'createdate' => 'Createdate',
            'updatedate' => 'Updatedate',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['id' => 'id_employee']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Positions::className(), ['id' => 'id_position']);
    }

    /**
     * Gets query for [[RefStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefStatuses()
    {
        return $this->hasOne(RefStatuses::className(), ['id' => 'id_position']);
    }
}
