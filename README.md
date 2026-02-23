## Setup

1. Pull project from repo to local
2. run: `docker compose up -d --build` to install correct container
3. run: `docker compose exec php composer install`
4. create db: `docker compose exec php bin/console doctrine:database:create`
5. migrate: `docker compose exec php bin/console doctrine:migrations:migrate`
6. fixtures load: `docker compose exec php bin/console doctrine:fixtures:load`

Open http://localhost:8080

### Fix moments:

#### compile container: `docker compose up -d --build`
#### destroy container: `docker compose down -v`
#### restart container: `docker compose restart php`
#### clear docker cache: `docker compose exec php php bin/console cache:clear`
