<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Middleware;

use CodeSinging\PinAdmin\Exceptions\Exception;
use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Auth\Middleware\Authenticate;

class Auth extends Authenticate
{
    public function handle($request, \Closure $next, ...$guards)
    {
        Admin::boot((string)array_shift($guards));
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * @throws Exception
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            throw new Exception('Not authenticated.');
        }

        return Admin::link('auth/login');
    }
}