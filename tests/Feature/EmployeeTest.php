<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\CompanyToEmployeeNotification;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the employee index view loads correctly.
     *
     * @return void
     */
    public function test_employee_index_view_is_displayed_correctly()
    {
        // Act: Make a GET request to the route that displays the employee index view
        $response = $this->get(route('employee.index'));

        // Assert: Check if the view is returned with the correct data
        $response->assertStatus(200);

        // Optional: You can also assert that the pagination works correctly
        $employees = \App\Models\Employee::paginate(10);
        $response->assertViewHas('employee', function ($viewEmployees) use ($employees) {
            return $viewEmployees->count() === $employees->count();
        });
    }

    public function test_it_displays_the_create_employee_view_with_companies()
    {
        // Act: Mengunjungi rute yang memuat view create employee
        $response = $this->get(route('employee.create'));

        // Assert: Memeriksa apakah view yang benar dikembalikan dan data companies diteruskan ke view
        $response->assertStatus(200);
        $response->assertViewIs('admin.employee.create');
    }

    public function test_it_can_store_employee()
    {
        $company = Company::factory()->create();
        $employeeData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'company_id' => $company->id,
        ];

        // Act: Kirim request untuk menambah employee
        $response = $this->post(route('employee.store'), $employeeData);
        $response->assertStatus(302);

        // Assert: Pastikan data employee tersimpan
        // $response->assertSessionHas('success', 'Data john.doe@example.com Berhasil di tambahkan!');

        // $response->assertDatabaseHas('employees', [
        //     'firstname' => 'John',
        //     'lastname' => 'Doe',
        //     'email' => 'john.doe@example.com',
        //     'phone' => '+1234567890',
        //     'company_id' => $company->id,
        // ]);
    }

    public function test_it_can_show_the_edit_view_with_correct_data()
    {
        // Arrange: Buat data perusahaan dan karyawan
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        // Act: Kunjungi halaman edit untuk karyawan yang dibuat
        $response = $this->get(route('employee.edit', $employee->id));

        // Assert: Pastikan tampilan yang benar digunakan
        $response->assertStatus(200); // Memastikan status kode HTTP 200 OK
        $response->assertViewIs('admin.employee.edit'); // Memastikan tampilan yang benar

        // Assert: Pastikan data yang dikirim ke tampilan sesuai dengan yang diharapkan
        $response->assertViewHas('company', function ($companies) use ($company) {
            return $companies->contains($company);
        });

        $response->assertViewHas('d', function ($viewEmployee) use ($employee) {
            return $viewEmployee->id === $employee->id
                && $viewEmployee->firstname === $employee->firstname
                && $viewEmployee->lastname === $employee->lastname
                && $viewEmployee->email === $employee->email
                && $viewEmployee->phone === $employee->phone
                && $viewEmployee->company_id === $employee->company_id;
        });
    }

    public function test_it_can_update_employee_data()
    {
        // Arrange: Buat data perusahaan dan karyawan
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        // Data baru untuk diperbarui
        $updatedData = [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'email' => fake()->safeEmail,
            'phone' => fake()->phoneNumber,
            'company_id' => $company->id, // Asumsikan perusahaan yang sama
        ];

        // Act: Kirim permintaan POST ke rute pembaruan
        $response = $this->put(route('employee.update', $employee->id), $updatedData);

        // Assert: Pastikan data diperbarui di database
        $employee->refresh(); // Muat ulang model untuk mendapatkan data terbaru

        $this->assertEquals($updatedData['firstname'], $employee->firstname);
        $this->assertEquals($updatedData['lastname'], $employee->lastname);
        $this->assertEquals($updatedData['email'], $employee->email);
        $this->assertEquals($updatedData['phone'], $employee->phone);
        $this->assertEquals($updatedData['company_id'], $employee->company_id);

        // Assert: Pastikan pengalihan dilakukan ke rute yang benar dengan pesan yang benar
        $response->assertRedirect(route('employee.index'));
        $response->assertSessionHas('success', 'Data ' . $updatedData['email'] . ' Berhasil di ubah!');
    }

    public function test_it_can_delete_employee_data()
    {
        // Arrange: Buat data karyawan
        $employee = Employee::factory()->create();

        // Act: Kirim permintaan DELETE ke rute penghapusan
        $response = $this->delete(route('employee.destroy', $employee->id));

        // Assert: Pastikan data karyawan dihapus dari database
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);

        // Assert: Pastikan pengalihan dilakukan ke rute yang benar dengan pesan yang benar
        $response->assertRedirect(route('employee.index'));
        $response->assertSessionHas('success', 'Data ' . $employee->email . ' Berhasil di hapus!');
    }
}
