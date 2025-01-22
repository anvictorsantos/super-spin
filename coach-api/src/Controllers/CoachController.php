<?php

namespace Controllers;

use Gateways\CoachGateway;
use Helpers\FilterSort;

class CoachController
{
    public function __construct(private CoachGateway $gateway) {}

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $coach = $this->gateway->get($id);

        if (!$coach) {
            http_response_code(404);
            echo json_encode(["message" => "Coach not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($coach);
                break;

            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $rows = $this->gateway->update($coach, $data);

                echo json_encode([
                    "message" => "Coach $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "Coach $id deleted",
                    "rows" => $rows
                ]);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
                break;
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case 'GET':
                $filter = $_GET['filter'] ?? ''; // Retrieve the filter from the query string
                $sort = $_GET['sort'] ?? 'asc'; // Retrieve the sort order from the query string, default to ascending

                $coaches = $this->gateway->getAll(); // Get all coaches from the gateway

                // Apply filter and sort using the helper function
                if (!empty($filter) || !empty($sort)) {
                    $coaches = FilterSort::filterAndSort($coaches, $filter, $sort);
                }

                // Return the filtered and sorted coaches as JSON
                echo json_encode($coaches);
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $id = $this->gateway->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Coach registered",
                    "id" => $id
                ]);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
                break;
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if ($is_new && empty($data['name'])) {
            $errors[] = "name is required";
        }

        if ($is_new && empty($data['years_of_experience'])) {
            $errors[] = "years_of_experience is required";
        }

        if ($is_new && empty($data['hourly_rate'])) {
            $errors[] = "hourly_rate is required";
        }

        if ($is_new && empty($data['location'])) {
            $errors[] = "location is required";
        }

        if ($is_new && empty($data['joined_at'])) {
            $errors[] = "joined_at is required";
        }

        return $errors;
    }
}
