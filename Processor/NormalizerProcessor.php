<?php

namespace Pim\Bundle\ExcelConnectorBundle\Processor;

use Akeneo\Component\Batch\Item\AbstractConfigurableStepElement;
use Akeneo\Component\Batch\Item\ItemProcessorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Processor encoding the data for a specific format
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class NormalizerProcessor extends AbstractConfigurableStepElement implements ItemProcessorInterface
{
    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var array
     */
    protected $context;

    /**
     * Constructor
     *
     * @param NormalizerInterface $normalizer
     * @param string              $format
     * @param array               $context
     */
    public function __construct(NormalizerInterface $normalizer, $format, array $context = array())
    {
        $this->normalizer = $normalizer;
        $this->format = $format;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurationFields()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function process($item)
    {
        return $this->normalizer->normalize($item, $this->format, $this->context);
    }
}
