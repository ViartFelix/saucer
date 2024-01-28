<?php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		/*
        $builder
            ->add('nom', EntityType::class, [
				"class" => Ingredients::class,
				"choice_label" => "nom",
				"mapped" => false
			])
			->add("quantiy", TextType::class, [
				"mapped" => false,
			])
			->add('unit', TextType::class, [
				"mapped" => false,
			])
        ;
		*/
		$builder
			->add('quantity')
			->add('unit')
			->add('ingredient', EntityType::class, [
				'class' => Ingredients::class,
				'choice_label' => 'nom', // Assuming 'nom' is the property of Ingredients entity you want to display
				'label' => 'Ingredient',
				'required' => true,
				'placeholder' => 'Choose an ingredient',
			]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
