<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-01
 * Time: 12:01
 */
namespace Application\Models\Icon;

class Icon
{
    protected static $cssIconsFilePath = '/application/themes/aee/app/css/icomoon.css';
    protected static $iconList = [];

    public static function getMarkup($handle, $wrapper='<span class="%s"></span>')
    {
        return sprintf($wrapper, $handle);
    }

    /**
     * @return array
     */
    public static function getList() : array
    {
        $filePath = DIR_BASE . self::$cssIconsFilePath;
        $fh = fopen($filePath, 'r');
        while(!feof($fh)) {
            $line = fgets($fh);
            if(strpos($line, '.icon-') === 0) {
                $classname = str_replace(['.', ':before', ' ', '{', "\n"], ['', '', '', '', ''], $line);
                self::$iconList[$classname] = ucwords(str_replace(['icon-', '_', '-'], ['', ' ', ' '], $classname));
            }
        }
        asort(self::$iconList);
        return self::$iconList;
    }

}
