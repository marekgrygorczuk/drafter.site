<?php
namespace AppBundle\Form;

use AppBundle\Entity\RideStamp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('rideClockHour',  ChoiceType::class, [
                'choices' => [
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13,
                    '14' => 14,
                    '15' => 15,
                    '16' => 16,
                    '17' => 17,
                    '18' => 18,
                    '19' => 19,
                    '20' => 20,
                ]
            ])
            ->add('rideClockMinute', ChoiceType::class, [
                'choices' => [
                    '00' => 0,
                    '15' => 15,
                    '30' => 30,
                    '45' => 45,
                ]
            ])
            ->add('dayOfWeek', ChoiceType::class, [
                'choices' => [
                    'Monday' => RideStamp::MONDAY,
                    'Tuesday' => RideStamp::TUESDAY,
                    'Wednesday' => RideStamp::WEDNESDAY,
                    'Thursday'  => RideStamp::THURSDAY,
                    'Friday' => RideStamp::FRIDAY,
                    'Saturday' => RideStamp::SATURDAY,
                    'Sunday' => RideStamp::SUNDAY
                ]
            ])
            ->add('save', SubmitType::class);
    }
}