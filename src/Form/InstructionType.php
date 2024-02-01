<?php

namespace App\Form;

use App\Entity\Instructions;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class InstructionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
				"attr" => [
					"class" => "target-input",
					"rows" => "5",
				],
				"label" => "Content",
			])
            ->add('mediaFile', FileType::class, [
				"label" => "Media (video, audio, or image)",
            	'mapped' => true,
				"by_reference" => false,
				'required' => false,
				'constraints' => [
					new File([
						'maxSize' => '1024M',
						'mimeTypes' => [
							'image/gif',
							'image/jpeg',
							'image/png',
							'image/webp',

							'video/mp4',
							'video/mov',
							'video/avi',
							'video/webm',
							'video/mpeg',
							'video/x-m4v',
							'video/quicktime',

							'audio/mpeg',
							'audio/x-wav',
							'audio/mp4',
							'application/ogg',
						],
						'mimeTypesMessage' => '
						Please select a file that is under 1Gb that have one of these formats:
							- image: .gif, .jpeg, .png, .webp
							- video: .mp4, .mov, .avi, .webm, .mpeg, .m4v, .mov, .qt
							- audio: .mp3, .wav, .wave, .ogg, .mp2, mpeg
						',
					]),
				],
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instructions::class,
        ]);
    }
}
