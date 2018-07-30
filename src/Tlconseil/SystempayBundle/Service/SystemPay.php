<?php

namespace Tlconseil\SystempayBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Tlconseil\SystempayBundle\Entity\Transaction;

/**
 * Class SystemPay
 * @package Tlconseil\SystempayBundle\Service
 */
class SystemPay
{
    /**
     * @var string
     */
    private $paymentUrl = 'https://systempay.cyberpluspaiement.com/vads-payment/';

    /**
     * @var array
     */
    private $mandatoryFields = array(
        'action_mode' => null,
        'ctx_mode' => null,
        'page_action' => null,
        'payment_config' => null,
        'site_id' => null,
        'version' => null,
        'redirect_success_message' => null,
        'redirect_error_message' => null,
        'url_return' => null,
    );

    /**
     * @var string
     */
    private $key;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        foreach ($this->mandatoryFields as $field => $value)
            $this->mandatoryFields[$field] = $container->getParameter(sprintf('tlconseil_systempay.%s', $field));
        if ($this->mandatoryFields['ctx_mode'] == "TEST")
            $this->key = $container->getParameter('tlconseil_systempay.key_dev');
        else
            $this->key = $container->getParameter('tlconseil_systempay.key_prod');

    }

    /**
     * @param $currency
     * @param $amount
     * @return Transaction
     */
    private function newTransaction($currency, $amount)
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setCurrency($currency);
        $transaction->setCreatedAt(new \DateTime());
        $transaction->setUpdatedAt(new \DateTime());
        $transaction->setPaid(false);
        $transaction->setRefunded(false);
        $transaction->setStatus("");
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
        return $transaction;
    }

    /**
     * @param int $currency
     * Euro => 978
     * US Dollar => 840
     * @param int $amount
     * Use int :
     * 10,28 € = 1028
     * 95 € = 9500
     * @return $this
     */
    public function init($currency = 978, $amount = 1000)
    {
        $this->transaction = $this->newTransaction($currency, $amount);
        $this->mandatoryFields['amount'] = $amount;
        $this->mandatoryFields['currency'] = $currency;
        $this->mandatoryFields['trans_id'] = sprintf('%06d', $this->transaction->getId());
        $this->mandatoryFields['trans_date'] = gmdate('YmdHis');
        return $this;
    }

    /**
     * @param $fields
     * remove "vads_" prefix and form an array that will looks like :
     * trans_id => x
     * cust_email => xxxxxx@xx.xx
     * @return $this
     */
    public function setOptionnalFields($fields)
    {
        foreach ($fields as $field => $value)
            if (empty($this->mandatoryFields[$field]))
                $this->mandatoryFields[$field] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        $this->mandatoryFields['signature'] = $this->getSignature();
        return $this->mandatoryFields;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function responseHandler(Request $request)
    {
        $query = $request->request->all();

        // Check signature
        if (!empty($query['signature']))
        {
            $signature = $query['signature'];
            unset ($query['signature']);
            if ($signature == $this->getSignature($query))
            {
                $transaction = $this->findTransaction($request);
                $transaction->setStatus($query['vads_trans_status']);
                if ($query['vads_trans_status'] == "AUTHORISED")
                    $transaction->setPaid(true);
                $transaction->setUpdatedAt(new \DateTime());
                $transaction->setLogResponse(json_encode($query));
                $this->entityManager->flush();
                return true;
            }
        }
        return false;
    }
    
    /**
     * @return Transaction
     */
    public function findTransaction(Request $request)
    {
        $query = $request->request->all();
        $this->transaction = $this->entityManager->getRepository('TlconseilSystempayBundle:Transaction')->find($query['vads_trans_id']);
        
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param array $fields
     * @return array
     */
    private function setPrefixToFields(array $fields)
    {
        $newTab = array();
        foreach ($fields as $field => $value)
            $newTab[sprintf('vads_%s', $field)] = $value;
        return $newTab;
    }

    /**
     * @param null $fields
     * @return string
     */
    private function getSignature($fields = null)
    {
        if (!$fields)
            $fields = $this->mandatoryFields = $this->setPrefixToFields($this->mandatoryFields);
        ksort($fields);
        $contenu_signature = "";
        foreach ($fields as $field => $value)
                $contenu_signature .= $value."+";
        $contenu_signature .= $this->key;
        $signature = sha1($contenu_signature);
        return $signature;
    }
}
