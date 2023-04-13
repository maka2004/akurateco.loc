<?php
namespace app\components\interfaces;

interface ModelInterface
{
    public function rules();

    public function load(array $params);

    public function validate();
}