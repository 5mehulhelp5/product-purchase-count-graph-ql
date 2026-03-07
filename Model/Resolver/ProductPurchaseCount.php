<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\ProductPurchaseCountGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Space\ProductPurchaseCount\Api\Data\ConfigInterface;
use Space\ProductPurchaseCountGraphQl\Model\ProductPurchaseCountCalculation;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class ProductPurchaseCount implements ResolverInterface
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var ProductPurchaseCountCalculation
     */
    private ProductPurchaseCountCalculation $productPurchaseCountCalculation;

    /**
     * Constructor
     *
     * @param ConfigInterface $config
     * @param ProductPurchaseCountCalculation $productPurchaseCountCalculation
     */
    public function __construct(
        ConfigInterface $config,
        ProductPurchaseCountCalculation $productPurchaseCountCalculation
    ) {
        $this->config = $config;
        $this->productPurchaseCountCalculation = $productPurchaseCountCalculation;
    }

    /**
     * Resolver
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        if (!$this->config->isEnabled()) {
            throw new GraphQlInputException(__('Space ProductPurchaseCount module is not enabled.'));
        }

        if (empty($args['product_id'])) {
            throw new GraphQlInputException(__('Required parameter "product_id" is missing'));
        }

        return $this->productPurchaseCountCalculation->calculatePurchaseCount($args['product_id']);
    }
}
