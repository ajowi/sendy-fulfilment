<?php
/**
 * PesaPal REST Response
 */

namespace Ajowi\SendyFulfilment;

use Ajowi\SendyFulfilment\SendyRestRequest;

/**
 * PesaPal REST Response
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
    protected $data;
    protected $statusCode;

    public function __construct(SendyRestRequest $request, $data, $statusCode = 200)
    {
        $this->request = $request;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function isSuccessful(): bool
    {
        return $this->data['status'] ?? false;
    }

    /**
     * Get the shipping cost
     */
    public function getCost()
    {
        if(isset($this->getData()['economy_price_tiers']['price_tiers'])){
            $cost = 0;
            foreach($this->getData()['economy_price_tiers']['price_tiers'] as $tiers){
                $cost += $tiers['cost'];
            }

            return $cost;
        }

        return $this->getData()['cost'];
    }

    /**
     * Get the pricing UUID
     */
    public function getPricingUniqueIds()
    {
        if(isset($this->getData()['economy_price_tiers']['price_tiers'])){
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
        return $this->getData()['order_no'];
    }

     /**
     * Get Sendy Order tracking link
     */
    public function getTrackingLink()
    {
        return $this->getData()['tracking_link'];
    }

     /**
     * Get Sendy Order tracking ID
     */
    public function getTrackingId()
    {
        return $this->getData()['id'];
    }

     /**
     * Get rider for tracking an order
     */
    public function getRider()
    {
        return $this->getData()['rider'];
    }

    /**
     * Get response data when Price Request is successful
     */

    public function getData()
    {
        if ($this->isSuccessful()) {
            return $this->data['data'];
        }

        return $this->data;
    }

    /**
     * Get API response message
     */
    public function getMessage()
    {
        if (isset($this->data['message'])) {
            return $this->data['message'];
        }

        return null;
    }

    /**
     * Get Http Request status code
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * Get ecommerce merchant unique reference - Order Number
     */
    public function getEcommerceOrder()
    {
        if ($this->isSuccessful()) {
            if (isset($this->getData()['ecommerce_order'])) {
                return $this->getData()['ecommerce_order'];
            }
            elseif (isset($this->getData()['details']['ecommerce_order'])) {
                return $this->getData()['details']['ecommerce_order'];
            }
        }
    }
}
