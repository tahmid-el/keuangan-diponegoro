<?php

namespace Tests\Feature;

use App\Models\Gaji;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GajiTest extends TestCase
{
    use RefreshDatabase;

    protected $bendahara;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bendahara = User::factory()->create([
            'role' => 'bendahara',
            'email' => 'bendahara@test.com',
        ]);
    }

    public function test_bendahara_can_view_gaji_index()
    {
        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.gaji.index'));

        $response->assertStatus(200);
        $response->assertViewIs('bendahara.gaji.index');
    }

    public function test_bendahara_can_create_gaji()
    {
        $data = [
            'nama' => 'Ahmad Dahlan',
            'jumlah_jam' => 40,
            'bisyaroh' => 150000,
            'tunjangan_kamad_wk' => 500000,
            'tunjangan_piket' => 200000,
        ];

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.gaji.store'), $data);

        $response->assertRedirect(route('bendahara.gaji.index'));
        $this->assertDatabaseHas('gajis', [
            'nama' => 'Ahmad Dahlan',
            'jumlah_jam' => 40,
            'bisyaroh' => 150000,
            'jumlah' => 850000,
        ]);
    }

    public function test_jumlah_is_calculated_automatically()
    {
        $gaji = Gaji::create([
            'nama' => 'Budi Santoso',
            'jumlah_jam' => 20,
            'bisyaroh' => 100000,
            'tunjangan_kamad_wk' => 300000,
            'tunjangan_piket' => 100000,
        ]);

        $this->assertEquals(500000, $gaji->jumlah);
    }

    public function test_bendahara_can_update_gaji()
    {
        $gaji = Gaji::create([
            'nama' => 'Citra Dewi',
            'jumlah_jam' => 30,
            'bisyaroh' => 120000,
            'tunjangan_kamad_wk' => 400000,
            'tunjangan_piket' => 150000,
        ]);

        $data = [
            'nama' => 'Citra Dewi Updated',
            'jumlah_jam' => 35,
            'bisyaroh' => 130000,
            'tunjangan_kamad_wk' => 450000,
            'tunjangan_piket' => 180000,
        ];

        $response = $this->actingAs($this->bendahara)
            ->put(route('bendahara.gaji.update', $gaji->id), $data);

        $response->assertRedirect(route('bendahara.gaji.index'));
        $this->assertDatabaseHas('gajis', [
            'id' => $gaji->id,
            'nama' => 'Citra Dewi Updated',
            'jumlah' => 760000,
        ]);
    }

    public function test_bendahara_can_delete_gaji()
    {
        $gaji = Gaji::create([
            'nama' => 'Delete Test',
            'jumlah_jam' => 10,
            'bisyaroh' => 50000,
            'tunjangan_kamad_wk' => 100000,
            'tunjangan_piket' => 50000,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->delete(route('bendahara.gaji.destroy', $gaji->id));

        $response->assertRedirect(route('bendahara.gaji.index'));
        $this->assertDatabaseMissing('gajis', ['id' => $gaji->id]);
    }

    public function test_gaji_appears_in_pengeluaran_form_when_kategori_is_gaji()
    {
        $gaji = Gaji::create([
            'nama' => 'Test Guru',
            'jumlah_jam' => 20,
            'bisyaroh' => 100000,
            'tunjangan_kamad_wk' => 200000,
            'tunjangan_piket' => 100000,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.pengeluaran.create'));

        $response->assertStatus(200);
    }
}
