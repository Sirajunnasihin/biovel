<?php

declare(strict_types=1);

namespace AKM\Biovel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool connect()
 * @method static void disconnect()
 * @method static bool isConnected()
 * @method static array getAttendance()
 *
 * @see \AKM\Biovel\Biovel
 */
class Biovel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'biovel';
    }
}
