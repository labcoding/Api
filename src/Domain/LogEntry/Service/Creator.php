<?php

namespace LabCoding\Api\Domain\LogEntry\Service;

use T4webDomainInterface\Infrastructure\RepositoryInterface;
use T4webDomainInterface\EntityFactoryInterface;

class Creator
{

    /**
     * @var DataServiceInterface
     */
    private $dataService;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var EntityFactoryInterface
     */
    private $entityFactory;

    public function __construct(
        DataServiceInterface $dataService,
        RepositoryInterface $repository,
        EntityFactoryInterface $entityFactory
    )
    {
        $this->dataService = $dataService;
        $this->repository = $repository;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @return mixed
     */
    public function write()
    {
        $data = $this->dataService->getData();

        $entity = $this->entityFactory->create($data);
        $this->repository->add($entity);

        return $entity;
    }
}