<?php

/* @var $model ProductForm */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use common\models\User;
use frontend\models\admin\ProductForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Product: ' . $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if($model->photo_url): ?>
                        <div class="thumbnail">
                            <img src="<?=$model->photo_url?>" alt="">
                        </div>

                        <?php $form = ActiveForm::begin(['id' => 'product-delete-photo-form']); ?>
                            <?= $form->field($model, 'photo_url')->hiddenInput()->label(false) ?>
                            <?= Html::submitButton('Удалить фото', ['class' => 'btn btn-danger', 'name' => 'type', 'value' => 'delete-photo']) ?>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin([
                        'id' => 'product-edit-form',
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'description')->textarea() ?>

                    <?= $form->field($model, 'photo')->fileInput(['accept' => 'image/*']) ?>

                    <?= $form->field($model, 'vendor_code')->textInput() ?>

                    <?= $form->field($model, 'price')->input('number') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Update Product', ['class' => 'btn btn-success', 'name' => 'product-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>