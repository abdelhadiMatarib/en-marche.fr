<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitizenProjectContactActorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Entrez l\'objet de votre message'],
            ])
            ->add('message', PurifiedTextareaType::class, [
                'purifier_type' => 'enrich_content',
                'attr' => ['placeholder' => 'Écrivez votre message'],
                'filter_emojis' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'csrf_token_id' => 'citizen_project.contact_actors',
                'csrf_field_name' => 'token',
                'allow_extra_fields' => true,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        // CSRF token is checked by the controller and must be at root
        return;
    }
}
