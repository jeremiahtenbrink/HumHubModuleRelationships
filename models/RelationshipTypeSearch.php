<?php

namespace humhub\modules\relationships\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\relationships\models\RelationshipType;

/**
 * @author CO_Nerd
 * RelationshipTypeSearch represents the model behind the search form of `humhub\modules\relationships\models\RelationshipType`.
 */
class RelationshipTypeSearch extends RelationshipType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'relationship_category'], 'integer'],
            [['type'], 'safe'],
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
        $query = RelationshipType::find();

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
            'relationship_category' => $this->relationship_category,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
