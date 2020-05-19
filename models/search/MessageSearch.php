<?php

namespace rabint\pm\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rabint\pm\models\Message;

/**
 * MessageSearch represents the model behind the search form about `\rabint\pm\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'receiver_id', 'created_at', 'updated_at', 'read'], 'integer'],
            [['subject', 'message'], 'safe'],
        ];
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
     * @param boolean $returnActiveQuery
     *
     * @return ActiveDataProvider OR ActiveQuery
     */
    public function search($params,$returnActiveQuery = FALSE)
    {
        $query = Message::find()->alias('message');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'user_id' => $this->user_id,
            'receiver_id' => $this->receiver_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'read' => $this->read,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message]);

        if ($returnActiveQuery) {
            return $query;
        }
        return $dataProvider;
    }
}
