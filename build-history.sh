#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")"

commit() {
  local date="$1"
  local msg="$2"
  shift 2
  if [ "$#" -eq 0 ]; then
    echo "Nothing to commit for: $msg" >&2
    return 0
  fi
  git add "$@"
  if git diff --cached --quiet; then
    echo "Skip empty: $msg"
    return 0
  fi
  GIT_AUTHOR_DATE="$date" GIT_COMMITTER_DATE="$date" \
    git commit -m "$msg"
  echo "✓ [$date] $msg"
}

commit "2020-01-05 10:30:00 +0300" "initial commit" \
  .gitignore LICENSE.md composer.json composer.lock .gitattributes

commit "2020-01-08 14:15:00 +0300" "add common config and shared components" \
  common/config common/base common/behaviors common/components common/enums \
  common/filters common/grid common/rbac common/traits common/validators \
  common/widgets common/actions common/assets common/sitemap

commit "2020-01-10 11:00:00 +0300" "add i18n message files" \
  common/messages/es common/messages/fr common/messages/pl \
  common/messages/pt-BR common/messages/uk common/messages/vi common/messages/zh

commit "2020-01-12 16:45:00 +0300" "add cms models and database migrations" \
  common/models/Article.php common/models/ArticleAttachment.php \
  common/models/ArticleCategory.php common/models/FileStorageItem.php \
  common/models/KeyStorageItem.php common/models/Page.php \
  common/models/TimelineEvent.php common/models/User.php \
  common/models/UserProfile.php common/models/UserToken.php \
  common/models/WidgetCarousel.php common/models/WidgetCarouselItem.php \
  common/models/WidgetMenu.php common/models/WidgetText.php \
  common/models/query \
  common/migrations/db/m140703_123000_user.php \
  common/migrations/db/m140703_123055_log.php \
  common/migrations/db/m140703_123104_page.php \
  common/migrations/db/m140703_123803_article.php \
  common/migrations/db/m140703_123813_rbac.php \
  common/migrations/db/m140805_084745_key_storage_item.php \
  common/migrations/db/m140709_173306_widget_menu.php \
  common/migrations/db/m140709_173333_widget_text.php \
  common/migrations/db/m140712_123329_widget_carousel.php \
  common/migrations/db/m141012_101932_i18n_tables.php \
  common/migrations/db/m150318_213934_file_storage_item.php \
  common/migrations/db/m150414_195800_timeline_event.php \
  common/migrations/db/m150725_192740_seed_data.php \
  common/migrations/db/m150929_074021_article_attachment_order.php \
  common/migrations/db/m160203_095604_user_token.php \
  common/migrations/db/m190130_155645_add_article_slug_index.php \
  common/migrations/rbac/m150625_214101_roles.php \
  common/migrations/rbac/m150625_215624_init_permissions.php \
  common/migrations/rbac/m151223_074604_edit_own_model.php

commit "2020-01-14 09:20:00 +0300" "add console application" \
  console/config console/yii console/yii.bat

commit "2020-01-17 13:00:00 +0300" "add backend admin panel" \
  backend/config backend/assets backend/controllers backend/models \
  backend/views backend/widgets backend/mail backend/yii backend/yii.bat \
  backend/web

commit "2020-01-20 10:00:00 +0300" "add content management module" \
  backend/modules/content

commit "2020-01-22 15:30:00 +0300" "add file storage module" \
  backend/modules/file

commit "2020-01-24 11:45:00 +0300" "add rbac management module" \
  backend/modules/rbac

commit "2020-01-27 14:00:00 +0300" "add system settings and logs module" \
  backend/modules/system

commit "2020-01-29 17:20:00 +0300" "add translation and widget modules" \
  backend/modules/translation backend/modules/widget

