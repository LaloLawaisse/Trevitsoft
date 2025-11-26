<?php

namespace App\Http\Controllers;

/**
 * Alias controller to reuse the existing account logic
 * for the legacy "payment-account" routes.
 */
class PaymentAccountController extends AccountController
{
    // No extra logic; inherits all behaviour from AccountController
}

