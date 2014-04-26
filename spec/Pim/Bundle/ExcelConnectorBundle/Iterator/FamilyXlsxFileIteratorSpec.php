<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Iterator;

use Symfony\Component\DependencyInjection\ContainerInterface;

class FamilyXlsxFileIteratorSpec extends XlsxFileIteratorBehavior
{
    public function let(ContainerInterface $container)
    {
        parent::let($container);
        $this->beConstructedWith(
            __DIR__ . '/../fixtures/init.xlsx',
            [
              'channel_label_row'    =>   5,
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
                'attributes' => ['sku', 'name', 'type', 'description'],
                'code' => 'main',
                'labels' => ['en_US' => 'Main'],
                'requirements' => [
                    'main' => ['sku', 'name'],
                    'channel2' => ['sku', 'type']
                ],
                'attribute_as_label' =>  'name',
            ],
            [
                'attributes' => ['sku', 'name', 'type'],
                'code' => 'family2',
                'labels' => ['en_US' => 'Family 2'],
                'requirements' => [
                    'main' => ['sku', 'name'],
                    'channel2' => ['sku', 'type']
                ],
                'attribute_as_label' =>  'name',
            ]
        ];

        foreach ($values as $item) {
            $this->current()->shouldReturn($item);
            $this->next();
        }

        $this->valid()->shouldReturn(false);
    }
}
