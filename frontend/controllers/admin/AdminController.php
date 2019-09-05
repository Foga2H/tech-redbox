<?php

namespace frontend\controllers\admin;

use common\models\User;
use frontend\components\admin\AccessRule;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AdminController
 * @package frontend\controllers\admin
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }
}