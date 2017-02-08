<?php

namespace LabCoding\Api\Action\Backend\Documentation;

use Zend\View\Model\JsonModel;

class ResultJsonViewModel extends JsonModel
{
    public function serialize()
    {
        $result = $this->getVariable('result', []);

        return $result;
    }
}
