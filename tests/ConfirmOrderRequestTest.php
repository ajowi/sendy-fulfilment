<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\ConfirmOrderRequest;
use Ajowi\SendyFulfilment\Exceptions\RequestException;
use Ajowi\SendyFulfilment\Tests\TestCase;


class ConfirmOrderRequestTest extends TestCase
{

    public function testValidSend()
    {
        $merchantOrderNumber = "ORD-0000";
        $pricingUUID = "OdRsadd-0000";
        $status = true;
        $order = $this->getDefaultOrderRequest($pricingUUID);
        $defaultResponse = $this->getDefaultOrderResponse($pricingUUID, $merchantOrderNumber, $status);
        $orderRequest = new ConfirmOrderRequest('https://api.sendyit.com/v2/orders', 'KEY');
        $orderRequest->setHttpClient($this->getClient());
        //$orderRequest->initialize($order);
        $this->mockRequest('POST', $orderRequest->getEndpoint(), $order, $defaultResponse);
        $response = $orderRequest->send();
        $data = $response->getData();
        $this->assertEquals($data['data']['pricing_uuid'], $pricingUUID);
        $this->assertEquals($data['data']['details']['ecommerce_order'], $merchantOrderNumber);
        $this->assertEquals($data['status'], $status);
    }

    public function testInvalidSend()
    {
        $merchantOrderNumber = "ORD-0000";
        $pricingUUID = "OdRsadd-0000";
        $status = false;
        $order = $this->getDefaultOrderRequest($pricingUUID);
        $defaultResponse = $this->getDefaultOrderResponse($pricingUUID, $merchantOrderNumber, $status);
        $orderRequest = new ConfirmOrderRequest('https://api.sendyit.com/v2/orders', 'KEY');
        $orderRequest->setHttpClient($this->getClient());
        //$orderRequest->initialize($order);
        $this->mockRequest('POST', $orderRequest->getEndpoint(), $order, $defaultResponse);
        $response = $orderRequest->send();
        $data = $response->getData();
        $this->assertEquals($data['status'], $status);

    }

    private function getDefaultOrderRequest($pricingUUID){
        return  array(
                    'pricing_uuid' => $pricingUUID,
                    'payment_option' => 1,
                    'carrier_type' => 0,
                    'destination_paid_status' => true,
                    'note' => 'Pick at the items at reception',
                    'schedule_time' => '2021-10-4 12:10:45',
                    'rider_phone' => '+254717266700',
                    'waypoint_instructions' => [
                        [
                            'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
                            'recipient_phone' => -1.597429319708498,
                            'notes' => -1.597429319708498,
                            'order_items' => [
                                'ref_no' => 'PKG1082198',
                                'checklist_items' => [
                                    'item_id' => 'ITM1082198',
                                    'display_name' => 'Item name',
                                    'quantity' => 10,
                                    'display_img_link' => 'https://s3.com/sff',
                                    'description' => 'PKG1082198',
                                ]
                            ]
                        ]
                    ]
               );
    }

    private function getDefaultOrderResponse($pricingUUID, $merchantOrderNumber, $status){
        return array(
            "status" => $status,
            "message" => "Order placed successfully",
            "data" => [
              "order_no" => "AS137J382-9X7",
              "pricing_uuid" => $pricingUUID,
              "tracking_link" => "https://webapptest.sendyit.com/external/tracking/AS137J382-9X7",
              "details" => [
                "ecommerce_order" => $merchantOrderNumber
                ],
              "time_predictions" => [
                "eta" => "2021-10-4 12:10:45"
                ]
            ]
          );
    }

}
