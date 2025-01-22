<?php

namespace Helpers;

class ValidationHelper
{
    /**
     * Validates the given data against required fields.
     *
     * @param array $data The data to validate.
     * @param array $requiredFields List of required fields.
     * @param bool $isNew Indicates whether the validation is for new data (default: true).
     * @return array An array of validation error messages.
     */
    public static function getValidationErrors(array $data, array $requiredFields, bool $isNew = true): array
    {
        $errors = [];

        foreach ($requiredFields as $field) {
            if ($isNew && empty($data[$field])) {
                $errors[] = "$field is required";
            }
        }

        return $errors;
    }
}
