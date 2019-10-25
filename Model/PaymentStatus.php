<?php

namespace Lone\SystempayBundle\Model;

class PaymentStatus {

    const ABANDONED = 'ABANDONED';
    const ACCEPTED = 'ACCEPTED';
    const AUTHORISED = 'AUTHORISED';
    const AUTHORISED_TO_VALIDATE = 'AUTHORISED_TO_VALIDATE';
    const CANCELLED = 'CANCELLED';
    const CAPTURED = 'CAPTURED';
    const CAPTURE_FAILED = 'CAPTURE_FAILED';
    const INITIAL = 'INITIAL';
    const NOT_CREATED = 'NOT_CREATED';
    const REFUSED = 'REFUSED';
    const SUSPENDED = 'SUSPENDED';
    const UNDER_VERIFICATION = 'UNDER_VERIFICATION';
    const WAITING_AUTHORISATION_TO_VALIDATE = 'WAITING_AUTHORISATION_TO_VALIDATE';
    const PENDING = 'PENDING';

    static function isValidStatus(string $status): bool {
        return in_array($status, [
            self::AUTHORISED, self::ACCEPTED
        ]);
    }

}
