<?php

use common\models\Product;
use common\models\UserRefCurrency;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Product[] $products */
/** @var UserRefCurrency[] $currencyList */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-product">
    <h1><?= Html::encode($this->title) ?>

    <?php if (!Yii::$app->user->isGuest && $user->isAdmin()): ?>
        <?= Html::a('Create Product', Url::toRoute('admin/product/create'),  ['class' => 'btn btn-success pull-right'])?>
    <?php endif; ?>

    </h1>

    <div class="row">
        <?php if (count($products) === 0): ?>
            <div class="panel panel-default">
                <div class="panel-footer">
                    No products found.
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>

            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$product->name?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if($product->photo_url): ?>
                            <div class="thumbnail">
                                <img src="<?=$product->photo_url?>" alt="">
                            </div>
                        <?php endif; ?>
                        <p>
                            <?=$product->description?>
                        </p>
                        <ul class="list-group">
                            <strong>Prices:</strong>
                            <li class="list-group-item">
                                <span class="badge"><?=$product->price?> RUB</span>
                                Russian Ruble
                            </li>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?php foreach ($currencyList as $refCurrency): ?>
                                    <li class="list-group-item">
                                        <span class="badge">
                                            <?=$refCurrency->calculatePrice($product->price)?> <?=$refCurrency->currency->char_code?>
                                        </span>
                                        <?=$refCurrency->currency->name?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <?php if (!Yii::$app->user->isGuest && $user->isAdmin()): ?>
                            <?= Html::a('Edit Product', Url::toRoute(['admin/product/edit', 'id' => $product->id]),  ['class' => 'btn btn-sm btn-primary'])?>
                            <?=
                                Html::beginForm(['admin/product/delete'], 'post') .
                                Html::hiddenInput('id', $product->id) .
                                Html::submitButton('Delete Product',  ['class' => 'btn btn-sm btn-danger']) .
                                Html::endForm()
                            ?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-footer">
                        Vendor Code: <?=$product->vendor_code?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
