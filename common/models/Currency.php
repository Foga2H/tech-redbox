<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $cbr_id
 * @property string $name
 * @property string $char_code
 * @property double $value
 * @property string $date_create
 * @property string $date_update
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cbr_id', 'value'], 'required'],
            [['value'], 'number'],
            [['date_create', 'date_update'], 'safe'],
            [['cbr_id', 'name', 'char_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cbr_id' => 'Cbr ID',
            'name' => 'Name',
            'char_code' => 'Char Code',
            'value' => 'Value',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @param string $id
     * @return Currency|null
     */
    public static function byCbrId(string $id): ?self
    {
        return self::findOne(['cbr_id' => $id]);
    }
}
