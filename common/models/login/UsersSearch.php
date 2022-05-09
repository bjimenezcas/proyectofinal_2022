<?php

namespace common\models\login;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UsersSearch extends Users
{


    public function rules()
    {
        return [
            [[ 'enabled', 'status'], 'integer'],
            [['id','username', 'email', 'auth_key', 'password', 'confirmation_token',
                'first_name', 'last_name', 'access_token', 'mobile',
                'verification_code', 'description', 'created_at', 'updated_at',], 'safe'],
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

    public function view($id)
    {
        $query = $this->relTable()->where(['id' => $id]);
        return $query;
    }

    public function relTable()
    {
        $Result = Users::find();
        return $Result;
    }

    public function search($params)
    {
        $query = $this->relTable();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $Sort = [
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
            ], 'username', 'email', 'auth_key', 'password', 'confirmation_token',
            'first_name', 'last_name',
            'verification_code',
             'enabled', 'mobile', 'status', 'description', 'created_at', 'updated_at'
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => $Sort
        ]);


        $Dates = [['' => 'created_at', '' => 'updated_at']];

        $query->andFilterWhere([
            'id' => $this->id,
            'enabled' => $this->enabled,
            'status' => $this->status,
            'mobile' => $this->mobile,
            'a.id' => $this->app,
            'dni' => $this->dni,
        ]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'confirmation_token', $this->confirmation_token])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'verification_code', $this->verification_code]);

        return $dataProvider;
    }

}
