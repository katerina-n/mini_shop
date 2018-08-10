<?php

declare(strict_types=1);

namespace ApiBundle\Model;

use ApiBundle\Controller\DefaultController;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class FormOptionItemModel.
 *
 * @Serializer\ExclusionPolicy("all")
 */
class FormOptionItemModel
{
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $key;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $value;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null|string $value
     *
     * @return $this
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
