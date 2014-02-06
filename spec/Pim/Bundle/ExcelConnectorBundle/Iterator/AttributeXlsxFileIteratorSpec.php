<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper;

class AttributeXlsxFileIteratorSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $helper = new ExcelHelper;
        $container->get('pim_excel_connector.excel.helper')->willReturn($helper);
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/init.xlsx',
            [
                'label_row' => 6,
                'data_row' => 7,
                'skip_empty' => true,
                'include_worksheets' => [ '/^family/' ]
            ]
        );
        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\AttributeXlsxFileIterator');
    }

    public function it_reads_attributes()
    {
        $this->rewind();
        $values = [
            [
                'code' => 'sku',
                'label-en_US' => 'Code article',
                'type' => 'pim_catalog_identifier',
                'group' => 'global',
                'sort_order' => (float) 1,
                'unique' => (float) 1,
                'searchable' => (float) 1,
                'useable_as_grid_column' => (float) 1,
                'useable_as_grid_filter' => (float) 1,
            ],
            [
                'code' => 'name',
                'label-en_US' => 'Name',
                'type' => 'pim_catalog_text',
                'group' => 'global',
                'sort_order' => (float) 2,
                'searchable' => (float) 1,
                'useable_as_grid_column' => (float) 1,
                'useable_as_grid_filter' => (float) 1,
            ],
            [
                'code' => 'type',
                'label-en_US' => 'Type',
                'type' => 'pim_catalog_multiselect',
                'group' => 'global',
                'sort_order' => (float) 3,
                'searchable' => (float) 1,
                'localizable' => (float) 1,
                'locales' => 'fr_FR',
                'scopable' => (float) 1,
                'useable_as_grid_column' => (float) 1,
                'useable_as_grid_filter' => (float) 1,
            ],
            [
                'code' => 'description',
                'label-en_US' => 'Description',
                'type' => 'pim_catalog_textarea',
                'group' => 'global',
                'sort_order' => (float) 4,
                'useable_as_grid_column' => (float) 1,
                'max_characters' => (float) 100
            ],
        ];

        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
