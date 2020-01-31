<?php
/**
 * Created by PhpStorm.
 * User: hilbr
 * Date: 31.03.2020
 * Time: 16:49
 */

namespace frontend\config\rules;

use yii\helpers\Url;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class LocaleUrlRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {
        $url = explode('/', $request->pathInfo);
        $locale = array_intersect($url, array_keys(\Yii::$app->params['availableLocales']));

        if ($locale && $locale[0] != \Yii::$app->language) {
            return ['site/set-locale', ['locale' => $locale[0]]];
        }

        if (!$locale) {
            if (\Yii::$app->language && in_array(\Yii::$app->language, array_keys(\Yii::$app->params['availableLocales']))) {
                //\Yii::$app->response->redirect(Url::home() . '/' . \Yii::$app->language . ($request->pathInfo ? '/' . $request->pathInfo : ''), 301);
                \Yii::$app->response->redirect(Url::home() . '/' . \Yii::$app->language .
                    ($request->pathInfo ? '/' . $request->pathInfo : '') . ($request->queryParams ? '?' . http_build_query($request->queryParams) : ''),
                    301);
                \Yii::$app->end();
            }
        }

        if (array_key_exists($request->pathInfo, \Yii::$app->params['availableLocales'])) {
            return ['site/index', []];
        }

        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'site/set-locale') {

           $url = explode('/', \Yii::$app->request->pathInfo);
           $locale = array_intersect($url, array_keys(\Yii::$app->params['availableLocales']));

           if ($locale && isset($params['locale'])) {
               $diffUrl = array_diff($url, array_keys(\Yii::$app->params['availableLocales']));
               array_unshift($diffUrl, $params['locale']);
               return implode('/', $diffUrl);
           }

           if (isset($params['locale'])) {
               return $params['locale'] . '/' . \Yii::$app->request->pathInfo;
           }
        }
        return false;  // данное правило не применимо
    }
}