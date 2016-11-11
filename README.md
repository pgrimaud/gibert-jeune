# Gibert Jeune

[![Packagist](https://img.shields.io/badge/packagist-install-brightgreen.svg)](https://packagist.org/packages/pgrimaud/gibert-jeune)
[![Build Status](https://travis-ci.org/pgrimaud/gibert-jeune.svg?branch=master)](https://travis-ci.org/pgrimaud/gibert-jeune)
[![Code Climate](https://codeclimate.com/github/pgrimaud/gibert-jeune/badges/gpa.svg)](https://codeclimate.com/github/pgrimaud/gibert-jeune)
[![Test Coverage](https://codeclimate.com/github/pgrimaud/gibert-jeune/badges/coverage.svg)](https://codeclimate.com/github/pgrimaud/gibert-jeune/coverage)

Little scraper for https://www.gibertjeune.fr

## Usage

```
composer require pgrimaud/gibert-jeune
```

```php
$api = new \GibertJeune\Api();
$api->setBarcode('9782344009505');

$product = $api->getProduct();
```

Will return : 
```php
Array
(
    [0] => Array
        (
            [title] => Réservation
            [prices] => Array
                (
                    [0] => Array
                        (
                            [state] => Neuf
                            [price] => 0
                        )

                    [1] => Array
                        (
                            [state] => Occasion
                            [price] => 0
                        )

                )

        )

    [1] => Array
        (
            [title] => Expédition
            [prices] => Array
                (
                    [0] => Array
                        (
                            [state] => Neuf
                            [price] => 14.95
                        )

                    [1] => Array
                        (
                            [state] => Occasion
                            [price] => 0
                        )

                )

        )

    [2] => Array
        (
            [title] => E-Book
            [prices] => Array
                (
                    [0] => Array
                        (
                            [state] => Numérique
                            [price] => 0
                        )

                )

        )

)

```