<?php

namespace Tests\Feature\Menu;

use App\Livewire\Pages\Aplikasi\ManajemenPintu;
use App\Livewire\Pages\Aplikasi\Modal\InputPintu;
use App\Models\Aplikasi\User;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class ManajemenPintuTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Begin a database transaction
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        // Rollback the database transaction
        DB::rollBack();

        parent::tearDown();
    }

    /**
     * @test
     *
     * @return void
     */

    public function test_super_admin_can_access_manajemen_pintu_page()
    {
        $user = User::findByNRP('240202');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(ManajemenPintu::class)
            ->assertOk();
    }

    public function test_user_with_permission_can_access_manajemen_pintu_page()
    {
        $user = User::findByNRP('180401');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(ManajemenPintu::class)
            ->assertOk();
    }
    
    public function test_user_without_permission_cannot_access_manajemen_pintu_page()
    {
        $user = User::findByNRP('13115');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertNotFound();
    }

    public function test_super_admin_can_access_input_pintu_modal()
    {
        $user = User::findByNRP('240202');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(InputPintu::class);
    }

    public function test_user_with_permission_can_access_input_pintu_modal()
    {
        $user = User::findByNRP('14617');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(InputPintu::class);
    }

    public function test_user_without_permission_cannot_access_input_pintu_modal()
    {
        $user = User::findByNRP('180401');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertDontSeeLivewire(InputPintu::class);
    }

    public function test_super_admin_can_create_pintu()
    {
        $user = User::findByNRP('240202');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(InputPintu::class);

        Livewire::test(InputPintu::class)
            ->set('kodePintu', 'P001')
            ->set('namaPintu', 'Pintu 1')
            ->call('create')
            ->assertEmitted('flash.success', 'Data Pintu baru berhasil disimpan!');

        $this->assertDatabaseHas('manajemen_pintu', [
            'kd_pintu' => 'P001',
            'nm_pintu' => 'Pintu 1',
        ]);
    }

    public function test_super_admin_can_create_pintu_with_poliklinik_and_dokter()
    {
        $user = User::findByNRP('240202');

        $this
            ->actingAs($user)
            ->get(route('admin.antrean.manajemen-pintu'))
            ->assertSeeLivewire(InputPintu::class);

        Livewire::test(InputPintu::class)
            ->set('kodePintu', 'pintu-5')
            ->set('namaPintu', 'Pintu 5')
            ->set('kodePoliklinik', ['U0052', 'U0055'])
            ->set('kodeDokter', ['poppy', 'yanti'])
            ->call('create')
            ->assertEmitted('flash.success', 'Data Pintu baru berhasil disimpan!');

        $this->assertDatabaseHas('manajemen_pintu', [
            'kd_pintu' => 'pintu-5',
            'nm_pintu' => 'Pintu 5',
        ]);

        $this->assertDatabaseHas('pintu_poli', [
            'kd_pintu' => 'pintu-5',
            'kd_poli' => 'U0052',
        ]);

        $this->assertDatabaseHas('pintu_poli', [
            'kd_pintu' => 'pintu-5',
            'kd_poli' => 'U0055',
        ]);

        $this->assertDatabaseHas('dokter_pintu', [
            'kd_pintu' => 'pintu-5',
            'kd_dokter' => 'poppy',
        ]);

        $this->assertDatabaseHas('dokter_pintu', [
            'kd_pintu' => 'pintu-5',
            'kd_dokter' => 'yanti',
        ]);

    }
}