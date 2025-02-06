<?php

namespace App\Services;

use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Stripe;

class StripeService
{
    public function createDepositTxn(array $attributes): object
    {

        if ($attributes['currency'] != "usd" && $attributes['currency'] != "USD") {
            return (object) ['status' => 'error', 'message' => 'Our system only supports USD in Stripe'];
        }

        try {

            Stripe::setApiKey($attributes['secret_key']);

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items'           => [[
                    'price_data' => [
                        'currency'     => $attributes['currency'],
                        'unit_amount'  => $attributes['amount'] * 100,
                        'product_data' => [
                            'name'   => 'Deposit',
                            'images' => [$attributes['company_logo']],
                        ],
                    ],
                    'quantity'   => 1,
                ]],
                'mode'                 => 'payment',
                'success_url'          => $attributes['success_url'] . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => $attributes['cancel_url'] . '?session_id={CHECKOUT_SESSION_ID}',
            ]);

            if ($session->payment_status == "unpaid") {
                return (object) ['status' => 'success', 'data' => $session];
            } else {
                return (object) ['status' => 'error', 'message' => 'Something went wrong, please try again!'];
            }

        } catch (InvalidRequestException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (ApiErrorException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function checkValidSession(array $attributes): object
    {
        try {
            Stripe::setApiKey($attributes['secret_key']);

            $session = StripeSession::retrieve($attributes['session_id']);

            if ($session->payment_status == "unpaid") {
                return (object) ['status' => 'success', 'data' => $session];
            } else {
                return (object) ['status' => 'error', 'message' => 'Something went wrong, please try again!'];
            }

        } catch (InvalidRequestException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (ApiErrorException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function checkPaidSession(array $attributes): object
    {
        try {
            Stripe::setApiKey($attributes['secret_key']);

            $session = StripeSession::retrieve($attributes['session_id']);

            if ($session->payment_status == "paid") {
                return (object) ['status' => 'success', 'data' => $session];
            } else {
                return (object) ['status' => 'error', 'message' => 'Something went wrong, please try again!'];
            }

        } catch (InvalidRequestException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (ApiErrorException $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {

            return (object) ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

}
