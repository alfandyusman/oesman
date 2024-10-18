<?php
use PHPUnit\Framework\TestCase;

class UserRegistrationTest extends TestCase {
    // Objek database connection (Anda perlu menyesuaikan dengan lingkungan Anda)
    private $conn;

    protected function setUp(): void {
        // Inisialisasi koneksi database atau mock database
        $this->conn = new mysqli("localhost", "username", "password", "database_name");

        if ($this->conn->connect_error) {
            die("Koneksi database gagal: " . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void {
        // Tutup koneksi database setelah pengujian
        $this->conn->close();
    }

    public function testUserRegistrationSuccess() {
        // Data pengguna yang akan diuji
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'gender' => 'male'
        ];

        // Simulasi submit formulir
        $_POST = $data;

        // Include file yang berisi kode pengolahan form (sebelumnya db_conn.php)
        require 'process_form.php';

        // Verifikasi apakah data pengguna berhasil disimpan
        $result = mysqli_query($this->conn, "SELECT * FROM `crud` WHERE `email` = 'john.doe@example.com'");
        $this->assertTrue($result->num_rows > 0);
    }

    public function testUserRegistrationFailure() {
        // Data pengguna yang akan diuji
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'gender' => 'female'
        ];

        // Simulasi submit formulir
        $_POST = $data;

        // Include file yang berisi kode pengolahan form (sebelumnya db_conn.php)
        require 'process_form.php';

        // Verifikasi apakah data pengguna tidak berhasil disimpan
        $result = mysqli_query($this->conn, "SELECT * FROM `crud` WHERE `email` = 'jane.doe@example.com'");
        $this->assertFalse($result->num_rows > 0);
    }
}
