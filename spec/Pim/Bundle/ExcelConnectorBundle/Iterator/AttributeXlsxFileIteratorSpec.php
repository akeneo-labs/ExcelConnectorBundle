<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AttributeXlsxFileIteratorSpec extends XlsxFileIteratorBehavior
{
    public function let(ContainerInterface $container)
    {
        parent::let($container);
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
                'sort_order' => "1",
                'unique' => "1",
                'searchable' => "1",
                'useable_as_grid_column' => "1",
                'useable_as_grid_filter' => "1",
            ],
            [
                'code' => 'name',
                'label-en_US' => 'Name',
                'type' => 'pim_catalog_text',
                'group' => 'global',
                'sort_order' => "2",
                'searchable' => "1",
                'useable_as_grid_column' => "1",
                'useable_as_grid_filter' => "1",
            ],
            [
                'code' => 'type',
                'label-en_US' => 'Type',
                'type' => 'pim_catalog_multiselect',
                'group' => 'global',
                'sort_order' => '3',
                'searchable' => '1',
                'localizable' => '1',
                'locales' => 'fr_FR',
                'scopable' => '1',
                'useable_as_grid_column' => '1',
                'useable_as_grid_filter' => '1',
            ],
            [
                'code' => 'description',
                'label-en_US' => 'Description',
                'type' => 'pim_catalog_textarea',
                'group' => 'global',
                'sort_order' => '4',
                'useable_as_grid_column' => '1',
                'max_characters' => '100'
            ],
        ];

        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
