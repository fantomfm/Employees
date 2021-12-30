<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property int $id
 * @property string $position
 * @property string $createdate
 * @property string $updatedate
 *
 * @property Placement[] $placements
 */
class Positions extends \yii\db\ActiveRecord
{
    public $countPositions;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position'], 'required'],
            [['createdate', 'updatedate'], 'safe'],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Должность',
            'createdate' => 'Createdate',
            'updatedate' => 'Updatedate',
            'start' => 'Начало диапазона',
            'end' => 'Конец диапазона',
        ];
    }

    /**
     * Gets query for [[Placements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlacements()
    {
        return $this->hasMany(Placement::className(), ['id_position' => 'id'])->where(['id_refStatuses' => 1]);
    }
}
