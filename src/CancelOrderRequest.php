<?php
/**
 * Sendy Cancel Order
 */

namespace Ajowi\SendyFulfilment;


/**
 * Sendy Cancel Order Request
 *
 * ### Example
 *
 * <code>
 *   // Request body object
 *   // DO NOT USE VALUES -- substitute with your own
 *   $data = new array(
 *               'cancel_reason_id' => 1,
 *               'reason_description' => 'Reason',
 *               'orderNumber' => 'dshdfjdf'
 *   );
 *
 * . $priceRequest = new PriceRequest();
 *   $priceRequest->initialize($data);
 *
 *   // Do a cancel request
 *   try {
 *       $response = $cancelRequest->send();
 *       $data = $response->getData();
 *       echo "Response data == " . print_r($data, true) . "\n";
 *
 *       if ($response->isSuccessful()) {
 *           echo "Cancel operation was successful!\n";
 *       }
 *   } catch (\Exception $e) {
 *       echo "Message == " . $e->getMessage() . "\n";
 *   }
 * </code>
 *
 *
 * @link https://api.sendyit.com/v2/documentation
 */
class CancelOrderRequest extends SendyRestRequest
{
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get HTTP Method.
     *
     * The HTTP method for cancelling order requests must be POST.
     * Using GET results in an error 500 from Sendy.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/orders/' . $this->getData()['orderNumber'] . '/cancel';
    }
}
