<?php

namespace frontend\models\admin;

use common\models\Product;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * Class ProductForm
 * @package frontend\models\admin
 */
class ProductForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    public $photo;

    /**
     * @var string
     */
    public $photo_url;

    /**
     * @var string
     */
    public $vendor_code;

    /**
     * @var double
     */
    public $price;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'price'], 'required'],
            [['name', 'description', 'vendor_code', 'photo', 'photo_url', 'price'], 'default', 'value' => null],
            [['name', 'description', 'photo_url', 'vendor_code'], 'string'],
            [['photo'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createProduct(array $data): bool
    {
        if ($this->load($data, '') && $this->validate()) {
            $photoPath = null;
            if ($photo = UploadedFile::getInstance($this, 'photo')) {
                $photoPath = $this->_uploadPhoto($photo);
            }

            $product = new Product();

            if ($product->load($data, '') && $product->validate()) {
                $product->photo_url = $photoPath;

                return $product->save();
            }
        }

        return false;
    }

    /**
     * @param Product $product
     * @param array $data
     * @return bool
     */
    public function updateProduct(Product $product, array $data): bool
    {
        if ($this->load($data, '') && $this->validate()) {
            $photoPath = $product->photo_url;

            if ($photo = UploadedFile::getInstance($this, 'photo')) {
                $photoPath = $this->_uploadPhoto($photo);
            }

            if ($product->load($data, '') && $product->validate()) {
                $product->photo_url = $photoPath;

                return $product->save();
            }
        }

        return false;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function deletePhoto(Product $product): bool
    {
        @unlink(Yii::getAlias('@webroot') . '/' . $product->photo_url);

        $product->photo_url = null;

        return $product->save();
    }

    /**
     * @param UploadedFile $photo
     * @return null|string
     */
    private function _uploadPhoto(UploadedFile $photo): ?string
    {
        if ($photo === null) {
            return null;
        }

        $filename = 'product_' . Yii::$app->formatter->asTimestamp('now');
        $extension = pathinfo($photo, PATHINFO_EXTENSION);

        $path = Yii::getAlias('@webroot') . '/uploads/';
        $fullPath = $path . $filename . '.' . $extension;

        $photo->saveAs($fullPath);

        return '/uploads/' . $filename . '.' . $extension;
    }
}