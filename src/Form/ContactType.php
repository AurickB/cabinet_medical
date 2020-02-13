<?php

namespace App\Form;



use App\Entity\Contact;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('user', ChoiceType::class, [
                'choices' =>$this->getChoices(),
                'placeholder' => 'Choisissez votre praticien'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain'=>'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Contact::MAIL;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$k] = $v;
        }
        return $output;
    }
}
