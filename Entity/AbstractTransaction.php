<?php

namespace Lone\SystempayBundle\Entity;

use Lone\SystempayBundle\Model\TransactionStatus;
use \DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractTransaction
{
    /**
     * @var
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="systempay_transaction_id", length=10, type="string")
     */
    protected $systempayTransactionId;

    /**
     * @var string
     * @ORM\Column(name="systempay_transaction_id", type="string", nullable=true)
     */
    protected $transactionUuid;

    /**
     * @var string
     * @ORM\Column(name="status_code", type="string", length=255, nullable=true)
     */
    protected $status = TransactionStatus::PENDING;

    /**
     * @var int
     * @ORM\Column(name="amount", type="integer")
     */
    protected $amount;

    /**
     * @var int
     * @ORM\Column(name="currency", type="integer")
     */
    protected $currency;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var string
     * @ORM\Column(name="log_response", type="text", nullable=true)
     */
    protected $logResponse;

    /**
     * @var bool
     * @ORM\Column(name="paid", type="boolean")
     */
    protected $paid = false;

    /**
     * @var bool
     * @ORM\Column(name="refunded", type="boolean")
     */
    protected $refunded = false;

    /**
     * Create a new transaction, default currency is 978 => EUR.
     * @param int $amount
     * @param int $currency
     */
    public function __construct(string $systempayTransactionId, int $amount, int $currency = 978)
    {
        $this->systempayTransactionId = $systempayTransactionId;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamps() {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime();
        }
        $this->updatedAt = new DateTime();
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function currency(): int
    {
        return $this->currency;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function logResponse(): string
    {
        return $this->logResponse;
    }

    public function setLogResponse($logResponse)
    {
        $this->logResponse = $logResponse;
    }

    public function paid(): bool
    {
        return $this->paid;
    }

    public function pay(): void
    {
        $this->paid = true;
    }

    public function refunded(): bool
    {
        return $this->refunded;
    }

    public function refund(): void
    {
        $this->refunded = true;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function changeStatus(string $status)
    {
        $this->status = $status;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function systempayTransactionId(): ?string
    {
        return $this->systempayTransactionId;
    }

}
