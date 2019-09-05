<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $photo_url
 * @property string $vendor_code
 * @property double $price
 * @property string $date_create
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['description', 'photo_url'], 'string'],
            [['price'], 'number'],
            [['date_create'], 'safe'],
            [['name', 'vendor_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'photo_url' => 'Photo Url',
            'vendor_code' => 'Vendor Code',
            'price' => 'Price',
            'date_create' => 'Date Create',
        ];
    }
}
