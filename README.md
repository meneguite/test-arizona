# Test Arizona

## Install

## Clone Project

```bash
git clone https://github.com/meneguite/test-arizona.git your-project-folder
cd your-project-folder
```


## Install Environments
With Docker and Composer installed in your system just run the following command on project root:

```bash
./bin/minion

2) Start

```

### Install Dependencies

```shell
docker-compose exec php bash
cd html/
composer install
```
### Copy configuration file

```shell
cp config/settings.php.dist config/settings.php
```


## Usage

### For API
Import [Postman](api-silex-skeleton.postman_collection.json) Collection

### For Application

Access the root of the application, usually http://localhost/

### Available routes

* "/":   The root return basic actions disponibles
* "/countries":   Return HTML with list of the countries
* "/countries/json":   Return JSON with list of the countries
* "/countries/csv":   Return CSV with list of the countries
* "/countries/any-other-options": Return Invalid format

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```shell
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.
