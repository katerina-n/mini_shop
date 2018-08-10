<?php

declare(strict_types=1);

namespace ApiBundle\Form;

use ApiBundle\Model\FormOptionItemModel;
use ApiBundle\Model\FormOptionsItemModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormType;
use Symfony\Component\Form\ResolvedFormTypeInterface;

/**
 * Class FormOptionsRetriever.
 *
 * @todo implement available types transform (checkbox,choice,date,datetime,number,textarea,text,wyswyg)
 *
 * Usage FormType Example:
 *      ->add('fieldName', 'fieldType'(string|null), [
 *          'attr'    => [
 *              'help'        => string,
 *              'placeholder' => string,
 *          ],
 *          'disabled' => bool,
 *          'multiple' => bool,
 *          'required' => bool,
 *          'choices'  => array(key:string,val:string),
 *          'label'    => string,
 *      ]);
 */
class FormOptionsRetriever
{
    /**
     * Gets form definitions.
     *
     * @param Form $form
     *
     * @return array|FormOptionsItemModel
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getDefinitions(Form $form)
    {
        return $form->count()
            ? $this->getComplexFieldDefinitions($form)
            : $this->getSimpleFieldOptions($form);
    }

    /**
     * Gets complex form definitions.
     *
     * @param Form $form
     *
     * @return array
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    protected function getComplexFieldDefinitions(Form $form): array
    {
        $innerType = $this->getInnerType($form);

        return [
            'type'       => $innerType->getBlockPrefix(),
            'parentType' => $this->getParentType($innerType),
            'children'   => array_map(
                function (Form $child) {
                    return $this->getDefinitions($child);
                },
                $form->all()
            ),
        ];
    }

    /**
     * Gets simple field options.
     *
     * @param Form $form
     *
     * @return FormOptionsItemModel
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    protected function getSimpleFieldOptions(Form $form): FormOptionsItemModel
    {
        $innerType = $this->getInnerType($form);

        return (new FormOptionsItemModel())
            ->setType($innerType->getBlockPrefix())
            ->setParentType($this->getParentType($innerType))
            ->setHelp($this->getAttrByName($form, 'help'))
            ->setLabel($this->getOptionByName($form, 'label'))
            ->setPlaceholder($this->getAttrByName($form, 'placeholder'))
            ->setDisabled((bool) $this->getOptionByName($form, 'disabled'))
            ->setMultiple((bool) $this->getOptionByName($form, 'multiple'))
            ->setRequired((bool) $this->getOptionByName($form, 'required'))
            ->setOptions($this->getTypeOptions($form))
            ->setValues($this->getValues($form, $innerType));
    }

    /**
     * Gets attribute by name.
     *
     * @param Form   $form
     * @param string $name
     *
     * @return string|bool|null
     */
    protected function getAttrByName(Form $form, string $name)
    {
        return $form->getConfig()->getOption('attr')
            ? $form->getConfig()->getOption('attr')[$name] ?? null
            : null;
    }

    /**
     * Gets option by name.
     *
     * @param Form   $form
     * @param string $name
     *
     * @return string|bool|null
     */
    protected function getOptionByName(Form $form, string $name)
    {
        return $form->getConfig()->getOption($name);
    }

    /**
     * Gets choices.
     *
     * @param Form   $form
     * @param string $optionAlias
     *
     * @return array
     */
    protected function getChoices(Form $form, string $optionAlias = 'choices'): array
    {
        $view = $form->createView();
        /** @var ChoiceView[] $choiceViews */
        $choiceViews = $view->vars[$optionAlias];
        $choices     = [];
        foreach ($choiceViews as $choiceView) {
            $choices[$choiceView->value] = $choiceView->label;
        }

        return $choices;
    }

    /**
     * Gets parent type.
     *
     * @param AbstractType $type
     *
     * @return string|null
     */
    protected function getParentType(AbstractType $type): ?string
    {
        $parentType = $type->getParent();

        if ($parentType && class_exists($parentType)) {
            $class = new $parentType();
            if (method_exists($class, 'getBlockPrefix')) {
                $parentType = $class->getBlockPrefix();
            }
        }

        return 'form' === $parentType ? null : $parentType;
    }

    /**
     * Gets additional type options.
     *
     * @param Form $form
     *
     * @return ArrayCollection|FormOptionItemModel[]
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    protected function getTypeOptions(Form $form): ArrayCollection
    {
        $data = new ArrayCollection();
        $type = $form->getConfig()->getType();

        if ($this->isTypeOf($type, 'choice')) {
            $choices = $this->getChoices($form);

            foreach ($choices as $key => $value) {
                $data->add(
                    (new FormOptionItemModel())
                        ->setKey((string) $key)
                        ->setValue((string) $value)
                );
            }
        }

        return $data;
    }

    /**
     * Checks if type or its ancestors is expected.
     *
     * @param ResolvedFormType|ResolvedFormTypeInterface $type
     * @param string                                     $expected
     *
     * @return bool
     */
    protected function isTypeOf(ResolvedFormTypeInterface $type, string $expected): bool
    {
        if ($type->getBlockPrefix() === $expected) {
            return true;
        }

        return $type->getParent()
            ? $this->isTypeOf($type->getParent(), $expected)
            : false;
    }

    /**
     * Gets form inner type.
     *
     * @param FormInterface $form
     *
     * @return AbstractType|FormTypeInterface
     */
    protected function getInnerType(FormInterface $form): AbstractType
    {
        return $form->getConfig()->getType()->getInnerType();
    }

    /**
     * Gets values depending on the input type.
     *
     * @param FormInterface $form
     * @param AbstractType  $innerType
     *
     * @return ArrayCollection
     */
    protected function getValues(FormInterface $form, AbstractType $innerType): ArrayCollection
    {
        $data = new ArrayCollection();
        if ($innerType instanceof CheckboxType) {
            $data->add((string) (null !== $form->getViewData()));

            return $data;
        }

        $vars = $form->createView()->vars['value'];
        if (!\is_array($vars)) {
            if ($vars) {
                $data->add((string) $vars);
            }

            return $data;
        }

        foreach ($vars as $value) {
            if ($vars) {
                $data->add((string) $value);
            }
        }

        return $data;
    }
}
