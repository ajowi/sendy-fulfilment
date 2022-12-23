<?php
/**
 * PesaPal REST Response
 */

namespace Ajowi\SendyFulfilment;

use Ajowi\SendyFulfilment\SendyRestRequest;

/**
 * Sendy REST Response
 */
class RestResponse
{
    /**
     * The embodied request object.
     *
     * @var SendyRestRequest
     */
    protected $request;

    /**
     * The data contained in the response.
     *
     * @var mixed
     */
    protected $response;

    /**
     * Response status code
     * @var integer
     */
    protected $statusCode;

    public function __construct(SendyRestRequest $request, $data, $statusCode = 200)
    {
        $this->request = $request;
        $this->response = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * Checks the status of the response
     */
    private function isSuccessful(): bool
    {
        return $this->response['status'] ?? false;
    }

    /**
     * Get the shipping cost
     */
    public function getCost()
    {
        if(array_key_exists('price_tiers', $this->getData())){
            $cost = 0;
            foreach($this->getData()['economy_price_tiers']['price_tiers'] as $tiers){
                $cost += $tiers['cost'];
            }

            return $cost;
        }

        if(array_key_exists('cost', $this->getData())){
            return $this->getData()['cost'];
        }
    }

    /**
     * Get the pricing UUID
     */
    public function getPricingUniqueIds()
    {
        if(array_key_exists('price_tiers', $this->getData())){
            $pricingUuids = array();
            foreach($this->getData()['economy_price_tiers']['price_tiers'] as $tiers){
                array_push($pricingUuids, $tiers['id']);
            }

            return $pricingUuids;
        }
        return $this->getData()['economy_price_tiers']['price_tiers']['id'];
    }

     /**
     * Get Sendy Confirmation Order number
     */
    public function getSendyOrderNumber()
    {
        return $this->getData()['order_no'] ?? null;
    }

     /**
     * Get Sendy Order tracking link
     */
    public function getTrackingLink()
    {
        return $this->getData()['tracking_link'] ?? null;
    }

     /**
     * Get Sendy Order tracking ID
     */
    public function getTrackingId()
    {
        return $this->getData()['id'] ?? null;
    }

     /**
     * Get rider for tracking an order
     */
    public function getRider()
    {
        return $this->getData()['rider'] ?? null;
    }

    /**
     * Get response data when Price Request is successful
     */

    public function getData()
    {
        if ($this->isSuccessful() && array_key_exists('data', $this->response)) {
            return $this->response['data'];
        }

        return array();
    }

    /**
     * Get API response message
     */
    public function getMessage()
    {
        if (array_key_exists('message', $this->response)) {
            return $this->response['message'];
        }

        return null;
    }

    /**
     * Get Http Response status code
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * Get Http Response status
     */
    public function getStatus()
    {
        return $this->response['status'];
    }

    /**
     * Get ecommerce merchant unique reference - Order Number
     */
    public function getEcommerceOrder()
    {
        if ($this->isSuccessful()) {
            if (array_key_exists('ecommerce_order', $this->getData())) {
                return $this->getData()['ecommerce_order'];
            }
            elseif (isset($this->getData()['details']['ecommerce_order'])) {
                return $this->getData()['details']['ecommerce_order'];
            }
        }
    }
}
