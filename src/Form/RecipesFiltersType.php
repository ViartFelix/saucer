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
				'required' => false,
			])
			->add('description', TextType::class, [
				'label' => 'Description',
				'required' => false,
			])
			->add('cookTimeMin', IntegerType::class, [
				'label' => 'Min Cook Time',
				'required' => false,
			])
			->add('cookTimeMax', IntegerType::class, [
				'label' => 'Max Cook Time',
				'required' => false,
			])
			->add('prepTimeMin', IntegerType::class, [
				'label' => 'Min Prep Time',
				'required' => false,
			])
			->add('prepTimeMax', IntegerType::class, [
				'label' => 'Max Prep Time',
				'required' => false,
			])
			->add('ustensils', EntityType::class, [
				'class' => Ustensil::class,
				'choice_label' => 'nom',
				'label' => 'Utensils',
				'required' => false,
				'multiple' => true,
			])
			->add('ingredients', EntityType::class, [
				'class' => Ingredients::class,
				'choice_label' => 'nom',
				'label' => 'Ingredients',
				'required' => false,
				'multiple' => true,
				"by_reference" => true,
			])
			->add("envoyer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Recipe::class,
        ]);
    }
}
