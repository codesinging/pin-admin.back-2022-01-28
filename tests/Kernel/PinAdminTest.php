<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Exceptions\Exception;
use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class PinAdminTest extends TestCase
{
    public function testBaseMethods()
    {
        $admin = new PinAdmin();

        self::assertEquals(PinAdmin::VERSION, $admin->version());

        self::assertEquals(PinAdmin::BRAND, $admin->brand());

        self::assertEquals(PinAdmin::SLOGAN, $admin->slogan());

        self::assertEquals(PinAdmin::LABEL, $admin->label());
        self::assertEquals(PinAdmin::LABEL . '_user', $admin->label('user'));
        self::assertEquals(PinAdmin::LABEL . '-config', $admin->label('config', '-'));
    }

    public function testPackagePath()
    {
        $admin = new PinAdmin();

        self::assertEquals(dirname(__DIR__), $admin->packagePath('tests'));
        self::assertEquals(__DIR__, $admin->packagePath('tests', 'Kernel'));
    }

    public function testBasePath()
    {
        $admin = new PinAdmin();

        self::assertEquals(app_path(PinAdmin::DIRECTORY), $admin->basePath());
        self::assertEquals(app_path(PinAdmin::DIRECTORY . DIRECTORY_SEPARATOR . 'Admin'), $admin->basePath('Admin'));
        self::assertEquals(app_path(PinAdmin::DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers'), $admin->basePath('Admin', 'Controllers'));
    }

    public function testIndexes()
    {
        self::assertIsArray((new PinAdmin())->indexes());
    }

    public function testIsInstalled()
    {
        self::assertIsBool((new PinAdmin())->isInstalled());
    }

    /**
     * @throws Exception
     */
    public function testApplications()
    {
        $admin = new PinAdmin();

        self::assertEmpty($admin->applications());

        $admin->boot('admin');
        self::assertCount(1, $admin->applications());
        self::assertArrayHasKey('admin', $admin->applications());

        $admin->boot('user');
        self::assertCount(2, $admin->applications());
        self::assertArrayHasKey('user', $admin->applications());
    }

    /**
     * @throws Exception
     */
    public function testApplication()
    {
        $admin = new PinAdmin();
        $admin->boot('admin');
        self::assertInstanceOf(Application::class, $admin->application('admin'));
    }

    /**
     * @throws Exception
     */
    public function testBoot()
    {
        $admin = new PinAdmin();

        self::assertEmpty($admin->applications());

        $admin->boot('admin');
        self::assertCount(1, $admin->applications());
        self::assertArrayHasKey('admin', $admin->applications());
    }

    /**
     * @throws Exception
     */
    public function testCall()
    {
        $admin = new PinAdmin();
        $admin->boot('admin');

        self::assertEquals('admin', $admin->name());
        self::assertEquals(Application::BASE_DIRECTORY. DIRECTORY_SEPARATOR. 'Admin', $admin->directory());

        self::assertEquals('App\\PinAdmin\\Admin', $admin->getNamespace());
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers', $admin->getNamespace('Controllers'));
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers\\IndexController.php', $admin->getNamespace('Controllers', 'IndexController.php'));
    }
}
