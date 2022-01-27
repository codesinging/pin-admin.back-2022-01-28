<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\PinAdmin;
use CodeSinging\PinAdmin\Kernel\PinAdminServiceProvider;
use Tests\TestCase;

class PinAdminServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        self::assertInstanceOf(PinAdmin::class, app(PinAdmin::LABEL));
        self::assertEquals(app(PinAdmin::LABEL), app(PinAdmin::LABEL));
        self::assertSame(app(PinAdmin::LABEL), app(PinAdmin::LABEL));
    }
}
