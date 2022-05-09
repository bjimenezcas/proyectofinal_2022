<?php

namespace common\models\boda;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\components\general\MyHelper;
use common\models\boda\Invitaciones;

/**
 * InvitacionesSearch represents the model behind the search form about `common\models\boda\Invitaciones`.
 */
class InvitacionesSearch extends Invitaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'description', 'address', 'name', 'creation_date', 'observation'], 'safe'],
            [['confirmation', 'baby', 'order'], 'integer'],
        ];
    }
    public function attributes()
    {
        return array_merge(parent::attributes(), array_keys(get_object_vars($this)));
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function RelTable()
    {
        $Query = Invitaciones::find();
        return $Query;
    }
    //this need change for future,because there are errors
    public function view($id)
    {
        $query =  $this->relTable()->where(['id' => $id,]);
        return $query;
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
        $query = $this->RelTable();
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

        $Sort = ['id', 'confirmation', 'description', 'address', 'name', 'creation_date', 'baby', 'observation', 'order'];


        $dataProvider->setSort([
            //'defaultOrder' => ['order' => SORT_DESC],
            'attributes' => $Sort
        ]);

        // grid filtering conditions
        $Dates = [['' => 'creation_date'],];
        $query = (new MyHelper())->FilterDate($Dates, $query, $this);
        $query->andFilterWhere([
            'confirmation' => $this->confirmation,
            'baby' => $this->baby,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'observation', $this->observation]);

        return $dataProvider;
    }
}
