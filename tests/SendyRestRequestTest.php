<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\SendyRestRequest;
use Ajowi\SendyFulfilment\ConfirmOrderRequest;
use Ajowi\SendyFulfilment\Tests\TestCase;

class SendyRestRequestTest extends TestCase
{
    public function testSend()
    {
        $merchantOrderNumber = "ORD-0000";
        $pricingUUID = "OdRsadd-0000";
        $status = true;
        $statusCode = 200;
        $order = $this->getDefaultOrderRequest($pricingUUID);
        $defaultResponse = $this->getDefaultOrderResponse($pricingUUID, $merchantOrderNumber, $status);
        $orderRequest = new SendyRestRequest($this->getEndpoint() . 'v2/orders', $this->getApiKey());
        $orderRequest->setHttpClient($this->getClient());
        $orderRequest->initialize($order);

        $this->mockRequest('POST', $orderRequest->getEndpoint(), $order, $defaultResponse);
        $response = $orderRequest->send();
        $data = $response->getData();

        $this->assertEquals($data['pricing_uuid'], $pricingUUID);
        $this->assertEquals($data['details']['ecommerce_order'], $merchantOrderNumber);
        $this->assertEquals($response->getCode(), $statusCode);
    }

    public function testInvalidSend()
    {
        $pricingUUID = "";
        $statusCode = 422;
        $order = $this->getDefaultOrderRequest($pricingUUID);
        $defaultResponse = array(
            "status" => true,
            "message" => "string"
            );
        $orderRequest = new SendyRestRequest($this->getEndpoint() . 'v2/orders', $this->getApiKey());
        $orderRequest->setHttpClient($this->getClient());
        $orderRequest->initialize($order);

        $this->mockRequest('POST', $orderRequest->getEndpoint(), $order, $defaultResponse, $statusCode);
        $response = $orderRequest->send();

        $this->assertEquals($response->getCode(), $statusCode);

    }

    public function testHasApiToken(): void
    {
        $restRequest = new SendyRestRequest($this->getEndpoint(), $this->getApiKey());
        $this->assertTrue($restRequest->hasApiKey());
    }

    public function testHasApiEndpoint(): void
    {
        $restRequest = new SendyRestRequest($this->getEndpoint(), $this->getApiKey());
        $this->assertTrue($restRequest->hasEndpoint());
    }

    public function getDefaultOrderRequest($pricingUUID){
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

    public function getDefaultResponseWithData(){
        return array(
            "status" => true,
            "message" => "Order placed successfully",
            "data" => [
              "order_no" => "AS137J382-9X7",
              "tracking_link" => "https://webapptest.sendyit.com/external/tracking/AS137J382-9X7",
            ]
          );
    }

    public function getDefaultOrderResponse($pricingUUID, $merchantOrderNumber, $status){
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

    public function getDefaultPriceRequest($ecommerceOrder){
        return  array(
            'ecommerce_order' => $ecommerceOrder,
                'recepient' => [
                    'name' => 'David Ajowi',
                    'email' => 'ajowi@daniche.co.ke',
                    'phone' => '+254 712345678'
                ],
                'locations' => [
                    [
                        'type' => 'PICKUP',
                        'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
                        'lat' => -1.597429319708498,
                        'long' => -1.597429319708498,
                        'name' => 'Destination'
                    ],
                    [
                        'type' => 'DELIVERY',
                        'waypoint_id' => 'd67dbff1-4d57-4266-9c39-481c2d9c76eq',
                        'lat' => -1.597429319708498,
                        'long' => -1.597429319708498,
                        'name' => 'Destination'
                    ]
                ]
        );
    }

    public function getDefaultCancelRequest($cancelId, $orderNumber)
    {
        return  array(
            'cancel_reason_id' => $cancelId,
            'reason_description' => 'Reason',
            'orderNumber' => $orderNumber
        );
    }

    public function getDefaultFetchOrderRequest($orderNumber)
    {
        return  array(
            'orderNumber' => $orderNumber
        );
    }

    public function getDefaultTrackOrderRequest($orderNumber)
    {
        return  array(
            'orderNumber' => $orderNumber
        );
    }

}
