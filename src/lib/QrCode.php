<?php
/**
 * 2014-08-17 @sarciszewski:
 * Because endroid/QrCode doesn't provide an autoloader, we'll do this the hard way.
 */

if (!function_exists('list_all_files')) {
    /**
     * List all the files in a directory (and subdirectories)
     *
     * @param string $folder - start searching here
     * @param string $extension - extensions to match
     * @return array
     */
    function list_all_files($folder, $extension = '*')
    {
        $dir = new \RecursiveDirectoryIterator($folder);
        $ite = new \RecursiveIteratorIterator($dir);
        if ($extension === '*') {
            $pattern = '/.*/';
        } else {
            $pattern = '/.*\.' . $extension . '$/';
        }
        $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
        $fileList = [];
        foreach($files as $file) {
            $fileList = \array_merge($fileList, $file);
        }
        return $fileList;
    }
}

foreach(list_all_files(__DIR__.'QrCode/src', 'php') as $i) {
    require_once($i);
}
