<?php
/**
 * Sendy REST Price Request
 */

namespace Ajowi\SendyFulfilment;


/**
 * Sendy REST Price Request
 *
 * ### Example
 *
 * <code>
 *   // Request body object
 *   // DO NOT USE VALUES -- substitute with your own
 *   $data = new array(
 *               'ecommerce_order' => 'ODR-0000',
 *               'recepient' => [
 *                      'name' => 'David Ajowi',
 *                      'email' => 'ajowi@daniche.co.ke',
 *                      'phone' => '+254 712345678'
 *               ],
 *               'locations' => [
 *                  [
 *                      'type' => 'PICKUP',
 *                      'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
 *                      'lat' => -1.597429319708498,
 *                      'long' => -1.597429319708498,
 *                      'name' => 'Destination'
 *                  ],
 *                  [
 *                      'type' => 'DELIVERY',
 *                      'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
 *                      'lat' => -1.597429319708498,
 *                      'long' => -1.597429319708498,
 *                      'name' => 'Destination'
 *                  ]
 *               ]
 *   );
 *
 * . $priceRequest = new PriceRequest();
 *   $priceRequest->initialize($data);
 *
 *   // Do a price request
 *   try {
 *       $response = $priceRequest->send();
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
class PriceRequest extends SendyRestRequest
{
    public function getData()
    {
        $this->data = parent::getData();
        return $this->data;
    }

    /**
     * Get HTTP Method.
     *
     * The HTTP method for price request requests must be GET.
     * Using POST results in an error 500 from PesaPal.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . '/price-request';
    }
}
