<?php

namespace Botble\Ecommerce\Listeners;

use Botble\Ecommerce\Models\Customer;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Base\Facades\EmailHandler;
use Illuminate\Auth\Events\Registered;

class SendMailsAfterCustomerRegistered
{
    public function handle(Registered $event): void
    {
        $customer = $event->user;

        if (get_class($customer) == Customer::class) {
            try {
                EmailHandler::setModule(ECOMMERCE_MODULE_SCREEN_NAME)
                    ->setVariableValues([
                        'customer_name' => $customer->name,
                    ])
                    ->sendUsingTemplate('welcome', $customer->email);
            } catch (\Throwable $e) {
                // Log the email transport error but don't block registration
                logger()->error('[SendMailsAfterCustomerRegistered] Failed to send welcome email: ' . $e->getMessage(), [
                    'exception' => $e,
                    'customer_id' => $customer->id ?? null,
                    'email' => $customer->email ?? null,
                ]);
            }

            if (EcommerceHelper::isEnableEmailVerification()) {
                try {
                    $customer->sendEmailVerificationNotification();
                } catch (\Throwable $e) {
                    logger()->error('[SendMailsAfterCustomerRegistered] Failed to send verification email: ' . $e->getMessage(), [
                        'exception' => $e,
                        'customer_id' => $customer->id ?? null,
                        'email' => $customer->email ?? null,
                    ]);
                }
            }
        }
    }
}
