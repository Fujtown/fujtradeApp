<?php

namespace App\Helpers;

use App\Models\TapPaymentLink;

class UniqueNumberGenerator
{
    public static function generateUniqueRandomNumber()
    {
        // Your implementation here
        $isUnique = false;
        $randomNumber = 0;

        // Loop until a unique random number is found
        while (!$isUnique) {
            // Generate a random number within a range
            // You can adjust the range according to your needs
            $randomNumber = rand(100000, 999999);

            // Check if the number is unique in the database
            $isUnique = !TapPaymentLink::where('random_no', $randomNumber)->exists();
        }

        return $randomNumber;
    }
}
