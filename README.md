# SystempayBundle
This bundle allows to implement a Payment Solution working with [SystemPay](https://paiement.systempay.fr/html/) for your symfony projet.
This payment solution uses Systempay. Systempay is a payment gateway proposed by the following bank companies :
* Banque Populaire (Cyberplus)
* Caisse d'épargne (SPPlus)

## Note
This bundle is not yet fully operationnal. Please do not use it ;)

## Installation
### Step 1 : Import using Composer
Using composer :
```json
{
    "require": {
        "baptiste-dulac/systempay-bundle": "master"
    }
}
```

### Step 2 : Enable the plugin
Enable the bundle in the kernel:
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tlconseil\SystempayBundle\TlconseilSystempayBundle(),
    );
}
```

### Step 3 : Configure the bundle
Mandatory fields :
```yaml
tlconseil_systempay:
    # Credentials
    site_id: XXXXX
    # Keys
    key_dev: XXXXX
    key_prod: XXXXX
    # Return
    url_return: http://www.example.com/payment_return
```

Optionnal fields (here the fields have their default values) :
```yaml
    # Debug values : ON / OFF
    debug: ON
    # Return mode
    return_mode: GET
    # Possible values for ctx_mode : TEST / PRODUCTION
    ctx_mode: TEST
    # Language
    language: fr
    # Success
    redirect_success_timeout: 1
    redirect_success_message: Redirection vers Les Annonces de la Seine dans quelques instants
    # Error
    redirect_error_timeout: 1
    redirect_error_message: Redirection vers Les Annonces de la Seine dans quelques instants
```

## How to use
### Controller

```php
    $systempay = $this->get('tlconseil.systempay')
        ->init()
        ->setOptionnalFields(array())
    ;
```
### Template
```html
    <div class="fa fa-spin fa-" font-style="">
        <form action="{{ paymentUrl }}" method="POST">
            {{ systempayForm(form) }}
        </form>
    </div>
```
