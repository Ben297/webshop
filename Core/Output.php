<?php


namespace Core;


class Output
{
    static function escapeOutput($data){
        return htmlspecialchars($data);
    }
}