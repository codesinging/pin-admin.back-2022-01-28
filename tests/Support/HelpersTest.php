<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Support;

use CodeSinging\PinAdmin\Exceptions\Exception;
use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function testAdmin()
    {
        self::assertInstanceOf(PinAdmin::class, admin());
        self::assertSame(admin(), admin());
    }

    /**
     * @throws Exception
     */
    public function testAdminApp()
    {
        admin()->boot('admin');
        self::assertInstanceOf(Application::class, admin_app());
    }
}