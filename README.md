# Popolni.club API Wrapper in PHP

# Требования

* PHP 8.0 или выше
* Composer
* GuzzleHTTP

# Composer

```bash
composer require pavlo-dot-dev/popolni-club
```

# Примеры

### Авторизация

```php
$login = '...';
$password = '...';

$api = new PavloDotDev\PopolniClub\API($api);
```

### Запрос баланса

```php
$balance = $api->balance();

echo "Текущий баланс: {$balance->amount()} руб.";
```

### Создание транзакции

```php
$transactions = $api->transactions()->create(mt_rand(10000000, 999999999), 100, '79012345678')->send();
print_r($transactions[0]->statusText());
```
