<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Remark;

/**
 * RemarkSearch represents the model behind the search form of `frontend\models\Remark`.
 */
class RemarkSearch extends Remark
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'folder_id', 'cid'], 'integer'],
            [['project_id', 'remark_type', 'remark_date', 'text'], 'safe'],
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
        $query = Remark::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'folder_id' => $this->folder_id,
            'remark_date' => $this->remark_date,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'project_id', $this->project_id])
            ->andFilterWhere(['like', 'remark_type', $this->remark_type])
            ->andFilterWhere(['like', 'text', $this->text]);
        return $dataProvider;
    }
}
