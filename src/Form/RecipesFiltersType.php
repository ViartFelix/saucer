<?php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Entity\User;
use App\Entity\Ustensil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipesFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('title', TextType::class, [
				'label' => 'Title',
				'attr' => [
					'placeholder' => "Title",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('description', TextareaType::class, [
				'label' => 'Description',
				'attr' => [
					'placeholder' => "Description",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('cookTimeMin', IntegerType::class, [
				'label' => 'Min Cook Time',
				'attr' => [
					'placeholder' => "Minimum cooking time",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('cookTimeMax', IntegerType::class, [
				'label' => 'Max Cook Time',
				'attr' => [
					'placeholder' => "Maximum cooking time",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('prepTimeMin', IntegerType::class, [
				'label' => 'Min Prep Time',
				'attr' => [
					'placeholder' => "Minimum preparation time",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('prepTimeMax', IntegerType::class, [
				'label' => 'Max Prep Time',
				'attr' => [
					'placeholder' => "Maximum preparation time",
					'class' => 'target-input',
				],
				'required' => false,
			])
			->add('ustensils', EntityType::class, [
				'class' => Ustensil::class,
				'choice_label' => 'nom',
				'label' => 'Utensils',
				'attr' => [
					'class' => 'ustensils grid-list',
				],
				'label_attr' => [
					'class' => 'select-title'
				],
				'required' => false,
				'multiple' => true,
				'expanded' => true,
			])
			->add('ingredients', EntityType::class, [
				'class' => Ingredients::class,
				'choice_label' => 'nom',
				'label' => 'Ingredients',
				'attr' => [
					'class' => 'ingredients grid-list',
				],
				'label_attr' => [
					'class' => 'select-title'
				],
				'required' => false,
				'multiple' => true,
				'expanded' => true,
				"by_reference" => true,
			])
			->add("filtrer", SubmitType::class, [
				"attr" => [
					"class" => 'target-submit',
				]
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Recipe::class,
        ]);
    }
}
