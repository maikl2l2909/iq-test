<?php
/**
 * Created by PhpStorm.
 * User: hilbr
 * Date: 02.05.2019
 * Time: 14:44
 */

namespace frontend\config\rules;

use common\models\Result;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class TokenResultUrlRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {
        $url = explode('/', $request->pathInfo);

        $result = Result::findOne(['token' => array_pop($url)]);

        if($result) {
            return ['site/view-result', ['token' => $result->token]];
        } else {
            return false;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'site/view-result' && isset($params['token'])) {
            return \Yii::$app->language . '/' . $params['token'];
        }

        return false;
    }
}