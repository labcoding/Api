<?php

namespace LabCoding\Api\Action\Backend\LogEntryList;

use T4webDomainInterface\ServiceInterface;
use T4webInfrastructure\FinderAggregateRepository;

class Service implements ServiceInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    public function __construct(
        RepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function handle($criteria, $changes)
    {
        if (empty($criteria['limit'])) {
            $criteria['limit'] = 20;
        }
        if (!isset($criteria['offset']) && empty($criteria['page'])) {
            $criteria['page'] = 1;
        }
        if (empty($criteria['order'])) {
            $criteria['order'] = 'id DESC';
        }

        $criteria = $this->repository->createCriteria($criteria);

        $result = $this->repository->findMany($criteria);

        return $result;
    }
}