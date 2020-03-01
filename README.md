# IQ Test

Online IQ test based on Raven's progressive matrices. Users answer 40 visual pattern questions, receive an IQ score, and compare their result against population statistics by age, education, and other demographics.

Built on [Yii2 Starter Kit](https://github.com/yii2-starter-kit/yii2-starter-kit) — a Yii2 advanced application template with a ready-made admin panel, REST API, and Docker environment.

## How it works

1. A visitor starts the test on the homepage and answers 40 matrix-style questions (choose the missing figure from six options).
2. After completing the test, the user submits a short profile form (name, email, gender, birth year, education).
3. The application calculates an IQ score from the answers and generates a unique token URL for the result page.
4. The result page shows the IQ score and comparison charts against other respondents (overall distribution, age group, education level, field of study).
5. Users can recover a past result by email if they lost the link.

Questions are presented in a randomized order. Country is detected automatically via GeoIP.

## Features

### IQ test (frontend)

- 40 Raven-style matrix questions with image-based answer options
- Client-side test flow with progress tracking
- IQ scoring and secure token-based result URLs
- Demographic comparison charts (Chart.js)
- Result recovery by email
- Russian UI with i18n support (English and other locales available)
- Yandex Metrika and Google Analytics event tracking

### Admin panel (backend)

- Content management: articles, pages, menus, carousels, text blocks
- User management and RBAC (`guest`, `user`, `manager`, `administrator`)
- Settings editor, file manager, logs viewer, system monitoring
- Translation manager

### Development

- Docker stack: PHP, Nginx, MySQL, Mailcatcher
- REST API module with Swagger docs
- Codeception test suite
- Webpack frontend build
- Console seed command for demo results (`app/seed`)

## Tech stack

- PHP 7.1+, Yii2
- MySQL 5.7
- Nginx, Docker Compose
- Chart.js, AdminLTE 2
- GeoIP (country detection)

## Quickstart

### Requirements

- [Composer](https://getcomposer.org)
- [Docker](https://docs.docker.com/install/) and [Docker Compose](https://docs.docker.com/compose/install/)

### Run with Docker

```bash
git clone https://github.com/maikl2l2909/iq-test.git
cd iq-test
composer install
cp .env.dist .env
docker-compose up -d --build
docker-compose exec app console/yii migrate --interactive=0
docker-compose exec app console/yii rbac-migrate --interactive=0
```

Open [http://yii2-starter-kit.localhost](http://yii2-starter-kit.localhost) for the test.

Admin panel: [http://backend.yii2-starter-kit.localhost](http://backend.yii2-starter-kit.localhost)

```
Login: webmaster
Password: webmaster
```

For manual setup, Vagrant, and other options see [docs/installation.md](docs/installation.md).

## Documentation

- [Installation](docs/installation.md)
- [Components](docs/components.md)
- [Console commands](docs/console.md)
- [Testing](docs/testing.md)
- [FAQ](docs/faq.md)

## Project structure

```
api/        REST API
backend/    Admin panel
common/     Shared models (Question, Respondent, Result), migrations, config
console/    CLI commands and migrations runner
frontend/   Public IQ test UI
docker/     Docker images and Nginx config
docs/       Detailed documentation
tests/      Codeception tests
```

## License

BSD-3-Clause. See [LICENSE.md](LICENSE.md).
