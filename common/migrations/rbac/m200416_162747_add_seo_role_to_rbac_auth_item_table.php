<?php

use yii\db\Schema;
use common\rbac\Migration;
use common\models\User;

class m200416_162747_add_seo_role_to_rbac_auth_item_table extends Migration
{
public function up()
{
    $seo = $this->auth->createRole(User::ROLE_SEO);
    $this->auth->add($seo);
    $this->auth->addChild($seo, $this->auth->getRole(User::ROLE_USER));
    $loginToBackend = $this->auth->getPermission('loginToBackend');
    $this->auth->addChild($seo, $loginToBackend);
}

public function down()
{
    $this->auth->remove($this->auth->getRole(User::ROLE_SEO));
}
}
