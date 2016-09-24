<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer as CustomerModel;

/**
 * Customer represents the model behind the search form about `common\models\Customer`.
 */
class Customer extends CustomerModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'exhibition_id', 'sex', 'company_type_id', 'country', 'province', 'city', 'district', 'from', 'status'], 'integer'],
            [['name', 'mobile', 'email', 'company_name', 'position', 'department', 'phone', 'fax', 'url', 'remark', 'address', 'created_at', 'updated_at', 'rejected_reason'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CustomerModel::find();

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
            'type' => $this->type,
            'exhibition_id' => $this->exhibition_id,
            'sex' => $this->sex,
            'company_type_id' => $this->company_type_id,
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'district' => $this->district,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'from' => $this->from,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'rejected_reason', $this->rejected_reason]);

        return $dataProvider;
    }
}
