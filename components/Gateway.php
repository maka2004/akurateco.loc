<?php
namespace app\components;


class Gateway
{
    public function getInnerParams($outerParams)
    {
        $response = [];
        foreach ($this->getParamsIn() as $innerFieldName => $outerFieldName) {
            if (isset($outerParams->$outerFieldName)) {
                $response[$innerFieldName] = $outerParams->$outerFieldName;
            }
        }
        return $response;
    }

    /**
     * return juxtaposition:
     * 'inner_field_name' => 'payment_gateway_field_name'
     *
     * @return string[]
     */
    public function getParamsIn(): array
    {
        return [];
    }
}