<?php

namespace App\Models;

class Return
{
    public static function content($data, $type = false)
    {
        $ret = array(
            'ret' => array(),
            'err' => array(),
            'type' => $type
        );

        ($type) ? $ret['ret'] = $data : $ret['err'] = $data;

        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }
}