<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string version()
 * @method static string brand()
 * @method static string slogan()
 * @method static string label(string $suffix = '', string $separator = '_')
 * @method static string packagePath(...$paths)
 * @method static string basePath(...$paths)
 * @method static array indexes()
 * @method static boolean isInstalled()
 * @method static Application[] applications()
 * @method static Application application(string $name = null)
 * @method static Application boot(string $name = null)
 * @method static string name()
 * @method static string directory(...$paths)
 * @method static string path(...$paths)
 * @method static string getNamespace(...$paths)
 * @method static string routePrefix()
 * @method static string link(string $path = '', array $parameters = [])
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PinAdmin::LABEL;
    }
}