<?php

namespace console\controllers;

use common\models\Currency;
use yii\console\Controller;
use yii\httpclient\Client;

/**
 * Class CurrencyController
 */
class CurrencyController extends Controller
{
    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionGetCurrencies(): void
    {
        $client = new Client([
            'responseConfig' => [
                'format' => Client::FORMAT_XML
            ],
        ]);

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://www.cbr.ru/scripts/XML_daily_eng.asp')
            ->send();

        $currencies = $request->getData();

        foreach ($currencies['Valute'] as $key => $currency) {
            $currencyId = $currency['@attributes']['ID'];

            $currencyModel = Currency::byCbrId($currencyId);

            if ($currencyModel === null) {
                $currencyModel = new Currency();
                $currencyModel->cbr_id = $currencyId;
            }

            $currencyModel->name = $currency['Name'];
            $currencyModel->char_code = $currency['CharCode'];
            $currencyModel->value = $currency['Value'] / $currency['Nominal'];

            $currencyModel->save();
        }

        $this->stdout('Success!' . PHP_EOL);
    }
}