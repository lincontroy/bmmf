<?php

namespace Modules\Merchant\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThanNow implements Rule
{
    public function passes($attribute, $value)
    {
        // Convert the value to a DateTime object
        $dateTimeValue = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        // Check if the datetime is greater than the current datetime
        return $dateTimeValue > now();
    }

    public function message()
    {
        return 'The :attribute must be greater than the current date and time.';
    }
}
