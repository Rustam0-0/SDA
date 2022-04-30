<?php
//
//namespace App\Form;
//
//use App\Entity\Product;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//
//class ProductType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('name')
//            ->add('description')
//            ->add('picture')
//            ->add('price')
//            ->add('stock')
//            ->add('date_add')
//            ->add('date_update')
//            ->add('subcat')
//        ;
//    }
//
//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => Product::class,
//        ]);
//    }
//}


namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('subcat', null, ['attr' => ['class' => 'custom-select']])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('picture', FileType::class, [
                'label' => 'Image',
                'mapped' => false, 'required' => false,
                'attr' => ['accept' => 'image/*', 'class' => 'form-control-file'],
                'data_class' => null
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix',
                'constraints' => [
                    new NotBlank(),
                    new Regex('/[0-9]{1,10}/')
                ],
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('date_add', HiddenType::class, ['mapped' => false, 'data_class' => null])
            ->add('date_update', HiddenType::class, ['mapped' => false, 'data_class' => null]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

