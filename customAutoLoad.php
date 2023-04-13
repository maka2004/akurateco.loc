<?php
/**
 * @return void
 * @meta includes files in order set in $path_list
 */
function customAutoLoad() {

    $path_list = array(
        PROJECT_ROOT . '/components/',
        PROJECT_ROOT . '/models/',
        PROJECT_ROOT . '/controllers/'
    );

    foreach ($path_list as $path) {
        $files = getFolderContent($path);

        if (isset($files['interfaces'])) {
            foreach ($files['interfaces'] as $file) {
                include_once $file;
            }
        }

        if (isset($files['traits'])) {
            foreach ($files['traits'] as $file) {
                include_once $file;
            }
        }

        if (isset($files['class'])) {
            foreach ($files['class'] as $file) {
                include_once $file;
            }
        }
    }
}

/**
 * @param string $path
 * @return array
 * @meta recursive
 */
function getFolderContent($path)
{
    $files = scandir($path);

    $file_list = array();
    foreach ($files as $file) {
        if (is_dir($path . $file)) {
            if ('.' != substr($file, -1, 1)) {
                $file_list = array_merge_recursive($file_list, getFolderContent($path . $file . '/'));
            }
        } elseif (stripos($file, '.php') !== false) {
            $content = file_get_contents($path . $file);
            if (stripos($content, 'class') !== false) { // check for classes
                $file_list['class'] []= $path . $file;
            } elseif (stripos($content, 'interfaces') !== false) { // check for interfaces
                $file_list['interfaces'] []= $path . $file;
            } elseif (stripos($content, 'trait') !== false) { // check for traits
                $file_list['traits'] []= $path . $file;
            }
        }
    }

    return $file_list;
}

// register the loader
spl_autoload_register('customAutoLoad');