<?php
    namespace app;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    use app\controllers\BaseController;
    use Exception;

    define('PROJECT_ROOT', __DIR__);

    require_once 'customAutoLoad.php';
    require_once 'base_functions.php';

    // run user's script
    $baseController = new BaseController();

    try {
        $baseController->actionIndex();
    } catch (Exception $e) {
        dd($e->getMessage());
    }

    return true;