<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        File::deleteDirectory(Admin::basePath());
    }

    public function testCreate()
    {
        $this->artisan('admin:create admin');
        self::assertDirectoryExists(Admin::basePath());
        self::assertFileExists(Admin::basePath(PinAdmin::INDEX_FILENAME));
        self::assertDirectoryExists(Admin::boot('admin')->path());
        self::assertFileExists(Admin::boot('admin')->path(Application::ROUTE_FILENAME));
        self::assertArrayHasKey('admin', Admin::indexes());
    }
}
