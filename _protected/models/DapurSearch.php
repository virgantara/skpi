<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dapur;

/**
 * DapurSearch represents the model behind the search form of `app\models\Dapur`.
 */
class DapurSearch extends Dapur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kapasitas'], 'integer'],
            [['nama','kampus'], 'safe'],
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
        $query = Dapur::find();

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
            'kapasitas' => $this->kapasitas,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);

        if(Yii::$app->user->identity->access_role == 'operatorCabang')
        {
            $query->andWhere(['kampus'=>Yii::$app->user->identity->kampus]);    
        }
                


        return $dataProvider;
    }
}
