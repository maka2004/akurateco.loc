<?php

namespace app\components;

use app\components\interfaces\ModelInterface;

class Model implements ModelInterface
{
    private array $types = ['int', 'float', 'string', 'bool'];

    public array $errors = [];

    /**
     * Example:
     * [
     *  ['id', ['required', 'int'], ['default']],
     *  ['firstName', ['string', 'max' => 20]],
     *  ['middleName']
     * ]
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    public function load(array $params)
    {
        foreach ($this->rules() as $rule) {
            $fieldName = $rule[0];
            if (array_key_exists($fieldName, $params) && !empty($params[$fieldName])) {
                $this->$fieldName = $params[$fieldName];
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $rule) {
            if (is_array($rule) && isset($rule[1])) {
                $fieldName = $rule[0];
                $limits = $rule[1];

                foreach ($limits as $key => $limit) {
                    if (is_numeric($key)) {
                        if ('required' == $limit) {
                            // check if required
                            if (empty($this->$fieldName)) {
                                $this->errors []= "Field '$fieldName' is required";
                            }
                        } elseif (in_array($limit, $this->types)) {
                            // check type
                            if (isset($this->$fieldName)) {
                                if ('int' == $limit) {
                                    if (!is_int($this->$fieldName)) {
                                        $this->errors [] = "Field '$fieldName' should be of type integer";
                                    }
                                } elseif ('float' == $limit) {
                                    if (!is_float($this->$fieldName)) {
                                        $this->errors [] = "Field '$fieldName' should be of type float";
                                    }
                                } elseif ('string' == $limit) {
                                    if (!is_string($this->$fieldName)) {
                                        $this->errors [] = "Field '$fieldName' should be of type string";
                                    }
                                } elseif ('bool' == $limit) {
                                    if (!is_bool($this->$fieldName)) {
                                        $this->errors [] = "Field '$fieldName' should be of type bool";
                                    }
                                }
                            }
                        }
                    } elseif (is_string($key)) {
                        if (isset($this->$fieldName)) {
                            if ('min' == $key) {
                                // check min string length
                                if (strlen((string)$this->$fieldName) < $limit) {
                                    $this->errors [] = "Field '$fieldName' should be not shorter than $limit symbols";
                                }
                            } elseif ('max' == $key) {
                                // check max string length
                                if (strlen((string)$this->$fieldName) > $limit) {
                                    $this->errors [] = "Field '$fieldName' should be not longer than $limit symbols";
                                }
                            } elseif ('enum' == $key && is_array($limit)) {
                                // check enumeration rules
                                $badEnum = false;
                                foreach ($limit as $item) {
                                    if (!is_numeric($item) && !is_string($item)) {
                                        $this->errors [] = "Wrong rule on field '$fieldName' (bad enumerate)";
                                        $badEnum = true;
                                    }
                                }

                                // check enumeration
                                if (!$badEnum) {
                                    if (!in_array($this->$fieldName, $limit)) {
                                        $this->errors [] = "Field '$fieldName' should be one of listed in model";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getPropertiesArray(): array
    {
        $params = [];
        foreach ($this->rules() as $field) {
            $fieldName = $field[0];
            if (isset($this->$fieldName)) {
                $params[$fieldName] = $this->$fieldName;
            }
        }
        return $params;
    }
}