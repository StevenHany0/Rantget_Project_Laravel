<?php

namespace App\Services;

use App\Models\Property;

class PropertyUserService
{
    /**
     * Assign a tenant to a property.
     *
     * @param int $propertyId
     * @param int $userId
     * @return void
     */
    public function assignTenantToProperty($propertyId, $userId)
    {
        $property = Property::findOrFail($propertyId);

        // Check if the user already has a role assigned to the property
        $property->users()->syncWithoutDetaching([
            $userId => ['role' => 'tenant']
        ]);
    }
}
