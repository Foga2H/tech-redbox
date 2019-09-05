<?php

namespace frontend\components\admin;

use common\models\User;

/**
 * Class AccessRule
 */
class AccessRule extends \yii\filters\AccessRule
{
    /**
     * @param \yii\web\User $user
     * @return bool
     */
    protected function matchRole($user): bool
    {
        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === User::ROLE_USER) {
                if (!$user->getIsGuest()) {
                    return true;
                }
            } elseif (!$user->getIsGuest() && $role === $user->identity->role) {
                return true;
            }
        }

        return false;
    }
}