<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholer
     * @return array
     */
    public function getConfiguration($label, $placeholer, $class)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholer,
                'class' => $class,
            ]
        ];
    }
}
