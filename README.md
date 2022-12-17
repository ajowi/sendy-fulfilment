#  Sendy Fulfillment Service package for Laravel/PHP applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ajowi/sendy-fulfilment.svg?style=flat-square)](https://packagist.org/packages/ajowi/sendy-fulfilment)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ajowi/sendy-fulfilment/master.svg?style=flat-square)](https://travis-ci.org/ajowi/sendy-fulfilment)
[![Total Downloads](https://img.shields.io/packagist/dt/ajowi/sendy-fulfilment.svg?style=flat-square)](https://packagist.org/packages/ajowi/sendy-fulfilment)

This package makes it easy to integrate Sendy Fulfillment Service API [Sendy Fulfillment](https://api.sendyit.com/v2/documentation) into your php applications.


## Contents

- [Requirements](#requirements)
- [Installation](#installation)
	- [Setting up the Sendy Fulfillment service](#setting-up-the-sendy-fulfillment-service)
- [Usage](#usage)
	- [Available Operations](#available-operations)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Requirements

- [Sign up](https://app.sendyit.com) for a Sendy Fulfillment account
- Generate your API token in settings

## Installation

You can install the package via composer:

``` bash
composer require ajowi/sendy-fulfilment
```

### Setting up the Sendy Fulfillment service

On Laravel add your Sendy API Token and Endpoint URL to your `config/services.php`:

```php
// config/services.php
...
'sendy' => [
    'token' => env('SENDY_TOKEN'),
    'endpoint_url' => env('SENDY_ENDPOINT_URL'),
],
...
```

## Usage

Example request for an order's price quotations that return available pricing tiers given pickup and delivery coordinates
``` php
    use Ajowi\SendyFulfillment\PriceRequest;

    $data = new array(
        'ecommerce_order' => 'ODR-0000',
        'recepient' => [
                'name' => 'David Ajowi',
                'email' => 'ajowi@daniche.co.ke',
                'phone' => '+254 712345678'
        ],
        'locations' => [
            [
                'type' => 'PICKUP',
                'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
                'lat' => -1.597429319708498,
                'long' => -1.597429319708498,
                'name' => 'Destination'
            ],
            [
                'type' => 'DELIVERY',
                'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
                'lat' => -1.597429319708498,
                'long' => -1.597429319708498,
                'name' => 'Destination'
            ]
        ]
    );
    
    /**
     * -----------
     * IMPORTANT
     * -----------
     * If you are not using Laravel, pass the API token/key and Endpoint URL to the constructor like so
     * 
     *  $priceRequest = new PriceRequest('SENDY_API_TOKEN', 'ENDPOINT_URL');
     * 
     */
    $priceRequest = new PriceRequest();
    $priceRequest->initialize($data);

    // Do a price request
    try {
        $response = $priceRequest->send();
        $data = $response->getData();
        echo "Response data : " . print_r($data, true) . "\n";

        if ($response->isSuccessful()) {
            echo "Request was successful!\n";
        }
    } catch (\Exception $e) {
        echo "Message : " . $e->getMessage() . "\n";
    }

```
### Available Operations

- `Price request`: Requests for an order's price quotations and returns available pricing tiers given pickup and delivery coordinates
- `Confirm an order`: Facilitates confirmation of an order after getting a quotation from the price request endpoint, using the pricing UUIDs
- `Fetch an order`: View the items in an order waypoint(s) or path of a given order
- `Cancel an order`: Facilitates cancellation of orders.
- `Track an order`: Get details about an order which include tracking details, status, rider details et al.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [David Ajowi](https://github.com/ajowi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
