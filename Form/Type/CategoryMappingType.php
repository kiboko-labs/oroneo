<?php

namespace Synolia\Bundle\OroneoBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Synolia\Bundle\OroneoBundle\Service\OroFieldSelectService;
use Oro\Bundle\CatalogBundle\Entity\Category;

/**
 * Class CategoryMappingType
 * @package Synolia\Bundle\OroneoBundle\Form\Type
 */
class CategoryMappingType extends MappingType
{
    const NAME = 'synolia_Oroneo_category_mapping_type';

    /**
     * @var OroFieldSelectService $oroFieldChoices
     */
    protected $oroFieldChoices;

    /**
     * MappingType constructor.
     *
     * @param OroFieldSelectService $oroFieldChoices
     */
    public function __construct(OroFieldSelectService $oroFieldChoices)
    {
        $this->oroFieldChoices = $oroFieldChoices;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            MappingType::ORO_FIELD,
            'choice',
            [
                'choices' => $this->oroFieldChoices->getChoices(Category::class),
            ]
        );
    }
}
