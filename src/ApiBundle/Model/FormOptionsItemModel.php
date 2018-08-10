<?php

declare(strict_types=1);

namespace Diva\RestBundle\Model;

use ApiBundle\Controller\DefaultController;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class FormOptionsItemModel.
 *
 * @Serializer\ExclusionPolicy("all")
 *
 * Serialized groups:
 *  - FormOptions - used in @see ProfileController
 */
class FormOptionsItemModel
{
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $type;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $parentType;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $help;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $label;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("string")
     */
    protected $placeholder;

    /**
     * @var bool
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("boolean")
     */
    protected $disabled = false;

    /**
     * @var bool
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("boolean")
     */
    protected $multiple = false;

    /**
     * @var bool
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("boolean")
     */
    protected $required = false;

    /**
     * @var ArrayCollection|FormOptionItemModel[]
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("array<Diva\RestBundle\Model\FormOptionItemModel>")
     */
    protected $options;

    /**
     * @var ArrayCollection|string[]
     * @Serializer\Expose()
     * @Serializer\Groups({"FormOptions"})
     * @Serializer\Type("array<string>")
     */
    protected $values;

    /**
     * FormOptionsItemModel constructor.
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->values  = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getParentType(): ?string
    {
        return $this->parentType;
    }

    /**
     * @param null|string $parentType
     *
     * @return $this
     */
    public function setParentType(?string $parentType): self
    {
        $this->parentType = $parentType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHelp(): ?string
    {
        return $this->help;
    }

    /**
     * @param null|string $help
     *
     * @return $this
     */
    public function setHelp(?string $help): self
    {
        $this->help = $help;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|string $label
     *
     * @return $this
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param null|string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     *
     * @return $this
     */
    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     *
     * @return $this
     */
    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return ArrayCollection|FormOptionItemModel[]
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection||FormOptionItemModel[] $options
     *
     * @return $this
     */
    public function setOptions(ArrayCollection $options): self
    {
        foreach ($options as $option) {
            $this->addOption($option);
        }

        return $this;
    }

    /**
     * Add option.
     *
     * @param FormOptionItemModel $option
     *
     * @return $this
     */
    public function addOption(FormOptionItemModel $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    /**
     * Remove option.
     *
     * @param FormOptionItemModel $option
     *
     * @return $this
     */
    public function removeOption(FormOptionItemModel $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|string[]
     */
    public function getValues(): ArrayCollection
    {
        return $this->values;
    }

    /**
     * @param ArrayCollection|string[] $values
     *
     * @return $this
     */
    public function setValues(ArrayCollection $values): self
    {
        foreach ($values as $value) {
            $this->addValue($value);
        }

        return $this;
    }

    /**
     * Add value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function addValue(string $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
        }

        return $this;
    }

    /**
     * Remove value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function removeValue(string $value): self
    {
        if ($this->values->contains($value)) {
            $this->values->removeElement($value);
        }

        return $this;
    }
}
