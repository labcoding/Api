<?php

namespace LabCoding\Api\ViewModel;

use Zend\View\Model\JsonModel;
use T4webDomain\Entity;
use Zend\Json\Json;

class ResultJsonViewModel extends JsonModel
{
    public function serialize()
    {
        $result = $this->getVariable('result', []);
        if($result instanceof \ArrayObject) {
            $result = [];
            foreach($this->getVariable('result') as $key => $entity) {
                $result[] = $this->prepareResult($entity);
            }
        }

        if($result instanceof Entity) {
            $result = $this->prepareResult($result);
        }

        $errors = array_merge((array)$this->getVariable('criteriaErrors'), (array)$this->getVariable('changesErrors'));

        if(!empty($errors)) {
            $result = [
                'data' => $this->getVariable('changes'),
                'errors' => $errors
            ];
        }

        return Json::encode((array)$result);
    }

    /**
     * @param Entity $result
     * @return array
     */
    public function prepareResult(Entity $result)
    {
        $data = $result->extract();

        if(isset($data['createdDt'])) {
            $data['createdDt'] = date("c", strtotime($data['createdDt']));
        }
        if(isset($data['updatedDt'])) {
            $data['updatedDt'] = date("c", strtotime($data['updatedDt']));
        }

        return $data;
    }

}
