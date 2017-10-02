<?php
/**
 * Class Tree Format
 * @Author AJMstr
 * @date 2017-5-4
 */

class Tree {
    private static $_config = [
        'primaryKey' => 'id',
        'parentKey'  => 'pid',
        'leafKey'    => 'leaf',
        'childKey'   => 'child',
        'nameKey'    => 'name'
    ];

    private static $_icon = [
        ' │ ',
        ' ├ ',
        ' └ '
    ];

    private static $_nbsp = "    ";

    public static function format(array $data, $toHtml = false, array $option = []) {
        self::_initConfig($option);

        return $toHtml ?
            self::_lineToHtml(
                0, self::buildData($data)
            ) :
            self::_lineToTree(
                0, self::buildData($data)
            );
    }

    private static function _initConfig(array $option = []) {
        self::$_config = array_merge(self::$_config, $option);
    }

    private static function buildData(array $data) {
        extract(self::$_config);

        $return = [];
        foreach ($data as $key => $value) {
            $id = $value[$primaryKey];
            $parentId = $value[$parentKey];
            $value['pname'] = self::_genPname($parentId, $data);
            if($value['pname'] === false) continue;
            $return[$parentId][$id] = $value;
        }

        return $return;
    }

    private static function _genPname($parentId, array $data) {
        static $_formatedData = null;
        if(is_null($_formatedData)) {
            extract(self::$_config);
            foreach ($data as $index => $value) {
                $_formatedData[$value[$primaryKey]] = $value[$nameKey];
            }
        }

        return $parentId == 0 ? '根' : (isset($_formatedData[$parentId]) ? $_formatedData[$parentId] : false);
    }

    private static function _lineToTree($index, array $data) {
        extract(self::$_config);

        $tree = [];
        if(!empty($data[$index])){
            foreach ($data[$index] as $id => $node) {
                if(isset($data[$id])) {
                    $node[$leafKey] = false;
                    $node[$childKey] = self::_lineToTree($id, $data);

                } else {
                    $node[$leafKey] = true;
                }
                $tree[] = $node;
            }
        }

        return $tree;
    }

    private static function _lineToHtml($index, array $data, $level = 0) {
        extract(self::$_config);

        $tree = [];
        if(!empty($data[$index])){
            $pre = self::_pre($level);
            $total = count($data[$index]); $count = 0;
            foreach ($data[$index] as $id => $node) {
                $count++;
                    $node['display'] = $pre . self::$_nbsp . (($total == $count) ? self::$_icon['2'] : self::$_icon[1]). $node[$nameKey];
                $tree[] = $node;
                if(isset($data[$id])) {
                    $tree = array_merge($tree, self::_lineToHtml($id, $data, $level + 1));
                }
            }
        }

        return $tree;
    }

    private static function _pre($level = 0) {
        return str_repeat(self::$_nbsp . self::$_icon[0], $level);
    }
}