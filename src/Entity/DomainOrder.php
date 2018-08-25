<?php

namespace PreviewTechs\DomainReseller\Entity;


class DomainOrder
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $productKey;

    /**
     * @var bool
     */
    public $autoRenew;

    /**
     * @var bool
     */
    public $orderSuspendedByParent;

    /**
     * @var double
     */
    public $customerCost;

    /**
     * @var array
     */
    public $status;

    /**
     * @var bool
     */
    public $isOrderSuspendedUponExpiry;

    /**
     * @var string
     */
    public $actionStatus;

    /**
     * @var string
     */
    public $actionStatusDescription;

    /**
     * @var string
     */
    public $className;

    /**
     * @var Customer
     */
    public $customer;

    /**
     * @var int
     */
    public $invoiceId;

    /**
     * @var string
     */
    public $orderCreatedFromIp;

    /**
     * @var int
     */
    public $numberOfYears;

    /**
     * @var string
     */
    public $invoiceOption;

    /**
     * @var double
     */
    public $resellerCost;

    /**
     * @var bool
     */
    public $privacyProtectedAllowed;

    /**
     * @var int
     */
    public $privacyProtectionActionId;

    /**
     * @var bool
     */
    public $allowedDeletion;

    /**
     * @var bool
     */
    public $bulkWHOISOptout;

    /**
     * @var string
     */
    public $productCategory;

    /**
     * @var bool
     */
    public $privacyProtected;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DomainOrder
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductKey()
    {
        return $this->productKey;
    }

    /**
     * @param string $productKey
     *
     * @return DomainOrder
     */
    public function setProductKey($productKey)
    {
        $this->productKey = $productKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoRenew()
    {
        return $this->autoRenew;
    }

    /**
     * @param bool $autoRenew
     *
     * @return DomainOrder
     */
    public function setAutoRenew($autoRenew)
    {
        $this->autoRenew = $autoRenew;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOrderSuspendedByParent()
    {
        return $this->orderSuspendedByParent;
    }

    /**
     * @param bool $orderSuspendedByParent
     *
     * @return DomainOrder
     */
    public function setOrderSuspendedByParent($orderSuspendedByParent)
    {
        $this->orderSuspendedByParent = $orderSuspendedByParent;

        return $this;
    }

    /**
     * @return float
     */
    public function getCustomerCost()
    {
        return $this->customerCost;
    }

    /**
     * @param float $customerCost
     *
     * @return DomainOrder
     */
    public function setCustomerCost($customerCost)
    {
        $this->customerCost = $customerCost;

        return $this;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $status
     *
     * @return DomainOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOrderSuspendedUponExpiry()
    {
        return $this->isOrderSuspendedUponExpiry;
    }

    /**
     * @param bool $isOrderSuspendedUponExpiry
     *
     * @return DomainOrder
     */
    public function setIsOrderSuspendedUponExpiry($isOrderSuspendedUponExpiry)
    {
        $this->isOrderSuspendedUponExpiry = $isOrderSuspendedUponExpiry;

        return $this;
    }

    /**
     * @return string
     */
    public function getActionStatus()
    {
        return $this->actionStatus;
    }

    /**
     * @param string $actionStatus
     *
     * @return DomainOrder
     */
    public function setActionStatus($actionStatus)
    {
        $this->actionStatus = $actionStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getActionStatusDescription()
    {
        return $this->actionStatusDescription;
    }

    /**
     * @param string $actionStatusDescription
     *
     * @return DomainOrder
     */
    public function setActionStatusDescription($actionStatusDescription)
    {
        $this->actionStatusDescription = $actionStatusDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     *
     * @return DomainOrder
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     *
     * @return DomainOrder
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param int $invoiceId
     *
     * @return DomainOrder
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderCreatedFromIp()
    {
        return $this->orderCreatedFromIp;
    }

    /**
     * @param string $orderCreatedFromIp
     *
     * @return DomainOrder
     */
    public function setOrderCreatedFromIp($orderCreatedFromIp)
    {
        $this->orderCreatedFromIp = $orderCreatedFromIp;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfYears()
    {
        return $this->numberOfYears;
    }

    /**
     * @param int $numberOfYears
     *
     * @return DomainOrder
     */
    public function setNumberOfYears($numberOfYears)
    {
        $this->numberOfYears = $numberOfYears;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceOption()
    {
        return $this->invoiceOption;
    }

    /**
     * @param string $invoiceOption
     *
     * @return DomainOrder
     */
    public function setInvoiceOption($invoiceOption)
    {
        $this->invoiceOption = $invoiceOption;

        return $this;
    }

    /**
     * @return float
     */
    public function getResellerCost()
    {
        return $this->resellerCost;
    }

    /**
     * @param float $resellerCost
     *
     * @return DomainOrder
     */
    public function setResellerCost($resellerCost)
    {
        $this->resellerCost = $resellerCost;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivacyProtectedAllowed()
    {
        return $this->privacyProtectedAllowed;
    }

    /**
     * @param bool $privacyProtectedAllowed
     *
     * @return DomainOrder
     */
    public function setPrivacyProtectedAllowed($privacyProtectedAllowed)
    {
        $this->privacyProtectedAllowed = $privacyProtectedAllowed;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrivacyProtectionActionId()
    {
        return $this->privacyProtectionActionId;
    }

    /**
     * @param int $privacyProtectionActionId
     *
     * @return DomainOrder
     */
    public function setPrivacyProtectionActionId($privacyProtectionActionId)
    {
        $this->privacyProtectionActionId = $privacyProtectionActionId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowedDeletion()
    {
        return $this->allowedDeletion;
    }

    /**
     * @param bool $allowedDeletion
     *
     * @return DomainOrder
     */
    public function setAllowedDeletion($allowedDeletion)
    {
        $this->allowedDeletion = $allowedDeletion;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBulkWHOISOptout()
    {
        return $this->bulkWHOISOptout;
    }

    /**
     * @param bool $bulkWHOISOptout
     *
     * @return DomainOrder
     */
    public function setBulkWHOISOptout($bulkWHOISOptout)
    {
        $this->bulkWHOISOptout = $bulkWHOISOptout;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * @param string $productCategory
     *
     * @return DomainOrder
     */
    public function setProductCategory($productCategory)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivacyProtected()
    {
        return $this->privacyProtected;
    }

    /**
     * @param bool $privacyProtected
     *
     * @return DomainOrder
     */
    public function setPrivacyProtected($privacyProtected)
    {
        $this->privacyProtected = $privacyProtected;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                         => $this->getId(),
            'productKey'                 => $this->getProductKey(),
            'autoRenew'                  => $this->isAutoRenew(),
            'orderSuspendedByParent'     => $this->isOrderSuspendedByParent(),
            'customerCost'               => $this->getCustomerCost(),
            'status'                     => $this->getStatus(),
            'isOrderSuspendedUponExpiry' => $this->isOrderSuspendedUponExpiry(),
            'actionStatus'               => $this->getActionStatus(),
            'actionStatusDescription'    => $this->getActionStatusDescription(),
            'className'                  => $this->getClassName(),
            'customer'                   => $this->getCustomer()->toArray(),
            'invoiceId'                  => $this->getInvoiceId(),
            'orderCreatedFromIp'         => $this->getOrderCreatedFromIp(),
            'numberOfYears'              => $this->getNumberOfYears(),
            'invoiceOption'              => $this->getInvoiceOption(),
            'resellerCost'               => $this->getResellerCost(),
            'privacyProtectedAllowed'    => $this->isPrivacyProtectedAllowed(),
            'privacyProtectionActionId'  => $this->getPrivacyProtectionActionId(),
            'allowedDeletion'            => $this->isAllowedDeletion(),
            'bulkWHOISOptout'            => $this->isBulkWHOISOptout(),
            'productCategory'            => $this->getProductCategory(),
            'privacyProtected'           => $this->isPrivacyProtected()
        ];
    }
}