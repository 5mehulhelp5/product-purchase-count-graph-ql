<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\ProductPurchaseCountGraphQl\Test\Unit\Model;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Space\ProductPurchaseCount\Api\Data\ProductPurchaseCountInterface;
use Space\ProductPurchaseCount\Model\Service\PurchaseCalculation;
use Space\ProductPurchaseCountGraphQl\Model\ProductPurchaseCountCalculation;

class ProductPurchaseCountCalculationTest extends TestCase
{
    /**
     * @var PurchaseCalculation|MockObject
     */
    private PurchaseCalculation|MockObject $purchaseCalculationMock;

    /**
     * @var ProductPurchaseCountCalculation
     */
    private ProductPurchaseCountCalculation $model;

    protected function setUp(): void
    {
        $this->purchaseCalculationMock = $this->createMock(PurchaseCalculation::class);
        $this->model = new ProductPurchaseCountCalculation($this->purchaseCalculationMock);
    }

    public function testCalculatePurchaseCountReturnsFormattedData(): void
    {
        $productId = 123;
        $count = 5;
        $notificationText = '5 items sold';

        $productPurchaseCountMock = $this->createMock(ProductPurchaseCountInterface::class);

        $productPurchaseCountMock->expects($this->once())
            ->method('getCount')
            ->willReturn($count);

        $productPurchaseCountMock->expects($this->once())
            ->method('getNotificationText')
            ->willReturn($notificationText);

        $this->purchaseCalculationMock->expects($this->once())
            ->method('getPurchaseCount')
            ->with($productId)
            ->willReturn($productPurchaseCountMock);

        $expectedResult = [
            ProductPurchaseCountInterface::COUNT => $count,
            ProductPurchaseCountInterface::NOTIFICATION_TEXT => $notificationText
        ];

        $result = $this->model->calculatePurchaseCount($productId);

        $this->assertEquals($expectedResult, $result);
    }
}
