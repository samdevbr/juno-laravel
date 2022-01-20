<?php
namespace Juno\Support\Services;

use Juno\Services\AuthService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isAuthorized()
 * @method static bool authorize()
 * @method static string getToken()
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuthService::class;
    }
}
