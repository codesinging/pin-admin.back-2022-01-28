<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin;

class PinAdmin
{
    /**
     * PinAdmin 标记
     */
    const LABEL = 'admin';

    /**
     * 获取 PinAdmin 标记
     * @return string
     */
    public function label(): string
    {
        return self::LABEL;
    }
}