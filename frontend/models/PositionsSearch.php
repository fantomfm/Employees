<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use frontend\models\Positions;

/**
 * PositionsSearch represents the model behind the search form of `frontend\models\Positions`.
 */
class PositionsSearch extends Positions
{
    public $start;
    public $end;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'countPositions'], 'safe'],
            [['start', 'end'], 'date', 'format'=>'yyyy-mm-dd']
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
        $query = Positions::find()->alias('po')
            ->select(['po.*', 'COUNT(pl.id) AS countPositions'])
            ->joinWith('placements pl')
            ->groupBy('po.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'createdate' => $this->createdate,
            'updatedate' => $this->updatedate,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['>=', 'pl.updatedate', $this->start])
            ->andFilterWhere(['<=', 'pl.updatedate', $this->end]);

        return new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => [
                    'position',
                    'countPositions',
                    'updatedate',
                ],
            ],
        ]);

    }
}
