<?php

namespace common\models\boda;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\components\general\MyHelper;
use common\models\boda\Invitados;

/**
 * InvitadosSearch represents the model behind the search form about `common\models\boda\Invitados`.
 */
class InvitadosSearch extends Invitados
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'surname', 'confirmation', 'fish_or_meat', 'description', 'type_menu', 'id_invitacion','gender','table','finish'], 'safe'],
            [['order', 'bus', 'allergens'], 'integer'],
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
        $Query = Invitados::find();
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

        $Sort = ['id', 'name', 'surname', 'confirmation', 'fish_or_meat', 'description', 'order', 'bus', 'allergens', 'type_menu', 'id_invitacion','gender','table','finish'];


        $dataProvider->setSort([
            //'defaultOrder' => ['order' => SORT_DESC],
            'attributes' => $Sort
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'order' => $this->order,
            'bus' => $this->bus,
            'allergens' => $this->allergens,
            'gender' => $this->gender,
            'table' => $this->table,
            'finish' => $this->finish,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'confirmation', $this->confirmation])
            ->andFilterWhere(['like', 'fish_or_meat', $this->fish_or_meat])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'type_menu', $this->type_menu])
            ->andFilterWhere(['like', 'id_invitacion', $this->id_invitacion]);

        return $dataProvider;
    }
}
