<?php

namespace tourze\workerman\yii2\async;

use tourze\workerman\yii2\Application;
use Yii;

/**
 * 使用
 *
 * @package tourze\workerman\yii2\async
 */
class Task
{

    /**
     * 打包数据
     *
     * @param string $function
     * @param array $params
     * @return string
     */
    public static function packData($function, $params)
    {
        $data = serialize([$function, $params]);
        return $data;
    }

    /**
     * 解包数据
     *
     * @param string $data
     * @return mixed
     */
    public static function unpackData($data)
    {
        return unserialize($data);
    }

    /**
     * 增加异步执行任务
     * 每个task有大概0.2-0.5ms的开销
     *
     * @param string $function
     * @param array  $params
     * @return int
     * @throws \tourze\workerman\yii2\async\Exception
     */
    public static function addTask($function, $params = [])
    {
        $data = [$function, $params];

        self::runTask($data, 0);
        return 0;
    }

    /**
     * 执行任务
     *
     * @param string $data
     * @param int $taskId
     */
    public static function runTask($data, $taskId)
    {
        //$data = self::unpackData($data);
        $function = array_shift($data);
        //echo "$taskId Run task: $function\n";
        $params = array_shift($data);
        call_user_func_array($function, $params);
    }
}
