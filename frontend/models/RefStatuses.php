<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "refStatuses".
 *
 * @property int $id
 * @property string $status
 * @property string $createdate
 * @property string $updatedate
 *
 * @property Placement[] $placements
 */
class RefStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refStatuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['createdate', 'updatedate'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'createdate' => 'Createdate',
            'updatedate' => 'Updatedate',
        ];
    }

    /**
     * Gets query for [[Placements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlacements()
    {
        return $this->hasMany(Placement::className(), ['id_refStatuses' => 'id']);
    }
}
