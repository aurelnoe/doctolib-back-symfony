<?php

namespace App\Form;

use DateTime;
use App\Entity\Patient;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormPatientType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,$this->getConfiguration('Nom', 'Saisissez votre nom', 'form-control'))
            ->add('prenom',TextType::class,$this->getConfiguration('Prénom', 'Saisissez votre prénom', 'form-control'))
            ->add('dateInscription',DateTimeType::class)
            ->add('email',EmailType::class,$this->getConfiguration('Adresse mail', 'Saisissez votre adresse mail', 'form-control'))
            ->add('telephone',IntegerType::class,$this->getConfiguration('Téléphone', 'Saisissez votre numéro', 'form-control'))
            ->add('password',PasswordType::class)
            ->add('dateNaissance',BirthdayType::class, $this->getConfiguration('Date de naissance','','js-datepicker'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
