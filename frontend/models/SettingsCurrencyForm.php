<?php

namespace frontend\models;

use common\models\Currency;
use common\models\User;
use common\models\UserRefCurrency;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class SettingsCurrencyForm
 * @package frontend\models
 */
class SettingsCurrencyForm extends Model
{
    /**
     * @var array
     */
    public $currencyList;

    /**
     * @var array
     */
    public $selectCurrencyList;

    /**
     * @var
     */
    public $selectedCurrencyList;

    /**
     * @var User
     */
    private $_user;

    /**
     * SettingsCurrencyForm constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->selectCurrencyList = $this->getCurrencyList();
        $this->selectedCurrencyList = $this->getSelectedCurrencyList();

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['currencyList', 'safe']
        ];
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }

    /**
     * @param array $properties
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function updateCurrencies(array $properties): bool
    {
        if (is_string($properties['currencyList'])) {
            return $this->_cleanCurrencies();
        }

        return $this->_updateCurrencies($properties['currencyList']);
    }

    /**
     * @return array
     */
    private function getCurrencyList(): array
    {
        $currencyList = [];
        $currencies = Currency::find()->all();

        foreach ($currencies as $currency) {
            $currencyList[$currency->id] = $currency->name;
        }

        return $currencyList;
    }

    /**
     * @return array
     */
    private function getSelectedCurrencyList(): array
    {
        $currencyList = [];
        $currencies = UserRefCurrency::byUserQuery($this->getUser())->all();

        foreach ($currencies as $currency) {
            $currencyList[] = $currency->currency_id;
        }

        return $currencyList;
    }

    /**
     * @return bool
     */
    private function _cleanCurrencies(): bool
    {
        if (!$user = $this->getUser()) {
            return false;
        }

        return UserRefCurrency::deleteAll(['user_id' => $user->id]);
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function _updateCurrencies(array $data): bool
    {
        if (count($data) === 0) {
            return false;
        }

        if (!$user = $this->getUser()) {
            return false;
        }

        foreach ($data as $currencyId) {
            if (!$ref = UserRefCurrency::findByUserAndCurrencyId($user, $currencyId)) {
                UserRefCurrency::createRef($user, $currencyId);
            }
        }

        foreach (UserRefCurrency::byUserQuery($user)->all() as $currency) {
            if (ArrayHelper::isIn($currency->currency_id, $data) === false) {
                $currency->delete();
            }
        }

        return true;
    }
}