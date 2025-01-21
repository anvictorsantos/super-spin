<?php

namespace Gateways;

use Database\Database;
use PDO;

class CoachGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM coach";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO coach (name, years_of_experience, hourly_rate, location, joined_at)
                VALUES (:name, :years_of_experience, :hourly_rate, :location, :joined_at)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":years_of_experience", $data["years_of_experience"], PDO::PARAM_INT);
        $stmt->bindValue(":hourly_rate", $data["hourly_rate"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $data["location"], PDO::PARAM_STR);
        $stmt->bindValue(":joined_at", $data["joined_at"], PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT * FROM coach WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE coach
                SET name = :name, years_of_experience = :years_of_experience, hourly_rate = :hourly_rate, location = :location, joined_at = :joined_at
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], PDO::PARAM_STR);
        $stmt->bindValue(":years_of_experience", $new["years_of_experience"] ?? $current["years_of_experience"], PDO::PARAM_INT);
        $stmt->bindValue(":hourly_rate", $new["hourly_rate"] ?? $current["hourly_rate"], PDO::PARAM_STR);
        $stmt->bindValue(":location", $new["location"] ?? $current["location"], PDO::PARAM_STR);
        $stmt->bindValue(":joined_at", $new["joined_at"] ?? $current["joined_at"], PDO::PARAM_STR);

        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {
        $sql = "DELETE FROM coach
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
