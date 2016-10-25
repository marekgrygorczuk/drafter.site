<?php
namespace AppBundle\Form;

use AppBundle\Entity\Ride;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class NewRideDtoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('beginning', DateTimeType::class)
            ->add('locationDescription',TextareaType::class)
            ->add('gpsLon')
            ->add('gpsLat')
            ->add('distance')
            ->add('gear', ChoiceType::class, [
                'choices' => [
                    'Road' => Ride::GEAR_ROAD_BIKE,
                    'Cyclocross' => Ride::GEAR_CX,
                    'MTB' => Ride::GEAR_MTB,
                    'Touring' => Ride::GEAR_TOURING,
                    'Recumbent' => Ride::GEAR_RECUMBENT,
                    'Any' => Ride::GEAR_ANY,
                ]
            ])
            ->add('beginning',DateTimeType::class)
            ->add('save', SubmitType::class);
    }
}