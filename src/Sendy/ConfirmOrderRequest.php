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
 *   // DO NOT USE VALUES
 *   $data = new array(
 *              'pricing_uuid' => 'OdRsadd-0000',
 *              'payment_option' => 1,
 *              'carrier_type' => 0,
 *              'destination_paid_status' => true,
 *              'note' => 'Pick at the items at reception',
 *              'schedule_time' => '2021-10-4 12:10:45',
 *              'rider_phone' => '+254717266700',
 *              'waypoint_instructions' => [
 *                  [
 *                      'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
 *                      'recipient_phone' => -1.597429319708498,
 *                      'notes' => -1.597429319708498,
 *                      'order_items' => [{
 *                          'ref_no' => 'PKG1082198',
 *                          'checklist_items' => [{
 *                              'item_id' => 'ITM1082198',
 *                              'display_name' => 'Item name',
 *                              'quantity' => 10,
 *                              'display_img_link' => 'https://s3.com/sff',
 *                              'description' => 'PKG1082198',
 *                          }]
 *                      }]
 *                  ]
 *               ]
 *   );
 *
 * . $orderRequest = new PriceRequest();
 *   $orderRequest->initialize($data);
 *
 *   // Do a confirm order request
 *   try {
 *       $response = $orderRequest->send();
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
class ConfirmOrderRequest extends SendyRestRequest
{
    public function getData()
    {
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
        return parent::getEndpoint() . '/orders';
    }
}
