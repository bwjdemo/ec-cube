<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Service\Payment\Method;

use Eccube\Entity\Order;
use Eccube\Service\Payment\PaymentMethodInterface;
use Eccube\Service\Payment\PaymentResult;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Symfony\Component\Form\FormInterface;

/**
 * 銀行振込, 代金引き換えなど, 主に現金を扱う支払い方法を扱うクラス.
 */
class Cash implements PaymentMethodInterface
{
    /** @var Order */
    private $Order;

    /** @var FormInterface */
    private $form;

    /** @var $purchaseFlow */
    private $purchaseFlow;

    /**
     * Cash constructor.
     *
     * @param PurchaseFlow $shoppingPurchaseFlow
     */
    public function __construct(PurchaseFlow $shoppingPurchaseFlow)
    {
        $this->purchaseFlow = $shoppingPurchaseFlow;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Eccube\Service\PurchaseFlow\PurchaseException
     */
    public function checkout()
    {
        $this->purchaseFlow->commit($this->Order, new PurchaseContext(null, $this->Order->getCustomer()));

        $result = new PaymentResult();
        $result->setSuccess(true);

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Eccube\Service\PurchaseFlow\PurchaseException
     */
    public function apply()
    {
        $this->purchaseFlow->prepare($this->Order, new PurchaseContext(null, $this->Order->getCustomer()));

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormType(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * {@inheritdoc}
     */
    public function verify()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(Order $Order)
    {
        $this->Order = $Order;
    }
}
