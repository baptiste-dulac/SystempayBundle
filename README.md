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
First, you need to generate a payment form. All mandatory fields are used with their default value. You can configure all the common fields of your transactions in the `app/config/config.yml` file.
The method `->init()` allows you to specify the amount and the currency of the transaction.
The method `->setOptionnalFields(array())` allows you to specify any field for the System Pay Gateway.
```php
    $systempay = $this->get('tlconseil.systempay')
        ->init()
        ->setOptionnalFields(array())
    ;

    return array(
        'paymentUrl' => $systempay->getPaymentUrl(),
        'fields' => $systempay->getResponse(),
    );
```
### Template
```twig
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="widget widget-white text-center">
                <i class="fa fa-refresh fa-spin margin-top margin-bottom" style="font-size: 50px"></i>
                <h3>Redirection vers la page de paiement en cours...</h3>
                <form action="{{ paymentUrl }}" method="POST" id="systempay-form">
                    {{ systempayForm(fields) | raw }}
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById('systempay-form').submit();
    </script>
```
