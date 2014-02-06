<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pim\Bundle\ExcelConnectorBundle\Excel\ExcelHelper;

class FamilyXlsxFileIteratorSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $helper = new ExcelHelper;
        $container->get('pim_excel_connector.excel.helper')->willReturn($helper);
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/init.xlsx',
            [
              'family_label_row'    =>   5,
              'attribute_label_row' => 6,
              'attribute_data_row'  => 7,
              'code_row'            => 2,
              'code_column'         => 1,
              'labels_label_row'    => 1,
              'labels_data_row'     => 2,
              'labels_column'       => 4,
              'include_worksheets'  => [ '/^family/' ]
            ]
        );
        $this->setContainer($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Iterator\FamilyXlsxFileIterator');
    }

    public function it_reads_families()
    {
        $this->rewind();
        $values = [
            [
                'code' => 'main',
                'attribute_as_label' =>  'name',
                'labels' => ['en_US' => 'Main'],
                'attributes' => ['sku', 'name', 'type', 'description'],
                'requirements' => [
                    'main' => ['sku', 'name'],
                    'channel2' => ['sku', 'type']
                ]
            ],
            [
                'code' => 'family2',
                'attribute_as_label' =>  'name',
                'labels' => ['en_US' => 'Family 2'],
                'attributes' => ['sku', 'name', 'type'],
                'requirements' => [
                    'main' => ['sku', 'name'],
                    'channel2' => ['sku', 'type']
                ]
            ]
        ];

        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
