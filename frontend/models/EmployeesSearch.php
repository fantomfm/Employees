<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form of `frontend\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    // public $positionName;
    // public $dateEmployment;
    // public $status;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'birthday', 'phone', 'email', 'createdate', 'updatedate', 'dateEmployment', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Employees::find();
        $query->joinWith(['position']);
        $query->joinWith(['refStatuses']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $dataProvider->sort->attributes['positionName'] = [
            'asc' => [Positions::tableName().'.position' => SORT_ASC],
            'desc' => [Positions::tableName().'.position' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['dateEmployment'] = [
            'asc' => [Placement::tableName().'.updatedate' => SORT_ASC],
            'desc' => [Placement::tableName().'.updatedate' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['status'] = [
            'asc' => [RefStatuses::tableName().'.status' => SORT_ASC],
            'desc' => [RefStatuses::tableName().'.status' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'createdate' => $this->createdate,
            'updatedate' => $this->updatedate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
