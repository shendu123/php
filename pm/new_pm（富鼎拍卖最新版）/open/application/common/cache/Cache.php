<?php
namespace app\common\cache;

use think\Db;
use app\common\model\Category;
use think\Loader;

class Cache
{
    /**redis
     * @var
     */
    protected static $redis;
    protected static $object = [];

    /**
     * Cache constructor.
     */
    public static function initalize()
    {
        if (is_null(self::$redis)) {
            self::$redis = \think\Cache::store('redis')->handler();
        }
    }

    /**设置缓存内容
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        self::initalize();
        self::$redis->set('cache:' . $key, $value);
    }

    /** 获取缓存内容
     * @param $key
     * @return bool
     */
    public static function get($key)
    {
        self::initalize();
        if (self::$redis->exists($key)) {
            return self::$redis->get($key);
        }
        return false;
    }

    /** 获取不同驱动的对象
     * @param $name
     * @param bool|false $bool
     * @return mixed
     * @throws Exception
     */
    public static function store($name, $bool = false)
    {
        try {
            $name = ucwords($name);
            $class = false !== strpos($name, '\\') ? $name : '\\app\\common\\cache\\driver\\' . $name;
            if ($class) {
                if ($bool) {
                    return new $class();
                }
                if (!isset(self::$object[$name]) || is_null(self::$object[$name])) {
                    self::$object[$name] = new $class();
                }
                return self::$object[$name];
            } else {
                throw new Exception("The cache file is not found", 1);
            }
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }
    }

    /** 筛选数据
     * @param array $list 二维数组
     * @param array $where 如： $where[] = ['字d段','运算符','值']
     * @param string $field 如：$field = 'id,name,age';
     * @return array
     */
    public static function filter(array $list, array $where, $field = '')
    {
        $field = $field ? explode(',', $field) : [];
        $result = [];
        foreach ($list as $id => $row) {
            if ($field) {
                $_row = [];
                foreach ($field as $key) {
                    if (isset($row[$key])) {
                        $_row[$key] = $row[$key];
                    }
                }
            } else {
                $_row = $row;
            }
            if ($where) {
                $flag = true;
                foreach ($where as $key => $val) {
                    if (!isset($row[$val[0]])) {
                        $flag = false;
                        break;
                    }
                    if (isset($val[2])) {
                        switch ($val[1]) {
                            case 'in':
                                $flag = in_array($_row[$val[0]], $val[2]);
                                break;
                            case '=':
                                break;
                            case '==':
                                $flag = $row[$val[0]] == $val[2];
                                break;
                            case '!=':
                                $flag = $row[$val[0]] != $val[2];
                                break;
                            case '>':
                                $flag = $row[$val[0]] > $val[2];
                                break;
                            case '>=':
                                $flag = $row[$val[0]] >= $val[2];
                                break;
                            case '<':
                                $flag = $row[$val[0]] < $val[2];
                                break;
                            case '<=':
                                $flag = $row[$val[0]] <= $val[2];
                                break;
                            case 'like':
                                $bool = strstr($row[$val[0]], $val[2]);
                                if (empty($bool)) {
                                    $flag = false;
                                    break;
                                }
                                $flag = true;
                                break;
                            default:
                                $flag = false;
                                break;
                        }
                    } else {
                        if (isset($val[1])) {
                            $flag = $row[$val[0]] == $val[1];
                        }
                    }
                    if (!$flag) {
                        break;
                    }
                }
                if ($flag) {
                    $result[$id] = $_row;
                }
            } else {
                $result[$id] = $_row;
            }
        }
        return $result;
    }

    /** 缓存分页
     * @param array $list
     * @param $page
     * @param $pageSize
     * @return array
     */
    public static function page(array $list, $page, $pageSize)
    {
        $j = 0;
        $new_array = [];
        $start = !empty($page) ? intval($page) - 1 : 0;
        $start = intval($start) * intval($pageSize);
        $end = intval($start) + intval($pageSize);
        foreach ($list as $k => $v) {
            $j++;
            if ($start == 0) {
                if ($j >= $start && $j < ($end + 1)) {
                    array_push($new_array, $v);
                }
            } else {
                if ($j > $start && $j < ($end + 1)) {
                    array_push($new_array, $v);
                }
            }
        }
        return $new_array;
    }

    /**
     * 返回redis对象
     */
    public static function handler()
    {
        self::initalize();
        return self::$redis;
    }
}