<?php

namespace App\Helpers;

use App\Models\Transcation;
use App\Models\Wallet;

class UUIDGenerator
{
    public static function accountNumber()
    {
        $accountNumber = mt_rand(100000000000000000, 999999999999999999);
        if (Wallet::where('account_number', $accountNumber)->exists()) {
            return self::accountNumber();
        }
        return $accountNumber;
    }

    public static function ref_no()
    {
        $accountNumber = mt_rand(100000000000000000, 999999999999999999);
        if (Transcation::where('ref_no', $accountNumber)->exists()) {
            return self::ref_no();
        }
        return $accountNumber;
    }

    public static function trx_id()
    {
        $accountNumber = mt_rand(100000000000000000, 999999999999999999);
        if (Transcation::where('trx_id', $accountNumber)->exists()) {
            return self::trx_id();
        }
        return $accountNumber;
    }
}
