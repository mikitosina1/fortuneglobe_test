## Setup

1. Pull project from repo to local
2. docker compose up -d --build
3. docker compose exec php composer install

Open http://localhost:8080

### Fix moments:

#### compile container: `docker compose up -d --build`
#### destroy container: `docker compose down -v`
#### restart container: `docker compose restart php`
#### clear docker cache: `docker compose exec php php bin/console cache:clear`
