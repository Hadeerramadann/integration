<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class paymentcontroller extends Controller
{
    // 
     function cURL($url, $json)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    public function payment(Request $request)
    {
        // return "jjj";
       $api_key=$request->api_key;

       $json = [
        'api_key' => $api_key,
    ];

    // Send curl
    $auth = $this->cURL(
        'https://accept.paymob.com/api/auth/tokens',
        $json
    );

    return $auth;
    }
     
    public function makeOrderPaymob(Request $request)
    {
        $token=$request->token;
        $merchant_id=$request->merchant_id;
        $amount_cents=$request->amount_cents;
        $merchant_order_id=$request->merchant_order_id;



        // Request body
        $json = [
            'merchant_id'            => $merchant_id,
            'amount_cents'           => $amount_cents,
            'merchant_order_id'      => $merchant_order_id,
            'currency'               => 'EGP',
            'notify_user_with_email' => true
        ];

        // Send curl
        $order = $this->cURL(
            'https://accept.paymobsolutions.com/api/ecommerce/orders?token='.$token,
            $json
        );

        return $order;
    }

    public function getPaymentKeyPaymob(Request $request) {
        $token=$request->token;
        $integration_id=$request->integration_id;
        $amount_cents=$request->amount_cents;
        $order_id=$request->order_id;

        $email   = 'null';
        $fname   = 'null';
        $lname   = 'null';
        $phone   = 'null';
        $city    = 'null';
        $country = 'null';
      // Request body
      $json = [
          'amount_cents' => $amount_cents,
          'expiration'   => 36000,
          'order_id'     => $order_id,
          "billing_data" => [
              "email"        => $email,
              "first_name"   => $fname,
              "last_name"    => $lname,
              "phone_number" => $phone,
              "city"         => $city,
              "country"      => $country,
              'street'       => 'null',
              'building'     => 'null',
              'floor'        => 'null',
              'apartment'    => 'null'
          ],
          'currency'            => 'EGP',
          'card_integration_id' => $integration_id
      ];

      // Send curl
      $payment_key = $this->cURL(
          'https://accept.paymobsolutions.com/api/acceptance/payment_keys?token='.$token,
          $json
      );

      return $payment_key;
  }

}
