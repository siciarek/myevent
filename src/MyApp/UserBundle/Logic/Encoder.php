<?php
namespace MyApp\UserBundle\Logic;

class Encoder
{
    public static function encode($string) {
        return md5($string);
    }
}
