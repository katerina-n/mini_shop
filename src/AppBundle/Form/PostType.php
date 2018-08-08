<?php
declare(strict_types=1);
namespace AppBundle\Form;

use AppBundle\Model\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class PostType
 * @package AppBundle\Form
 */
class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $session = new Session();
//        $startdate=$session->get('startdate');
//        $lastdate=$session->get('lastdate');
//        if(empty($startdate)){
//            $startdate=new \DateTime('2018-03-10');
//        }
//        if(empty($lastdate)){
//            $lastdate=new \DateTime();
//        }
//        $builder
//            ->add('dateFirst', DateType::class, array('format' => 'yyyy-MM-dd', 'data'=>$startdate))
//            ->add('dateLast', DateType::class, array( 'format' => 'yyyy-MM-dd', 'data'=>$lastdate))
//            ->add('save', SubmitType::class, array('label' => 'Send'));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults(array(
//            'data_class' => Form::class,
//        ));
    }
}