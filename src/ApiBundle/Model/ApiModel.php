<?php

declare(strict_types=1);

namespace ApiBundle\Model;

use ApiBundle\Controller\DefaultController;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class ApiModel.
 *
 *
 *
 */
class ApiModel
{
    protected $fields = [];

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
}
