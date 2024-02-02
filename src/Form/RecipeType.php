<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\User;
use App\Entity\Ustensil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
				"label" => "Title",
				"attr" => [
					"class" => "target-input",
				],
				"required" => true,
			])
            ->add('description', TextareaType::class, [
				"label" => "Description",
				"attr" => [
					"class" => "target-input",
				],
				"required" => false,
			])
            ->add('prep_time', NumberType::class, [
				"label" => "Preparation time",
				"attr" => [
					"class" => "target-input",
				],
				"required" => true,
			])
            ->add('cook_time', NumberType::class, [
				"label" => "Cooking time",
				"attr" => [
					"class" => "target-input",
				],
				"required" => true,
			])
            ->add('thumbnail', FileType::class, [
				"label" => "Photo",
				"required" => false,
				'mapped' => false,
				'constraints' => [
					new File([
						'maxSize' => '4096k',
						'mimeTypes' => [
							'image/gif',
							'image/jpeg',
							'image/png',
							'image/webp',
						],
						'mimeTypesMessage' => 'Please select a valid image (.png, .jpg, .jpeg or .webp) and bellow 4Mb',
					])
				],
			])
			->add('instructions', CollectionType::class, [
				"entry_type" => InstructionType::class,
				'entry_options' => [
					"required" => false,
				],
				'prototype' => true,
				"allow_add" => true,
				'by_reference' => false,
			])
			->add('recipeIngredients', CollectionType::class, [
				"entry_type" => IngredientType::class,
				'entry_options' => [
					"required" => false,
				],
				'prototype' => true,
				"allow_add" => true,
				'by_reference' => false,
				"mapped" => false,
			])
			->add('ustensils', null, [
				'choice_label' => 'nom',
				'multiple' => true,
				'expanded' => true,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
