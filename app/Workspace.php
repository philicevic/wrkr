<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yaml;

class Workspace extends Model
{
    private static $workspace = null;

    public static function init() {
        self::$workspace = Yaml::parse(file_get_contents(base_path() . "/workspace.yaml"));
    }

    public static function categories() {
        return self::$workspace['categories'];
    }

    public static function path() {
        return self::$workspace['path'];
    }
}

Workspace::init();
