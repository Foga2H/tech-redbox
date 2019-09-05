<?php

namespace frontend\controllers;

use frontend\models\SettingsCurrencyForm;
use frontend\models\SettingsForm;
use yii\web\Controller;
use Yii;

/**
 * Class ProfileController
 * @package frontend\controllers
 */
class ProfileController extends Controller
{
    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionSettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SettingsForm();
        $currencyModel = new SettingsCurrencyForm();

        if (Yii::$app->request->post('User')) {
            $model->setScenario('updateSettings');

            if ($model->load(Yii::$app->request->post(), 'User') && $model->updateProfile(Yii::$app->request->post('User'))) {
                Yii::$app->session->setFlash('success', 'Your profile was successfully updated.');
            }
        }

        if (Yii::$app->request->post('SettingsForm')) {
            $model->setScenario('updatePassword');

            if ($model->load(Yii::$app->request->post(), 'SettingsForm') && $model->updatePassword(Yii::$app->request->post('SettingsForm'))) {
                Yii::$app->session->setFlash('success', 'Your password was successfully updated.');
            }
        }

        if (Yii::$app->request->post('SettingsCurrencyForm') && $currencyModel->updateCurrencies(Yii::$app->request->post('SettingsCurrencyForm'))) {
            Yii::$app->session->setFlash('success', 'Your currencies was successfully updated.');

            $currencyModel = new SettingsCurrencyForm();
        }

        return $this->render('settings', [
            'model' => $model,
            'currencyModel' => $currencyModel
        ]);
    }
}