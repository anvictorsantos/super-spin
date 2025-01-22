<?php

namespace Controllers;

use Gateways\CoachGateway;
use Helpers\FilterSort;
use Helpers\ValidationHelper;

class CoachController
{
    public function __construct(private CoachGateway $gateway) {}

    public function getAllCoaches(): string
    {
        $filter = $_GET['filter'] ?? '';
        $sort = $_GET['sort'] ?? 'asc';

        $coaches = $this->gateway->getAll();

        if (!empty($filter) || !empty($sort)) {
            $coaches = FilterSort::filterAndSort($coaches, $filter, $sort);
        }

        return json_encode($coaches);
    }

    public function createCoach(): string
    {
        $data = (array) json_decode(file_get_contents("php://input"), true);

        // Define required fields for coach creation
        $requiredFields = ['name', 'years_of_experience', 'hourly_rate', 'location', 'joined_at'];

        // Use ValidationHelper for validation
        $errors = ValidationHelper::getValidationErrors($data, $requiredFields);

        if (!empty($errors)) {
            http_response_code(422);
            return json_encode(['errors' => $errors]);
        }

        $id = $this->gateway->create($data);

        http_response_code(201);
        return json_encode(['message' => 'Coach registered', 'id' => $id]);
    }

    public function getCoach($id): string
    {
        $coach = $this->gateway->get($id);

        if (!$coach) {
            http_response_code(404);
            return json_encode(['message' => 'Coach not found']);
        }

        return json_encode($coach);
    }

    public function updateCoach($id): string
    {
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $coach = $this->gateway->get($id);

        if (!$coach) {
            http_response_code(404);
            return json_encode(['message' => 'Coach not found']);
        }

        // Define required fields for updating
        $requiredFields = ['name', 'years_of_experience', 'hourly_rate', 'location', 'joined_at'];

        $errors = ValidationHelper::getValidationErrors($data, $requiredFields, false);

        if (!empty($errors)) {
            http_response_code(422);
            return json_encode(['errors' => $errors]);
        }

        $rows = $this->gateway->update($coach, $data);

        return json_encode(['message' => "Coach $id updated", 'rows' => $rows]);
    }

    public function deleteCoach($id): string
    {
        $coach = $this->gateway->get($id);

        if (!$coach) {
            http_response_code(404);
            return json_encode(['message' => 'Coach not found']);
        }

        $rows = $this->gateway->delete($id);

        return json_encode(['message' => "Coach $id deleted", 'rows' => $rows]);
    }
}
