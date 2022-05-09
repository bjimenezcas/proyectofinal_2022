<?php

namespace common\models\boda;

use Yii;

/**
 * This is the model class for table "invitaciones".
 *
 * @property string $id
 * @property integer $confirmation
 * @property string $description
 * @property string $address
 * @property string $name
 * @property string $creation_date
 * @property integer $baby
 * @property string $observation
 * @property integer $order
 */
class Invitaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $invitados;
    static public function find()
    {
        return parent::find()->from('invitaciones  ');
    }
    public static function tableName()
    {
        return 'invitaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['confirmation', 'baby', 'order'], 'integer'],
            [['creation_date','invitados'], 'safe'],
            [['id', 'name'], 'string', 'max' => 100],
            [['description', 'observation'], 'string', 'max' => 5000],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'confirmation' => Yii::t('app', 'Confirmacion'),
            'description' => Yii::t('app', 'Descripcion(nuestro)'),
            'address' => Yii::t('app', 'Dirección'),
            'name' => Yii::t('app', 'Nombre'),
            'creation_date' => Yii::t('app', 'Fecha de creación'),
            'baby' => Yii::t('app', 'Bebes'),
            'observation' => Yii::t('app', 'Observaciones'),
            'order' => Yii::t('app', 'Orden'),
        ];
    }
}
