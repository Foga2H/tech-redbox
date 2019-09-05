<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Class SettingsForm
 * @package frontend\models
 */
class SettingsForm extends Model
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeatPassword;

    /**
     * @var User
     */
    private $_user;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'email'], 'required', 'on' => ['updateSettings']],
            [['password', 'repeatPassword'], 'required', 'on' => ['updatePassword']],
            [['email'], 'email', 'on' => ['updateSettings']],
            [['repeatPassword'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords should match.', 'on' => ['updatePassword']],
            [['password', 'repeatPassword'], 'safe', 'on' => ['updatePassword']]
        ];
    }

    /**
     * @param array $properties
     * @return bool
     */
    public function updateProfile(array $properties): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($this->validate() && $user->load($properties, '')) {
            return $this->_update($user);
        }

        return false;
    }

    /**
     * @param array $properties
     * @return bool
     */
    public function updatePassword(array $properties): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($this->validate() && $user->load($properties, '')) {
            return $this->_updatePassword($user, $this->password);
        }

        return false;
    }

    /**
     * @param User $model
     * @return bool
     */
    private function _update(User $model): bool
    {
        return $model->save();
    }

    /**
     * @param User $model
     * @param string $password
     * @return bool
     */
    private function _updatePassword(User $model, string $password): bool
    {
        $model->setPassword($password);

        return $model->save();
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
}