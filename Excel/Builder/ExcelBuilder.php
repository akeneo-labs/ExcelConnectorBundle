<?php

namespace Pim\Bundle\ExcelConnectorBundle\Excel\Builder;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Excel builder for single tabbed files
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ExcelBuilder extends AbstractExcelBuilder
{
    /**
     * {@inheritdoc}
     */
    protected function getWorksheetName(array $data)
    {
        return $this->options['worksheet_name'];
    }

    /**
     * {@inheritdoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(['worksheet_name' => 'EXPORT']);
    }
}
