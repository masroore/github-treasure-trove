<?php

namespace Modules\ExternalShop\Import\Contracts;

interface Purchase
{
    public function getId(): string;

    public function getExternalId(): string;

    public function getName(): string;

    /**
     * @return mixed
     */
    public function getSku();

    public function getPrice(): int;

    public function getQuantity(): int;

    /**
     * @return mixed
     */
    public function getUrl();

    /**
     * @return mixed
     */
    public function getImgUrl();
}
