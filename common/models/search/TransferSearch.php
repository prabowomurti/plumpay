<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transfer;

/**
 * TransferSearch represents the model behind the search form about `common\models\Transfer`.
 */
class TransferSearch extends Transfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_id', 'destination_id'], 'integer'],
            [['status', 'source.username', 'destination.username', 'message', 'description', 'amount'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['source.username', 'destination.username']);
    }

    /**
     * @inheritdoc
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
        $query = Transfer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->joinWith(['RELATION NAME' => function ($query) {$query->from(['ALIAS' => 'RELATION TABLE NAME']);}]);
        $query->joinWith(['source' => function ($query) {$query->from(['source' => 'user']);}]);

        $query->joinWith(['destination' => function ($query) {$query->from(['destination' => 'user']);}]);

        $query->andFilterWhere(['like', 'source.username', $this->getAttribute('source.username')]);
        $query->andFilterWhere(['like', 'destination.username', $this->getAttribute('destination.username')]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterCompare('amount', $this->amount);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'description', $this->description]);

        $user_id = Yii::$app->user->id;
        $query->andWhere(['or', 'source_id=' . $user_id, 'destination_id=' . $user_id]);

        $dataProvider->sort->attributes['source.username'] = [
            'asc' => ['source.username' => SORT_ASC],
            'desc' => ['source.username' => SORT_DESC],
            ];

        $dataProvider->sort->attributes['destination.username'] = [
            'asc' => ['destination.username' => SORT_ASC],
            'desc' => ['destination.username' => SORT_DESC],
            ];

        return $dataProvider;
    }
}