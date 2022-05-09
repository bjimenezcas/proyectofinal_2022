<?php

namespace common\models\boda;

use Yii;

/**
 * This is the model class for table "invitados".
 *
 * @property string $id
 * @property string $name
 * @property string $surname
 * @property integer $confirmation
 * @property string $fish_or_meat
 * @property string $description
 * @property integer $order
 * @property integer $bus
 * @property integer $allergens
 * @property string $type_menu
 * @property string $id_invitacion
 */
class Invitados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    static public function find()
    {
        return parent::find()->from('invitados  ');
    }
    public static function tableName()
    {
        return 'invitados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['order', 'bus', 'allergens', 'confirmation','finish'], 'integer'],
            [['id', 'name', 'surname', 'description', 'type_menu', 'id_invitacion', 'gender','table'], 'string', 'max' => 100],
            [['fish_or_meat'], 'string', 'max' => 45],
        ];
    }
    public static function SaveInvitados($model)
    {
        $Invitados = $model->invitados;
        if ($Invitados) {
            foreach ($Invitados as $Invitado) {
                $UpdateInvitado = Invitados::findOne($Invitado);
                $UpdateInvitado->id_invitacion = $model->id;
                if ($UpdateInvitado->validate()) {
                    $UpdateInvitado->save();
                } else {
                    Yii::error("Error model ->" . json_encode($UpdateInvitado->getErrors()));
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nombre'),
            'surname' => Yii::t('app', 'Apellidos'),
            'confirmation' => Yii::t('app', 'Confirmacion'),
            'fish_or_meat' => Yii::t('app', 'Carne o pescado'),
            'description' => Yii::t('app', 'Descripcion(visible solo backend)'),
            'order' => Yii::t('app', 'Orden'),
            'bus' => Yii::t('app', 'Bus'),
            'allergens' => Yii::t('app', 'Alergenos'),
            'type_menu' => Yii::t('app', 'Tipo de menu'),
            'id_invitacion' => Yii::t('app', 'Invitacion'),
            'table' => Yii::t('app', 'Mesa'),
            'finish' => Yii::t('app', 'Finalizado'),
        ];
    }
}
