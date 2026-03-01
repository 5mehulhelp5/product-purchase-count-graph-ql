<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\ProductPurchaseCountGraphQl\Test\Unit\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Space\ProductPurchaseCount\Api\Data\ConfigInterface;
use Space\ProductPurchaseCountGraphQl\Model\ProductPurchaseCountCalculation;
use Space\ProductPurchaseCountGraphQl\Model\Resolver\ProductPurchaseCount;

class ProductPurchaseCountTest extends TestCase
{
    /**
     * @var ConfigInterface|MockObject
     */
    private ConfigInterface|MockObject $configMock;

    /**
     * @var ProductPurchaseCountCalculation|MockObject
     */
    private ProductPurchaseCountCalculation|MockObject $productPurchaseCountCalculationMock;

    /**
     * @var ProductPurchaseCount
     */
    private ProductPurchaseCount $model;

    protected function setUp(): void
    {
        $this->configMock = $this->createMock(ConfigInterface::class);
        $this->productPurchaseCountCalculationMock = $this->createMock(ProductPurchaseCountCalculation::class);

        $this->model = new ProductPurchaseCount(
            $this->configMock,
            $this->productPurchaseCountCalculationMock
        );
    }

    public function testResolveThrowsExceptionWhenModuleIsDisabled(): void
    {
        $this->configMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(false);

        $this->expectException(GraphQlInputException::class);
        $this->expectExceptionMessage('Space ProductPurchaseCount module is not enabled.');

        $this->model->resolve(
            $this->createMock(Field::class),
            $this->createMock(ContextInterface::class),
            $this->createMock(ResolveInfo::class)
        );
    }

    public function testResolveThrowsExceptionWhenProductIdIsMissing(): void
    {
        $this->configMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $this->expectException(GraphQlInputException::class);
        $this->expectExceptionMessage('Required parameter "product_id" is missing');

        $this->model->resolve(
            $this->createMock(Field::class),
            $this->createMock(ContextInterface::class),
            $this->createMock(ResolveInfo::class),
            null,
            []
        );
    }

    public function testResolveReturnsCalculatedData(): void
    {
        $productId = 123;
        $expectedResult = [
            'count' => 5,
            'message' => '5 items sold'
        ];

        $this->configMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $this->productPurchaseCountCalculationMock->expects($this->once())
            ->method('calculatePurchaseCount')
            ->with($productId)
            ->willReturn($expectedResult);

        $result = $this->model->resolve(
            $this->createMock(Field::class),
            $this->createMock(ContextInterface::class),
            $this->createMock(ResolveInfo::class),
            null,
            ['product_id' => $productId]
        );

        $this->assertEquals($expectedResult, $result);
    }
}
