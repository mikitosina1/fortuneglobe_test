# Setup

1. Clone repository
2. Build and start containers: `docker compose up -d --build`
3. Install dependencies: `docker compose exec php composer install`
4. Create database: `docker compose exec php bin/console doctrine:database:create`
5. Run migrations: `docker compose exec php bin/console doctrine:migrations:migrate`
6. Load fixtures: `docker compose exec php bin/console doctrine:fixtures:load`

Application will be available at: http://localhost:8080

---

## API Endpoint

**GET** `/api/pos/summary`

Returns a summary of orders per point of sale for a given period.

**Optional query parameters:**

| Parameter | Format   | Description                          |
|-----------|----------|--------------------------------------|
| `from`    | YYYY-MM-DD | Start of the period (inclusive).  |
| `to`      | YYYY-MM-DD | End of the period (inclusive).    |

If `from` and `to` are not provided, the **current calendar month** is used.

**Example:**

```
GET http://localhost:8080/api/pos/summary?from=2026-02-01&to=2026-02-28
```

**Response:** JSON array of objects with `id`, `name`, `orderCount`, `totalRevenue`, and `averageOrderValue` per point of sale.

```
[
  {
    "id": 1,
    "name": "Berlin Store",
    "orderCount": 145,
    "totalRevenue": 12450.50,
    "averageOrderValue": 85.86
  }
]
```

---

### Fix moments:

#### compile container: `docker compose up -d --build`
#### destroy container: `docker compose down -v`
#### restart container: `docker compose restart php`
#### clear docker cache: `docker compose exec php php bin/console cache:clear`
