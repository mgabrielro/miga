<?php

namespace Common\Traits;

/**
 * Trait DeclarationFormFormDefinitionTrait
 *
 * @author Markus Lommer <markus.lommer@check24.de>
 */
trait DeclarationFormFormDefinitionTrait
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function getDeclarationFormFormDefinition($data = [])
    {
        $declarationFormFormDefinition = [
            /*
             * Place mock data here,
             * as done in AddressFormFormDefinitionTrait
             */
        ];

        $declarationFormFormDefinition = array_merge($declarationFormFormDefinition, $data);

        return $declarationFormFormDefinition;
    }
}