<?php

namespace console\controllers;

use common\models\Country;
use common\models\Respondent;
use common\models\Result;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class AppController extends Controller
{
    /** @var array */
    public $writablePaths = [
        '@common/runtime',
        '@frontend/runtime',
        '@frontend/web/assets',
        '@backend/runtime',
        '@backend/web/assets',
        '@storage/cache',
        '@storage/web/source',
        '@api/runtime',
    ];

    /** @var array */
    public $executablePaths = [
        '@backend/yii',
        '@frontend/yii',
        '@console/yii',
        '@api/yii',
    ];

    /** @var array */
    public $generateKeysPaths = [
        '@base/.env'
    ];

    /**
     * Sets given keys to .env file
     */
    public function actionSetKeys()
    {
        $this->setKeys($this->generateKeysPaths);
    }

    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionSetup()
    {
        $this->runAction('set-writable', ['interactive' => $this->interactive]);
        $this->runAction('set-executable', ['interactive' => $this->interactive]);
        $this->runAction('set-keys', ['interactive' => $this->interactive]);
        \Yii::$app->runAction('migrate/up', ['interactive' => $this->interactive]);
        \Yii::$app->runAction('rbac-migrate/up', ['interactive' => $this->interactive]);
    }

    /**
     * Truncates all tables in the database.
     * @throws \yii\db\Exception
     */
    public function actionTruncate()
    {
        $dbName = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
        if ($this->confirm('This will truncate all tables of current database [' . $dbName . '].')) {
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
            $tables = Yii::$app->db->schema->getTableNames();
            foreach ($tables as $table) {
                $this->stdout('Truncating table ' . $table . PHP_EOL, Console::FG_RED);
                Yii::$app->db->createCommand()->truncateTable($table)->execute();
            }
            Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
        }
    }

    /**
     * Drops all tables in the database.
     * @throws \yii\db\Exception
     */
    public function actionDrop()
    {
        $dbName = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
        if ($this->confirm('This will drop all tables of current database [' . $dbName . '].')) {
            Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::$app->db->schema->getTableNames();
            foreach ($tables as $table) {
                $this->stdout('Dropping table ' . $table . PHP_EOL, Console::FG_RED);
                Yii::$app->db->createCommand()->dropTable($table)->execute();
            }
            Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();
        }
    }

    /**
     * @param string $charset
     * @param string $collation
     * @throws \yii\base\ExitException
     * @throws \yii\base\NotSupportedException
     * @throws \yii\db\Exception
     */
    public function actionAlterCharset($charset = 'utf8mb4', $collation = 'utf8mb4_unicode_ci')
    {
        if (Yii::$app->db->getDriverName() !== 'mysql') {
           Console::error('Only mysql is supported');
           Yii::$app->end(1);
        }

        if (!$this->confirm("Convert tables to character set {$charset}?")) {
            Yii::$app->end();
        }

        $tables = Yii::$app->db->getSchema()->getTableNames();
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        foreach ($tables as $table) {
            $command = Yii::$app->db->createCommand("ALTER TABLE {$table} CONVERT TO CHARACTER SET :charset COLLATE :collation")->bindValues([
                ':charset' => $charset,
                ':collation' => $collation
            ]);
            $command->execute();
        }
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
        Console::output('All ok!');
    }


    /**
     * Adds write permissions
     */
    public function actionSetWritable()
    {
        $this->setWritable($this->writablePaths);
    }

    /**
     * Adds execute permissions
     */
    public function actionSetExecutable()
    {
        $this->setExecutable($this->executablePaths);
    }

    /**
     * @param $paths
     */
    private function setWritable($paths)
    {
        foreach ($paths as $writable) {
            $writable = Yii::getAlias($writable);
            Console::output("Setting writable: {$writable}");
            @chmod($writable, 0777);
        }
    }

    /**
     * @param $paths
     */
    private function setExecutable($paths)
    {
        foreach ($paths as $executable) {
            $executable = Yii::getAlias($executable);
            Console::output("Setting executable: {$executable}");
            @chmod($executable, 0755);
        }
    }

    /**
     * @param $paths
     */
    private function setKeys($paths)
    {
        foreach ($paths as $file) {
            $file = Yii::getAlias($file);
            Console::output("Generating keys in {$file}");
            $content = file_get_contents($file);
            $content = preg_replace_callback('/<generated_key>/', function () {
                $length = 32;
                $bytes = openssl_random_pseudo_bytes(32, $cryptoStrong);
                return strtr(substr(base64_encode($bytes), 0, $length), '+/', '_-');
            }, $content);
            file_put_contents($file, $content);
        }
    }

    /**
     * консольная команда добавления данных в таблицы result и respondent
     */

    public function actionAddDataResultAndRespondent() // php yii app/add-data-result-and-respondent
    {
        $start = microtime(true);

        $name = ["Petiy", "John", "Jon Travolta", "Jan clod Van Dam", "Madonna", "Juriy Mironow", "Morgunov", "Nikilas Keidj"];
        $email = ["Petiy@gmail.com", "John@gmail.com", "JonTravolta@gmail.com", "JanclodVanDam@gmail.com", "Madonna@gmail.com", "JuriyMironow@gmail.com", "Morgunov@gmail.com", "NikilasKeidj@gmail.com"];

        for ($i = 0; $i < 100; $i++ ) {
            $respondent = new Respondent();
            $result = new Result();

            $rand_keys_name = array_rand($name, 1);
            $rand_keys_email = array_rand($email, 1);

            $respondent->name = $name[$rand_keys_name];
            $respondent->email = $email[$rand_keys_email];
            $respondent->gender = rand(1, 2);
            $respondent->birth_year = rand(1920, 2010);
            $respondent->education = rand(1, 16);
            $respondent->education_level = rand(0, 6);
            $respondent->ip = '12345678901';
            $respondent->country_id = rand(1, 249);
            $respondent->save();

            $result->iq = rand(40, 180);
            $result->respondent_id = $respondent->id;
            $result->answers = "{\"ФИО\":\"Иванов Сергей\", \"Дата рождения\":\"09.03.1975\"}";
            $result->token = "84654sdf4654";
            $result->payed_status = rand(0, 1);
            $result->save();
        }

        Console::output('Времея загрузки улиц: ' . round(microtime(true) - $start, 2) . ' сек');
    }

    public function actionAddPhotoPath() // php yii app/add-photo-path
    {
        $start = microtime(true);

        $countries = Country::find()->all();
        foreach ($countries as $country) {
            $country->photo_base_url = '/img/';
            $country->photo_path = 'country-flags/' . strtolower($country->isoCode) . '.png';
            $country->save();
        }

        Console::output('Времея загрузки улиц: ' . round(microtime(true) - $start, 2) . ' сек');
    }
}
