<?php

namespace LabCoding\Api\Action\Backend\LogEntryList;

use T4web\Crud\Validator\BaseFilter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use LabCoding\Api\Domain\LogEntry\LogEntry;

class CriteriaValidator extends BaseFilter
{
    public function __construct()
    {
        $this->inputFilter = new InputFilter();

        $id = new Input('id');
        $id->setRequired(false);
        $id->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('GreaterThan', ['min' => 0]);
        $this->inputFilter->add($id);

        $resource = new Input('resource_like');
        $resource->setRequired(false);
        $resource->getFilterChain()
            ->attachByName('StringTrim');
        $resource->getValidatorChain()
            ->attachByName('StringLength', ['min' => 0, 'max' => 255]);
        $this->inputFilter->add($resource);

        $requestMethod = new Input('requestMethod_equalTo');
        $requestMethod->setRequired(false);
        $requestMethod->getValidatorChain()
            ->attachByName('InArray', [
                'haystack' => LogEntry::$allowedMethods
            ]);
        $this->inputFilter->add($requestMethod);

        $platform = new Input('platform_like');
        $platform->setRequired(false);
        $platform->getFilterChain()
            ->attachByName('StringTrim');
        $platform->getValidatorChain()
            ->attachByName('StringLength', ['min' => 0, 'max' => 255]);
        $this->inputFilter->add($platform);

        $responseCode = new Input('responseCode_equalTo');
        $responseCode->setRequired(false);
        $responseCode->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('InArray', [
                'haystack' => array_keys(LogEntry::$responseCodes)
            ]);
        $this->inputFilter->add($responseCode);

        $ip = new Input('ip_like');
        $ip->setRequired(false);
        $ip->getFilterChain()
            ->attachByName('StringTrim');
        $ip->getValidatorChain()
            ->attachByName('StringLength', ['min' => 0, 'max' => 255]);
        $this->inputFilter->add($ip);

        $createdDtLessThen = new Input('createdDt_lessThan');
        $createdDtLessThen->setRequired(false);
        $this->inputFilter->add($createdDtLessThen);

        $createdDtGreaterThan = new Input('createdDt_greaterThan');
        $createdDtGreaterThan->setRequired(false);
        $this->inputFilter->add($createdDtGreaterThan);

        $limit = new Input('limit');
        $limit->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('GreaterThan', ['min' => 0]);
        $limit->setRequired(false);
        $this->inputFilter->add($limit);

        $page = new Input('page');
        $page->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName('GreaterThan', ['min' => 0]);
        $page->setRequired(false);
        $this->inputFilter->add($page);
    }
}