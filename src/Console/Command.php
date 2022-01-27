<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Console;

class Command extends \Illuminate\Console\Command
{
    /**
     * 输出一行标题信息
     *
     * @param string $title
     * @param string $prefix
     *
     * @return void
     */
    protected function title(string $title, string $prefix = '- ')
    {
        $this->line($prefix . $title);
    }
}