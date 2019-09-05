<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class AdminController
 * @package console\controllers
 */
class AdminController extends Controller
{
    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function actionCreate(
        string $username,
        string $email,
        string $password
    ): void {
        /** @var User $model */
        $model = new User();
        $model->setAttributes([
            'username' => $username,
            'email' => $email,
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN
        ]);
        $model->generateAuthKey();
        $model->setPassword($password);

        if ($model->save()) {
            $this->stdout('Success' . PHP_EOL, Console::FG_GREEN);
            $this->echoUserInfo($model);
        } else {
            foreach ($model->getFirstErrors() as $error) {
                $this->stderr($error . PHP_EOL);
            }
        }
    }

    /**
     * @param User $user
     */
    private function echoUserInfo(User $user): void
    {
        $this->stdout('Username: ' . $user->username . PHP_EOL);
        $this->stdout('Email: ' . $user->email . PHP_EOL);
        $this->stdout('Role: ' . $user->role . PHP_EOL);
    }
}