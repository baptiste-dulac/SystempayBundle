# SystempayBundle
This bundle allows to implement a Payment Solution working with [SystemPay](https://paiement.systempay.fr/html/) for your symfony projet.
This payment solution uses Systempay. Systempay is a payment gateway proposed by the following bank companies :
* Banque Populaire (Cyberplus)
* Caisse d'épargne (SPPlus)

[![Total Downloads](https://poser.pugx.org/baptiste-dulac/systempay-bundle/downloads.svg)](https://packagist.org/packages/baptiste-dulac/systempay-bundle)
[![Latest Stable Version](https://poser.pugx.org/baptiste-dulac/systempay-bundle/v/stable.svg)](https://packagist.org/packages/baptiste-dulac/systempay-bundle)

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
#### Create a Transaction
To intantiate a new Transaction, you need to create an action in one of your controller and call the `tlconseil_systempay` serivce. All mandatory fields are used with their default value. You can configure all the common fields of your transactions in the `app/config/config.yml` file.

To see what fields are available see : [Systempay Documentation](https://www.ocl.natixis.com/systempay/public/uploads/fichier/Guide_d%27implementation_formulaire_Paiement20122013163915.pdf) (Chapter 2.3.1)

##### Service Method
* `init($currency = 978, $amount = 1000)` allows you to specify the amount and the currency of the transaction.
* `setOptionnalFields(array)` allows you to specify any field for the System Pay Gateway.

##### Example
```php
    /**
     * @Route("/initiate-payment/id-{id}", name="pay_online")
     * @Template()
     */
    public function payOnlineAction($id)
    {
        // ...
        $systempay = $this->get('tlconseil.systempay')
            ->init()
            ->setOptionnalFields(array(
                'shop_url' => 'http://www.example.com'
            ))
        ;

        return array(
            'paymentUrl' => $systempay->getPaymentUrl(),
            'fields' => $systempay->getResponse(),
        );
    }
```
#### Handle the response from the server
This route will be called by the Systempay service to update you about the payment status. This is the only way to correctly handle payment verfication.

##### Service Method
* `responseHandler(Request)` is used to update the transaction status (in database)

##### Example
```php
    /**
     * @Route("/payment/verification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paymentVerificationAction(Request $request)
    {
        // ...
        $this->get('tlconseil.systempay')
            ->responseHandler($request)
        ;

        return new Response();
    }
```

### Template
This is how the template for the `payOnlineAction()` may look like. You can use the `systempayForm` twig function to automatically generate the form based on the fields created in the service and returned by the `getResponse()` function.
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
