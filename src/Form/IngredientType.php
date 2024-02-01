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
		$builder
			->add('quantity', null, [
				'attr' => [
					'class' => 'target-input',
				],
			])
			->add('unit', null, [
				'attr' => [
					'class' => 'target-input',
				],
			])
			->add('ingredient', EntityType::class, [
				'class' => Ingredients::class,
				'choice_value' => "nom",
				'choice_label' => 'nom',
				'label' => 'Ingredient',
				'required' => true,
				'by_reference' => false,
				'attr' => [
					'class' => 'target-input',
				],
				'placeholder' => 'Choose an ingredient (select this to delete it)',
			]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
