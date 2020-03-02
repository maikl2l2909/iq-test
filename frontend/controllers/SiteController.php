<?php

namespace frontend\controllers;

use cheatsheet\Time;
use common\models\Country;
use common\models\GraphicsData;
use common\models\Question;
use common\models\RecoverResultForm;
use common\models\Respondent;
use common\models\Result;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\filters\PageCache;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales']),
                'callback' => function($action) {
                    $url = explode('/', Yii::$app->request->pathInfo);
                    $diffUrl = array_diff($url, array_keys(\Yii::$app->params['availableLocales']));
                    array_unshift($diffUrl, Yii::$app->controller->actionParams['locale']);

                    return Yii::$app->response->redirect(Yii::$app->homeUrl . '/' . implode('/', $diffUrl));
                }
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $respondent = new Respondent();
        $result = new Result();
        $graphicsData = new GraphicsData();

        if (Yii::$app->request->post() && $respondent->load(Yii::$app->request->post())) {
            $geoIP = (new \lysenkobv\GeoIP\GeoIP())->ip(\Yii::$app->request->userIP);
            $country = Country::findOne(['isoCode' => $geoIP->isoCode]);

            $respondent->ip = inet_pton(\Yii::$app->request->userIP);
            $respondent->country_id = $country ? $country->id : null;
            $respondent->save();

            $result->load(Yii::$app->request->post());
            $result->respondent_id = $respondent->id;
            $result->save(false);
            return Yii::$app->response->redirect(['site/view-result', 'token' => $result->token]);
        }

        $birthYears = Respondent::allowYear();

        $this->view->registerJsVar('testOrder',
            [1, 13, 6, 11, 22, 17, 2, 18, 19, 15, 20, 37, 39, 9, 36, 12, 16, 24, 30, 3,
                25, 5, 26, 35, 29, 14, 34, 28, 21, 31, 38, 40, 4, 32, 10, 33, 27, 23, 7, 8]);

        $this->view->registerJsVar('imagePathsForTest', Question::imagePathsForTest());

        $lastTwentyResults = $result->find()
            ->joinWith(['respondent.country'])
            ->limit(20)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $generalDistributionIqData = $graphicsData->generalDistributionIqData() ? array_values($graphicsData->generalDistributionIqData()) : [];
        $ageGroupData = $graphicsData->ageGroupData() ? array_values($graphicsData->ageGroupData()) : [];
        $educationLevelData = $graphicsData->educationLevelData() ? array_values($graphicsData->educationLevelData()) : [];
        $educationData = $graphicsData->educationData() ? array_values($graphicsData->educationData()) : [];


        return $this->render('index', [
            'lastTwentyResults' => $lastTwentyResults,
            'ageGroupData' => $ageGroupData,
            'generalDistributionIqData' => $generalDistributionIqData,
            'educationLevelData' => $educationLevelData,
            'educationData' => $educationData,
            'respondent' => $respondent,
            'result' => $result,
            'birthYears' => $birthYears,
        ]);
    }

    public function actionViewResult($token)
    {
        $resultRespondent = Result::find()
            ->where(['token' => $token])
            ->one()
        ;

        $iq = $resultRespondent->iq;

        $graphicsData = new GraphicsData();

        $generalDistributionIqData = array_values($graphicsData->generalDistributionIqData());
        $ageGroupData = array_values($graphicsData->ageGroupData());
        $educationLevelData = array_values($graphicsData->educationLevelData());
        $educationData = array_values($graphicsData->educationData());
        array_push($ageGroupData, $iq);
        array_push($educationLevelData, $iq);
        array_push($educationData, $iq);
        $percentageToOtherResults = $graphicsData->percentageToOtherResults($iq);
        $percentageAge = $graphicsData->percentageAge($resultRespondent->respondent->birth_year, $iq);
        $percentageEducationLevel = $graphicsData->percentageEducationLevel($resultRespondent->respondent->education_level, $iq);
        $percentageEducation = $graphicsData->percentageEducation($resultRespondent->respondent->education, $iq);

        return $this->render('view-result', [
            'respondentIq' => $iq,
            'resultRespondent' => $resultRespondent,
            'generalDistributionIqData' => $generalDistributionIqData,
            'ageGroupData' => $ageGroupData,
            'educationLevelData' => $educationLevelData,
            'educationData' => $educationData,
            'percentageToOtherResults' => $percentageToOtherResults,
            'percentageAge' => $percentageAge,
            'percentageEducationLevel' => $percentageEducationLevel,
            'percentageEducation' => $percentageEducation,
        ]);
    }

    /**
     * @return string
     */
    public function actionRecover()
    {
        $recoverResultForm = new RecoverResultForm();
        if($recoverResultForm->load(Yii::$app->request->post()) && $recoverResultForm->validate()) {
            $respondent = Respondent::find()
                ->where(['email' => $recoverResultForm->email])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if ($respondent) {
                $token = $respondent->result->token;

                Yii::$app->mailer->compose('recover-result', [
                    'token' => $token
                ])
                    ->setFrom(env("SMTP_EMAIL"))
                    ->setTo($respondent->email)
                    ->setSubject('hello friends')
                    ->send();
            } else {
                Yii::$app->session->setFlash('errorEmail', "Ошибка: никакие результаты не связаны с этим адресом электронной почты.");
                $this->render('recover-result', [
                    'model' => $recoverResultForm
                ]);
            }

        }
        return $this->render('recover-result',[
            'model' => $recoverResultForm
        ]);
    }

    /**
     * @return string
     */
    public function actionConditions()
    {
        return $this->render('conditions');
    }

    /**
     * @return string|Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options' => ['class' => 'alert-success']
                ]);
                return $this->refresh();
            }

            Yii::$app->getSession()->setFlash('alert', [
                'body' => \Yii::t('frontend', 'There was an error sending email.'),
                'options' => ['class' => 'alert-danger']
            ]);
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSitemap($format = Sitemap::FORMAT_XML, $gzip = false)
    {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === Sitemap::FORMAT_XML) {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === Sitemap::FORMAT_TXT) {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }
}
