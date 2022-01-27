<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use CodeSinging\PinAdmin\Exceptions\Exception;

/**
 * @method string name()
 * @method string directory(...$paths)
 * @method string path(...$paths)
 * @method string getNamespace(...$paths)
 * @method string routePrefix()
 * @method string link(string $path = '', array $parameters = [])
 */
class PinAdmin
{
    /**
     * PinAdmin 标记
     */
    const LABEL = 'admin';

    /**
     * PinAdmin 版本号
     */
    const VERSION = '0.0.1';

    /**
     * PinAdmin 品牌名称
     */
    const BRAND = 'PinAdmin';

    /**
     * PinAdmin 品牌 slogan
     */
    const SLOGAN = 'A Laravel package to rapidly build administrative application';

    /**
     * PinAdmin 应用根目录，相对于 `app`
     */
    const DIRECTORY = 'PinAdmin';

    /**
     * PinAdmin 应用索引文件
     */
    const INDEX_FILENAME = 'indexes.php';

    /**
     * 全部 PinAdmin 应用实例
     *
     * @var Application[]
     */
    protected array $applications = [];

    /**
     * 当前 PinAdmin 应用实例
     *
     * @var Application
     */
    protected Application $application;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 返回 PinAdmin 版本
     *
     * @return string
     */
    public function version(): string
    {
        return self::VERSION;
    }

    /**
     * 返回 PinAdmin 品牌名
     *
     * @return string
     */
    public function brand(): string
    {
        return self::BRAND;
    }

    /**
     * 返回 PinAdmin 的品牌 slogan
     *
     * @return string
     */
    public function slogan(): string
    {
        return self::SLOGAN;
    }

    /**
     * 获取 PinAdmin 标记
     *
     * @param string $suffix
     * @param string $separator
     *
     * @return string
     */
    public function label(string $suffix = '', string $separator = '_'): string
    {
        return self::LABEL . ($suffix ? $separator . $suffix : '');
    }

    /**
     * 返回 PinAdmin 包路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function packagePath(...$paths): string
    {
        array_unshift($paths, dirname(__DIR__, 2));
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 返回 PinAdmin 应用的基础路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function basePath(...$paths): string
    {
        array_unshift($paths, self::DIRECTORY);
        return app_path(implode(DIRECTORY_SEPARATOR, $paths));
    }

    /**
     * 返回应用索引数据
     *
     * @return array
     */
    public function indexes(): array
    {
        if ($this->isInstalled()) {
            return include($this->basePath(self::INDEX_FILENAME));
        }
        return [];
    }

    /**
     * 是否已经安装 PinAdmin 包
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return file_exists($this->basePath(self::INDEX_FILENAME));
    }

    /**
     * 返回所有已经加载的应用
     *
     * @return Application[]
     */
    public function applications(): array
    {
        return $this->applications;
    }

    /**
     * 返回当前应用或者指定名称的应用
     *
     * @param string|null $name
     *
     * @return Application
     */
    public function application(string $name = null): Application
    {
        if (is_null($name)) {
            return $this->application;
        }

        return $this->applications[$name] ?? $this->application;
    }

    /**
     * 启动指定名称的应用
     *
     * @param string $name
     *
     * @return PinAdmin
     * @throws Exception
     */
    public function boot(string $name): PinAdmin
    {
        $this->load($name);
        $this->application = $this->application($name);
        return $this;
    }

    /**
     * 加载指定名称的应用
     *
     * @throws Exception
     */
    protected function load(string $name)
    {
        if (empty($this->applications[$name])) {
            $this->applications[$name] = new Application($name);
        }
    }

    /**
     * 调用 PinAdmin 应用的方法
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->application->$name(...$arguments);
    }

    /**
     * 初始化所有 PinAdmin 应用
     *
     * @throws Exception
     */
    protected function init()
    {
        $indexes = $this->indexes();
        foreach ($indexes as $name => $options) {
            if ($options['status']) {
                $this->load($name);
            }
        }
    }
}