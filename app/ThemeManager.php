<?php


namespace App;


class ThemeManager
{

    public static function activeTheme(): Theme
    {
        return new Theme(config('cms.theme'));
    }
}