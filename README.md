# SystempayBundle

This bundle integrates [SystemPay](https://paiement.systempay.fr/html/) to your symfony project. Systempay is a payment gateway developped by Natixis & Lyra Network. 

This bundle only supports the "API Formulaire" for now. [See official Systempay documentation](https://paiement.systempay.fr/doc/fr-FR/form-payment/quick-start-guide/tla1427193445290.pdf) (PDF) 

Supported banks and platforms seems to be (as of Oct. 2019):
* **Banque Populaire** : Cyberplus Paiement, Paiement Express, Direct et Proche, & Direct et Bon
* **Caisse d’Epargne** : SP Plus et Jepaieenligne
* Natixis : Conexens
* Crédit Coopératif : SP Plus et Jepaieenligne
* Banque BCP : SP Plus et Jepaieenligne
* Banque Palatine : P@yby
* Banques filiales de BPCE : E-commerce
* Banques partenaires : Moneteam

Source : [natixis.com](https://www.ocl.natixis.com/systempay/syshome/index/id/1)

[![Total Downloads](https://poser.pugx.org/baptiste-dulac/systempay-bundle/downloads.svg)](https://packagist.org/packages/baptiste-dulac/systempay-bundle)
[![Latest Stable Version](https://poser.pugx.org/baptiste-dulac/systempay-bundle/v/stable.svg)](https://packagist.org/packages/baptiste-dulac/systempay-bundle)

## Requirements
* PHP >=7.2.0
* Symfony >=4.1
    * Twig
    * Doctrine 

## How to use
### Install using Composer
Using composer
```bash
composer require lone-studio/systempay-bundle
```

### Configure the bundle


```yaml
systempay:
    # Keys
    key_dev: XXXXX
    key_prod: XXXXX
    hash_method: hmac_sha256 # Possible values are: sha1 / hmac_sha256
    vads:
        # Credentials
        site_id: XXXXX
        # Return
        url_return: http://www.example.com/payment_return
        # Debug values : ON / OFF
        debug: ON
        # Return mode
        return_mode: GET
        # Possible values for ctx_mode : TEST / PRODUCTION
        ctx_mode: TEST
        # Language
        language: fr
```

### Database

This bundle comes with a pre-congifured abstract class called `AbtractTransaction` that must be extended and will be used to store individual transations.
You have to extend `BDulac\Entity\AbstractTransaction` yourself and manage it in your controller or service

```php
<?php

namespace App\Entity;

use Lone\SystempayBundle\Entity\AbstractTransaction;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="transactions")
 * @ORM\Entity()
 */
class Transaction extends AbstractTransaction {
 
    // Your own logic here
   
}

```

### Create a Transaction
To intantiate a new Transaction, simply create a Transaction.

`` new Transaction($amount, $currency) ``

You can then call `init($currency = 978, $amount = 1000)` on `Lone\SystempayBundle\Service\SystemPayService`. It will fill out the fields for you.

For a given transaction, use the `setOptionnalFields(array)` method to specify any field that will be send to the System Pay Gateway.

```php
  
```

#### Handle the response from the server
This route will be called by the Systempay service to update you about the payment status. This is the only way to correctly handle payment verfication.

##### Service Method

* `responseHandler(Request)` is used to update the transaction status (in database)

##### Example

```php
   // TODO
```

### Templating

This is how the template for the `payOnlineAction()` may look like. You can use the `systempayForm` twig function to automatically generate the form based on the fields created in the service and returned by the `getResponse()` function.

```twig
   // TODO
```


## Changes from 0.x

TODO

## Copyright

You can use freely this bundle.

Supported by [Lone.studio](https://lone.studio)