<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use CodeSinging\PinAdmin\Exceptions\Exception;
use Illuminate\Support\Str;

class Application
{

    /**
     * 应用基础目录，相对于 `app` 目录
     */
    const BASE_DIRECTORY = PinAdmin::DIRECTORY;

    /**
     * 应用路由文件名称
     */
    const ROUTE_FILENAME = 'routes.php';

    /**
     * 应用名称
     *
     * @var string
     */
    protected string $name;

    /**
     * 应用目录，相对于 `app` 目录
     *
     * @var string
     */
    protected string $direction;

    /**
     * @param string $name
     *
     * @throws Exception
     */
    public function __construct(string $name)
    {
        if (!$this->verifyName($name)){
            throw new Exception(sprintf('应用名称 [%s] 非法', $name));
        }

        $this->init($name);
    }

    /**
     * 验证是否合法应用名称
     *
     * @param string $name
     *
     * @return bool
     */
    protected function verifyName(string $name): bool
    {
        return !empty($name) && preg_match('/^[a-zA-Z]+\w*$/', $name) === 1;
    }

    /**
     * 初始化应用
     *
     * @param string $name
     *
     * @return void
     */
    protected function init(string $name)
    {
        $this->name = $name;
        $this->direction = self::BASE_DIRECTORY . DIRECTORY_SEPARATOR . Str::studly($name);
    }

    /**
     * 返回应用名称
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * 获取应用目录，相对于 `app` 目录
     *
     * @param ...$paths
     *
     * @return string
     */
    public function directory(...$paths): string
    {
        array_unshift($paths, $this->direction);
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 获取应用的路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function path(...$paths): string
    {
        return app_path($this->directory(...$paths));
    }

    /**
     * 获取应用的命名空间
     *
     * @param ...$paths
     *
     * @return string
     */
    public function getNamespace(...$paths): string
    {
        return implode('\\', ['App', str_replace('/', '\\', $this->directory(...$paths))]);
    }

    /**
     * 返回应用的路由前缀
     *
     * @return string
     */
    public function routePrefix(): string
    {
        return $this->name;
    }

    /**
     * 获取应用的链接地址，不包含域名的绝对链接
     *
     * @param string $path
     * @param array $parameters
     *
     * @return string
     */
    public function link(string $path = '', array $parameters = []): string
    {
        $link = '/' . $this->routePrefix();
        if ($path) {
            $link .= Str::start($path, '/');
        }
        if ($parameters) {
            $link .= '?' . http_build_query($parameters);
        }
        return $link;
    }
}