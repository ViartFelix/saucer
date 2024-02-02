<?php

namespace App\Form\Parts;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
				"label" => "Last name",
				"required" => false,
				"attr" => [
					"class" => "target-input"
				],
			])
            ->add('prenom', TextType::class, [
				"label" => "First name",
				"required" => false,
				"attr" => [
					"class" => "target-input"
				],
			])
			->add('send', SubmitType::class, [
				"label" => "Send",
				"attr" => [
					"class" => "send-btn"
				],
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
