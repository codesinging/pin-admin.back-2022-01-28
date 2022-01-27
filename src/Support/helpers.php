<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\PinAdmin;
use CodeSinging\PinAdmin\Kernel\Application as AdminApplication;
use Illuminate\Contracts\Foundation\Application;

if (!function_exists('admin')) {
    /**
     * @return Application|PinAdmin
     */
    function admin()
    {
        return app(PinAdmin::LABEL);
    }
}

if (!function_exists('admin_app')) {
    /**
     * @return AdminApplication
     */
    function admin_app(): AdminApplication
    {
        return admin()->application();
    }
}