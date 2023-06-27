<?php

namespace App\Http\Livewire\Aplikasi\Concerns;

use App\Models\Keuangan\RKAT\AnggaranBidang;
use App\Rules\DoesntExist;
use App\Settings\PengaturanRKAT as SettingsPengaturanRKAT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;
use Illuminate\View\Component;

trait PengaturanRKAT
{
    /** @var string */
    public $tahunRKAT;

    /** @var string */
    public $tglAwalPenetapanRKAT;

    /** @var string */
    public $tglAkhirPenetapanRKAT;

    public function mountPengaturanRKAT(): void
    {
        $this->defaultValuesPengaturanRKAT();
    }

    public function getDataTahunProperty(): array
    {
        $firstRKAT = AnggaranBidang::query()
            ->orderBy('tahun', 'asc')
            ->limit(1)
            ->value('tahun');

        return collect(range($firstRKAT, (int) now()->addYears(5)->format('Y'), 1))
            ->mapWithKeys(fn (int $v, $_): array => [$v => $v])
            ->all();
    }

    public function updatePengaturanRKAT(): void
    {
        if (!Auth::user()->hasRole(config('permission.superadmin_name'))) {
            $this->emit('flash.error', 'Anda tidak diizinkan untuk melakukan tindakan ini!');
            $this->dispatchBrowserEvent('pengaturan-rkat.data-denied');

            return;
        }

        $settings = app(SettingsPengaturanRKAT::class);

        $validated = $this->validate([
            'tahunRKAT' => ['required', new DoesntExist],
            'tglAwalPenetapanRKAT' => ['required', 'date'],
            'tglAkhirPenetapanRKAT' => ['required', 'date'],
        ], [
            'tahunRKAT.' . DoesntExist::class => 'Tahun RKAT tersebut sudah ada anggarannya!',
        ]);

        $validated = new Fluent($validated);

        $settings->tahun = $validated->tahunRKAT;
        $settings->tgl_awal = carbon($validated->tglAwalPenetapanRKAT);
        $settings->tgl_akhir = carbon($validated->tglAkhirPenetapanRKAT);

        $settings->save();

        $this->emit('flash.success', 'Pengaturan RKAT berhasil diupdate!');
        $this->dispatchBrowserEvent('pengaturan-rkat.data-saved');
    }

    protected function defaultValuesPengaturanRKAT(): void
    {
        $settings = app(SettingsPengaturanRKAT::class);

        $this->tahunRKAT = $settings->tahun;
        $this->tglAwalPenetapanRKAT = $settings->tgl_awal->format('Y-m-d');
        $this->tglAkhirPenetapanRKAT = $settings->tgl_akhir->format('Y-m-d');
    }
}