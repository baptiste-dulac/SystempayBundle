# SystempayBundle
This bundle allows to implement a Payment Solution working with [SystemPay](https://paiement.systempay.fr/html/) for your symfony projet.
## Note
This bundle is not yet fully operationnal. Please do not use it ;)

## Installation
### Step 1 : Import using Composer
Using composer :
```json
{
    "require": {
        "baptiste-dulac/SystempayBundle": "master"
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
Available options :
```json
 # Debug values : ON / OFF
    debug: ON
    # Credentials
    site_id: XXXXX
    # Keys
    key_dev: XXXXX
    key_prod: XXXXX
    # Return
    url_return: http://www.example.com/payment_return
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
