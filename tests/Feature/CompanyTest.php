<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use  RefreshDatabase;

    public function test_it_displays_paginated_companies()
    {
        // Arrange: Buat beberapa data perusahaan
        Company::factory(20)->create();

        // Act: Kirim permintaan GET ke rute yang menampilkan tampilan
        $response = $this->get(route('company.index'));

        // Assert: Pastikan tampilan yang benar dikembalikan
        $response->assertStatus(200);
        $response->assertViewIs('admin.company.index');

        // Assert: Pastikan data perusahaan ada di tampilan
        $response->assertViewHas('companies');

        // Assert: Pastikan data perusahaan di-paginate
        $companies = $response->viewData('companies');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $companies);
        $this->assertCount(10, $companies->items());
    }

    public function test_it_displays_the_create_company_form()
    {
        // Act: Kirim permintaan GET ke rute yang menampilkan formulir pembuatan perusahaan
        $response = $this->get(route('company.create'));

        // Assert: Pastikan tampilan yang benar dikembalikan
        $response->assertStatus(200);
        $response->assertViewIs('admin.company.create');
    }

    public function test_it_stores_a_new_company()
    {
        // Simulasi penyimpanan file
        Storage::fake('public');

        // Data yang dikirimkan dalam permintaan
        $data = [
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'website' => 'https://example.com',
            'logo' => \Illuminate\Http\UploadedFile::fake()->image('logo.jpg')
        ];

        // Kirim permintaan POST ke rute store
        $response = $this->post(route('company.store'), $data);

        // Asserst: Periksa apakah data berhasil disimpan
        $response->assertRedirect(route('company.index'));
        $response->assertSessionHas('success', 'Data Test Company Berhasil di tambahkan!');

        // Periksa apakah perusahaan disimpan di database
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'email' => 'test@example.com',
            'website' => 'https://example.com',
        ]);
    }

    public function test_it_displays_the_edit_view_with_correct_company_data()
    {
        // Create a company instance to use in the test
        $company = Company::factory()->create();

        // Send a GET request to the edit route for the created company
        $response = $this->get(route('company.edit', $company->id));

        // Assert that the response contains the edit view
        $response->assertStatus(200);
        $response->assertViewIs('admin.company.edit');

        // Assert that the company data is passed to the view
        $response->assertViewHas('company', $company);
    }

    public function test_it_updates_a_company()
    {
        // Arrange: Set up initial company data
        $company = Company::factory()->create();

        // Arrange: Prepare new data for updating the company
        $newName = fake()->company;
        $newEmail = fake()->companyEmail;
        $newWebsite = fake()->url;

        // Arrange: Simulate a new logo file upload
        Storage::fake('public');
        $newLogo = \Illuminate\Http\UploadedFile::fake()->image('logo.jpg');

        // Act: Send a PUT request to update the company
        $response = $this->put(route('company.update', $company->id), [
            'name' => $newName,
            'email' => $newEmail,
            'website' => $newWebsite,
            'logo' => $newLogo
        ]);

        // Assert: Check that the company was updated correctly
        $company->refresh();
        $this->assertEquals($newName, $company->name);
        $this->assertEquals($newEmail, $company->email);
        $this->assertEquals($newWebsite, $company->website);
        Storage::disk('public')->assertExists($company->logo);

        // Assert: Check redirection
        $response->assertRedirect(route('company.index'));
        $response->assertSessionHas('success', 'Data ' . $company->name . ' Berhasil di ubah!');
    }

    public function test_it_deletes_a_company()
    {
        // Arrange: Set up initial company data
        $company = Company::factory()->create();

        // Act: Send a DELETE request to remove the company
        $response = $this->delete(route('company.destroy', $company->id));

        // Assert: Check that the company was deleted
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);

        // Assert: Check redirection
        $response->assertRedirect(route('company.index'));

        // Assert: Check that success message is present in the session
        $response->assertSessionHas('success', 'Data ' . $company->name . ' Berhasil di hapus!');
    }
}
