<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $name
 * @property string|null $birthday
 * @property string|null $phone
 * @property string|null $email
 * @property string $createdate
 * @property string $updatedate
 *
 * @property PhotoEmployees[] $photoEmployees
 * @property Placement[] $placements
 */
class Employees extends \yii\db\ActiveRecord
{   
    public $imageFile;
    public $fileName;
    public $position_list;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['birthday', 'position_list'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 25],
            [['email'], 'email'],
            [
                ['image'], 'image',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 1024000,
                'tooBig' => 'Максимальный размер - 2 МБ'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО сотрудника',
            'birthday' => 'День рождения',
            'phone' => 'Номер телефона',
            'email' => 'Email',
            'createdate' => 'Createdate',
            'updatedate' => 'Updatedate',
            'image' => 'Фото сотрудника',
            'status' => 'Активность сотрудника',
            'positionName' => 'Последняя занимаемая должность',
        ];
    }

    /**
     * Gets query for [[Placements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlacements()
    {
        return $this->hasMany(Placement::className(), ['id_employee' => 'id']);
    }

    public function getDateEmployment()
    {
        if ($placements = $this->placements) {
            $date = implode(', ', ArrayHelper::map($placements, 'id', 'updatedate'));
            $date = strtotime($date);
            return date('d.m.Y', $date);
        } else {
            return '';
        }
    }

    public function getIdRefStatuses()
    {
        if ($placements = $this->placements) {
            $status = implode(', ', ArrayHelper::map($placements, 'id', 'id_refStatuses'));
            return $status;
        } else {
            return '';
        }
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasMany(Positions::className(), ['id' => 'id_position'])
            ->viaTable('placement', ['id_employee' => 'id']);
    }

    public function getPositionName()
    {
        if ($position = implode(', ', ArrayHelper::map($this->position, 'id', 'position')))
            return $position;
        return '';
    }

    /**
     * Gets query for [[RefStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefStatuses()
    {
        return $this->hasMany(RefStatuses::className(), ['id' => 'id_refStatuses'])
            ->viaTable('placement', ['id_employee' => 'id']);
    }

    public function getStatus()
    {
        if ($refStatuses = $this->refStatuses) {
            $status = implode(', ', ArrayHelper::map($refStatuses, 'id', 'status'));
            return $status;
        } else {
            return 'Не выбрана должность';
        }
    }

    public function behaviors()
    {
        return [
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'position',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function uploadImage(UploadedFile $image, $currentImage = null)
    {
        if (!is_null($currentImage))
            $this->deleteCurrentImage($currentImage);
        $this->imageFile = $image;
        if($this->validate())
            return $this->saveImage();
        return false;
    }

    private function getUploadPath()
    {
        return 'img/photoEmployees/';
    }

    /**
     * @return string
     */
    public function generateFileName(): string
    {
        $file = $this->id .date('YmdHis.'). $this->imageFile->extension;
        return $file;
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($currentImage && $this->fileExists($currentImage)) {
            unlink($currentImage);
        }
    }

    /**
     * @param $currentFile
     * @return bool
     */
    public function fileExists($currentFile): bool
    {
        $file = $currentFile ? $currentFile : null;
        return file_exists($file);
    }
    
    /**
     * @return string
     */
    public function saveImage(): string
    {
        $fileName = $this->getUploadPath() . $this->generateFilename();
        $this->imageFile->saveAs($fileName);
        return $fileName;
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }
    
    public function deleteImage()
    {
        $this->deleteCurrentImage($this->image);
    }

    public function dismiss()
    {
        foreach ($this->placements as $item) {
            $item->id_refStatuses = 2;
            $item->update();
        }
    }

    public function returnPost()
    {
        foreach ($this->placements as $item) {
            $item->id_refStatuses = 1;
            $item->update();
        }
    }

}
