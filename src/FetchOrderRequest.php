<?php
/**
 * Sendy Fetch Order Details
 */

namespace Ajowi\SendyFulfilment;


/**
 * Sendy Fetch Order Request
 *
 * ### Example
 *
 * <code>
 *   // Request body object
 *   // DO NOT USE VALUES -- substitute with your own
 *   $data = new array(
 *               'orderNumber' => 'SND-ORD-0000',
 *   );
 *
 * . $fetchRequest = new FetchOrderRequest();
 *   $fetchRequest->initialize($data);
 *
 *   // Do a fetch request
 *   try {
 *       $response = $fetchRequest->send();
 *       $data = $response->getData();
 *       echo "Response data == " . print_r($data, true) . "\n";
 *
 *       if ($response->isSuccessful()) {
 *           echo "Request was successful!\n";
 *       }
 *   } catch (\Exception $e) {
 *       echo "Message == " . $e->getMessage() . "\n";
 *   }
 * </code>
 *
 *
 * @link https://api.sendyit.com/v2/documentation
 */
class FetchOrderRequest extends SendyRestRequest
{
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get HTTP Method.
     *
     * The HTTP method for price request requests must be GET.
     * Using POST results in an error 500 from Sendy.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/orders/' . $this->data['orderNumber'] . '/order-paths';
    }
}
