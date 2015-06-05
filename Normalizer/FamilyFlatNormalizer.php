<?php

namespace Pim\Bundle\EnhancedConnectorBundle\Normalizer;

use Pim\Bundle\CatalogBundle\Manager\LocaleManager;
use Pim\Bundle\CatalogBundle\Model\FamilyInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class FamilyFlatNormalizer
 *
 * @author    Damien Carcel <damien.carcel@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FamilyFlatNormalizer implements NormalizerInterface
{
    /** @var LocaleManager */
    protected $localeManager;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var NormalizerInterface */
    protected $transNormalizer;

    /**
     * @param NormalizerInterface $transNormalizer
     * @param SerializerInterface $serializer
     * @param LocaleManager       $localeManager
     */
    public function __construct(
        NormalizerInterface $transNormalizer,
        SerializerInterface $serializer,
        LocaleManager $localeManager
    ) {
        $this->transNormalizer = $transNormalizer;
        $this->serializer      = $serializer;
        $this->localeManager   = $localeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($family, $format = null, array $context = [])
    {
        $normalizedFamily = ['code' => $family->getCode()];

        $familyLabels = $this->transNormalizer->normalize($family);
        foreach ($familyLabels['label'] as $locale => $label) {
            $normalizedFamily['label-' . $locale] = $label;
        }

        return $this->serializer->serialize(
            $normalizedFamily,
            $format,
            array(
                'delimiter'     => $context['delimiter'],
                'enclosure'     => $context['enclosure'],
                'withHeader'    => $context['withHeader'],
                'heterogeneous' => false,
                'locales'       => $this->localeManager->getActiveCodes(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($family, $format = null)
    {
        return $family instanceof FamilyInterface;
    }
}
