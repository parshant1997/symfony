<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'First Name',
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Last Name',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email Address',
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Password',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Password should not be empty.']),
                    new Assert\Length(['min' => 8, 'minMessage' => 'Password must be at least {{ limit }} characters long.']),
                    new Assert\Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Password must contain at least one uppercase letter.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Password must contain at least one lowercase letter.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/\d/',
                        'message' => 'Password must contain at least one number.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[\W_]/',
                        'message' => 'Password must contain at least one special character.',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true, // Allows multiple roles (checkboxes)
                'expanded' => true, // Renders as checkboxes
                'label' => 'Roles',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
