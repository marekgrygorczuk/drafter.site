<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RideStampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rideName')
            ->add('rideLocation', TextareaType::class)
            ->add('rideClockHour', DateTimeType::class)
            ->add('rideClockMinute', DateTimeType::class)
            ->add('dayOfWeek')
            ->add('save', SubmitType::class);
    }
}