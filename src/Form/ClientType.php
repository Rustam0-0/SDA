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


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/'])
                ],
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez indiquez le même mot de passe',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation de mot de passe'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$/', 'match' => true,
                        'message' => 'Veuillez indiquez le même mot de passe et mettre 8 caractéres dont une majuscule et un symbole']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Veuillez entrer minimum {{ limit }} caractéres',
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
                    new NotBlank(),
                    new Regex('/[0-9]{2,15}$/')
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/[a-zA-Z]{2,}$/')
                ],
                'attr' => ['class' => 'form-control'], 'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

