<?php

namespace frontend\controllers\admin;

use common\models\Product;
use frontend\models\admin\ProductForm;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package frontend\controllers\admin
 */
class ProductController extends AdminController
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductForm();

        if (Yii::$app->request->post() && $model->createProduct(Yii::$app->request->post('ProductForm'))) {
            Yii::$app->session->setFlash('success', 'Your product was successfully created.');

            return $this->redirect(Url::toRoute('product/list'));
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        if (Yii::$app->request->post()) {
            if ($product = Product::findOne(['id' => Yii::$app->request->post('id')])) {
                $product->delete();
            }
        }

        return $this->redirect(Url::toRoute('product/list'));
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEdit(int $id)
    {
        if (!$product = Product::findOne(['id' => $id])) {
            throw new NotFoundHttpException('Product not found');
        }

        $model = new ProductForm();

        $model->setAttributes($product->attributes);

        if (Yii::$app->request->post('type') === 'delete-photo' && $model->deletePhoto($product)) {
            Yii::$app->session->setFlash('success', 'Your product was successfully updated.');

            $model->setAttributes($product->attributes);
        } elseif (Yii::$app->request->post() && $model->updateProduct($product, Yii::$app->request->post('ProductForm'))) {
            Yii::$app->session->setFlash('success', 'Your product was successfully updated.');

            $model->setAttributes($product->attributes);
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }
}