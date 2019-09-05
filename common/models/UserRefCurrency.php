<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_ref_currency".
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 *
 * @property Currency $currency
 * @property User $user
 */
class UserRefCurrency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_ref_currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'currency_id'], 'required'],
            [['user_id', 'currency_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'currency_id' => 'Currency ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param User $user
     * @return ActiveQuery
     */
    public static function byUserQuery(User $user): ActiveQuery
    {
        return self::find()->where(['user_id' => $user->id]);
    }

    /**
     * @param User $user
     * @param int $currencyId
     * @return UserRefCurrency|null
     */
    public static function findByUserAndCurrencyId(User $user, int $currencyId): ?self
    {
        return self::byUserQuery($user)->andWhere(['currency_id' => $currencyId])->one();
    }

    /**
     * @param User $user
     * @param Currency/int $currency
     * @return bool
     */
    public static function createRef(User $user, $currency): bool
    {
        $ref = new self();
        $ref->user_id = $user->id;
        $ref->currency_id = $currency instanceof Currency ? $currency->id : $currency;

        return $ref->save();
    }

    /**
     * @param float $productPrice
     * @return float|int
     */
    public function calculatePrice(float $productPrice)
    {
        return round($productPrice / $this->currency->value, 2);
    }
}
