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
        new Tlconseil\SystempayBundle\SystempayBundle(),
    );
}
```

### Step 3 : Configure the bundle
