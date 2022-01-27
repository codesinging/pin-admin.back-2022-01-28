<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class AdminTest extends TestCase
{
    public function testFacades()
    {
        self::assertEquals(PinAdmin::LABEL, Admin::label());
        self::assertEquals(PinAdmin::VERSION, Admin::version());
    }
}
