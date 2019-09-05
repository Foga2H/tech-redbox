<?php

/* @var $model SettingsForm */
/* @var $user User */
/* @var $currencyModel SettingsCurrencyForm */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use common\models\User;
use frontend\models\SettingsCurrencyForm;
use frontend\models\SettingsForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

$user = $model->getUser();

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Profile</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'settings-form']); ?>

                    <?= $form->field($user, 'username')->textInput() ?>

                    <?= $form->field($user, 'email')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success', 'name' => 'settings-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Password</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'settings-password-form']); ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'settings-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Currencies</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'settings-currency-form']); ?>

                    <?= $form->field($currencyModel, 'currencyList')->widget(\kartik\select2\Select2::classname(), [
                        'data' => $currencyModel->selectCurrencyList,
                        'options' => [
                            'placeholder' => 'Select a currencies ...',
                            'multiple' => true,
                            'value' => $currencyModel->selectedCurrencyList
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success', 'name' => 'settings-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>