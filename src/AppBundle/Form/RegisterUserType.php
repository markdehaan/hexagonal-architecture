<?php

namespace AppBundle\Form;

use AppBundle\CommandBus\RegisterUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType// implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
        ;
//        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RegisterUser::class,
//            'empty_data' => null,
            'empty_data' => function(FormInterface $form) {
                return new RegisterUser(
                    $form->get('name')->getData(),
                    $form->get('email')->getData()
                );
            },
        ));
    }

    public function mapDataToForms($data, $forms)
    {
    }

    public function mapFormsToData($forms, &$data)
    {
        /** @var FormInterface $forms */
        $forms = iterator_to_array($forms);

        $data = new RegisterUser(
            $forms['name']->getData(),
            $forms['email']->getData()
        );
    }
}