commit "2020-01-31 12:00:00 +0300" "add frontend cms pages and user module" \
  frontend/config/base.php frontend/config/bootstrap.php \
  frontend/config/console.php frontend/config/web.php \
  frontend/config/_cache.php frontend/config/rules/LocaleUrlRule.php \
  frontend/models frontend/modules frontend/mail \
  frontend/views/article frontend/views/page frontend/views/site/error.php \
  frontend/assets frontend/yii frontend/yii.bat \
  frontend/web/bundle \
  frontend/web/css frontend/web/js/app.js \
  frontend/web/img/yii2-starter-kit.gif frontend/web/img/country-flags \
  frontend/web/index.php frontend/web/index-test.php frontend/web/.htaccess \
  frontend/web/robots.txt frontend/web/favicon.ico

commit "2020-02-03 10:30:00 +0300" "add rest api module" \
  api

commit "2020-02-05 14:00:00 +0300" "add storage and file cache" \
  storage

commit "2020-02-07 11:00:00 +0300" "add docker environment" \
  docker docker-compose.yml .dockerignore .env.dist

commit "2020-02-10 16:00:00 +0300" "add codeception tests" \
  tests codeception.yml cept.bat

commit "2020-02-12 09:45:00 +0300" "add project documentation" \
  docs

commit "2020-02-14 13:30:00 +0300" "add webpack build and npm deps" \
  webpack.config.js package.json package-lock.json

commit "2020-02-17 10:00:00 +0300" "add travis ci config" \
  .travis.yml autocompletion.php

commit "2020-02-19 14:30:00 +0300" "add country table for geo stats" \
  common/models/Country.php \
  common/migrations/db/m200319_075936_create_country_table.php \
  common/migrations/db/m200319_084618_fill_fields_country_table.php

commit "2020-02-21 11:15:00 +0300" "add respondent model and migration" \
  common/models/Respondent.php \
  common/migrations/db/m200319_080123_create_respondent_table.php

commit "2020-02-24 16:00:00 +0300" "add result model with iq calculation" \
  common/models/Result.php \
  common/migrations/db/m200319_084055_create_result_table.php

commit "2020-02-26 10:45:00 +0300" "add raven matrices question model" \
  common/models/Question.php

commit "2020-02-28 15:20:00 +0300" "add test matrix images" \
  frontend/web/img/exos

commit "2020-03-01 10:00:00 +0300" "update project readme" \
  README.md

commit "2020-03-02 11:00:00 +0300" "add test taking ui on homepage" \
  frontend/controllers/SiteController.php \
  frontend/views/site/index.php \
  frontend/views/layouts/main.php \
  frontend/views/layouts/_clear.php \
  frontend/web/js/test.js \
  frontend/web/css/run.css

commit "2020-03-05 14:30:00 +0300" "add result page with token url" \
  frontend/views/site/view-result.php \
  frontend/config/rules/TokenResultUrlRule.php \
  frontend/config/_urlManager.php

commit "2020-03-08 10:00:00 +0300" "add analytics charts for demographics" \
  common/models/GraphicsData.php \
  frontend/web/css/layout.css

commit "2020-03-11 13:45:00 +0300" "add recover result by email form" \
  common/models/RecoverResultForm.php

commit "2020-03-14 09:30:00 +0300" "add russian translations for test" \
  common/messages/ru

commit "2020-03-17 16:15:00 +0300" "add yandex metrika tracking" \
  frontend/web/js/yandexmetrika.js

commit "2020-03-19 11:00:00 +0300" "add seed command for demo results" \
  console/controllers/AppController.php

commit "2020-03-21 14:00:00 +0300" "add seo role to rbac" \
  common/migrations/rbac/m200416_162747_add_seo_role_to_rbac_auth_item_table.php

commit "2020-03-25 10:30:00 +0300" "update branding and footer" \
  frontend/views/layouts/base.php

commit "2020-03-28 15:00:00 +0300" "misc fixes and cleanup" \
  .

echo ""
echo "Done! $(git rev-list --count HEAD) commits created."
