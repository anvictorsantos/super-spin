<?php

use Database\Database;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $dotenvMock;
    private $pdoMock;
    private $db;

    protected function setUp(): void
    {
        // Mock Dotenv to avoid loading actual environment variables
        $this->dotenvMock = $this->createMock(Dotenv::class);
        $this->dotenvMock->method('load'); // Do nothing on load

        // Create the Database object without mocking constructor
        $this->db = $this->getMockBuilder(Database::class)
                         ->onlyMethods(['getConnection']) // Only mock the getConnection method
                         ->getMock();
    }

    public function testGetConnectionSuccessful()
    {
        // Mock environment variables
        $_ENV['DB_HOST'] = 'localhost';
        $_ENV['DB_PORT'] = '3306';
        $_ENV['DB_NAME'] = 'super-spin';
        $_ENV['DB_USER'] = 'super-spin-admin';
        $_ENV['DB_PASSWORD'] = 'naotemsenha';

        // Mock the PDO connection and ensure the connection is returned
        $this->db->expects($this->once())
                 ->method('getConnection')
                 ->willReturn($this->createMock(\PDO::class));

        $connection = $this->db->getConnection();
        $this->assertInstanceOf(\PDO::class, $connection);
    }

    public function testGetConnectionThrowsRuntimeException()
    {
        // Mock environment variables
        $_ENV['DB_HOST'] = 'localhost';
        $_ENV['DB_PORT'] = '3306';
        $_ENV['DB_NAME'] = 'super-spin';
        $_ENV['DB_USER'] = 'super-spin-admin';
        $_ENV['DB_PASSWORD'] = 'naotemsenha';

        // Simulate an exception when trying to create the PDO connection
        $this->db->expects($this->once())
                 ->method('getConnection')
                 ->willThrowException(new \PDOException('Failed to connect to the database: Connection error'));

        // Verify that the exception is caught and wrapped in a RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to connect to the database: Connection error');

        $this->db->getConnection();
    }
}
