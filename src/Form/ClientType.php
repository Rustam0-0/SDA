<?php
//
//namespace App\Form;
//
//use App\Entity\Client;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//
//class ClientType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('name')
//            ->add('surname')
//            ->add('address')
//            ->add('zipcode')
//            ->add('city')
//            ->add('date_add')
//        ;
//    }
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => Client::class,
//        ]);
//    }
//}


namespace App\Form;


use PharIo\Manifest\Email;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Unique;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    //new Unique([]),
                    new NotBlank(),
                    new Regex(['pattern' => '/[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/'])
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Indiquez le même mot de passe',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe', 'attr' => ['placeholder' => '8 caractéres minimum', 'class' => 'form-control']],
                'second_options' => ['label' => 'Retapez votre mot de passe', 'attr' => ['placeholder' => 'Confirmation du mot de passe', 'class' => 'form-control']],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe ',
                    ]),
//                    new Regex(['pattern' => '/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$/',
//                        'match' => true,
//                        'message' => 'Veuillez indiquez le même mot de passe et mettre 8 caractéres dont une majuscule et un symbole']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Entrez minimum {{ limit }} caractéres',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(),
                    new Regex("/^[a-zA-Z'-]{2,}$/")
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(),
                    new Regex("/^[a-zA-Z'-]{2,}$/")
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('tel', TextType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/[0-9]{10,10}$/'),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Entrez {{ limit }} caractéres',
                        'max' => 10,
                        'maxMessage' => 'Entrez {{ limit }} caractéres',
                    ]),
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/[a-zA-Z0-9]{2,}$/')
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'constraints' => [
//                    new NotBlank(),
                    new Regex('/[0-9]{2,15}$/')
                ],
                'attr' => ['class' => 'form-control', 'value' => '80000', 'disabled' => true], 'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
//                    new NotBlank(),
                    new Regex('/[a-zA-Z]{2,}$/')
                ],
                'attr' => ['class' => 'form-control', 'value' => 'Amiens', 'disabled' => true], 'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

