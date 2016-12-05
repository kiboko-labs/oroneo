<?php

namespace Synolia\Bundle\OroneoBundle\Repository;

use Doctrine\ORM\EntityManager;
use Oro\Bundle\CatalogBundle\Entity\Category;

/**
 * Class CategoryRepository
 */
class CategoryRepository
{
    /** @var EntityManager */
    protected $entityManager;

    /**
     * ContactService constructor.
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @param string $akeneoCategoryCode
     * @return null|Category
     */
    public function getParentCategoryByAkeneoCategoryCode($akeneoCategoryCode)
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('c')
            ->from('OroCatalogBundle:Category', 'c')
            ->where('c.akeneoCategoryCode = :akeneoCategoryCode')
            ->setParameter('akeneoCategoryCode', $akeneoCategoryCode)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }
}
