<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\User;
use common\models\UserRefCurrency;
use yii\web\Controller;
use Yii;

/**
 * Class ProductController
 * @package frontend\controllers
 */
class ProductController extends Controller
{
    /**
     * @return string
     */
    public function actionList(): string
    {
        $products = Product::find()->all();
        $currencyList = [];
        $user = null;

        if (Yii::$app->user->isGuest === false) {
            /** @var User $user */
            $user = Yii::$app->user->identity;

            $currencyList = UserRefCurrency::byUserQuery($user)
                ->with('currency')
                ->all();
        }

        return $this->render('list', [
            'products' => $products,
            'currencyList' => $currencyList,
            'user' => $user
        ]);
    }
}