<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Keuangan\Jurnal\Jurnal;
use App\Models\Keuangan\Rekening;
use App\Support\Traits\Livewire\ExcelExportable;
use App\Support\Traits\Livewire\Filterable;
use App\Support\Traits\Livewire\FlashComponent;
use App\Support\Traits\Livewire\LiveTable;
use App\Support\Traits\Livewire\MenuTracker;
use App\View\Components\BaseLayout;
use Livewire\Component;
use Livewire\WithPagination;

class BukuBesar extends Component
{
    use WithPagination, FlashComponent, Filterable, ExcelExportable, LiveTable, MenuTracker;

    public $kodeRekening;

    public $tglAwal;

    public $tglAkhir;

    protected function queryString()
    {
        return [
            'kodeRekening' => ['except' => ''],
            'tglAwal' => ['except' => now()->startOfMonth()->format('Y-m-d'), 'as' => 'tgl_awal'],
            'tglAkhir' => ['except' => now()->endOfMonth()->format('Y-m-d'), 'as' => 'tgl_akhir'],
        ];
    }

    public function mount()
    {
        $this->defaultValues();
    }

    /**
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBukuBesarProperty()
    {
        if (empty($this->kodeRekening)) {
            return collect();
        }

        return Jurnal::query()
            ->bukuBesar($this->kodeRekening, $this->tglAwal, $this->tglAkhir)
            ->search($this->cari, [
                'jurnal.tgl_jurnal',
                'jurnal.jam_jurnal',
                'jurnal.no_jurnal',
                'jurnal.no_bukti',
                'jurnal.keterangan',
                'detailjurnal.kd_rek',
                'rekening.nm_rek',
                'detailjurnal.debet',
                'detailjurnal.kredit',
            ])
            ->sortWithColumns($this->sortColumns, [], [
                'tgl_jurnal' => 'asc',
                'jam_jurnal' => 'asc',
            ])
            ->paginate($this->perpage);
    }

    /**
     * @return \App\Models\Keuangan\Jurnal\Jurnal|int
     */
    public function getTotalDebetDanKreditProperty()
    {
        if (empty($this->kodeRekening)) {
            return null;
        }

        return Jurnal::query()
            ->jumlahDebetDanKreditBukuBesar($this->kodeRekening, $this->tglAwal, $this->tglAkhir)
            ->first();
    }

    public function getRekeningProperty()
    {
        return Rekening::query()
            ->orderBy('kd_rek')
            ->pluck('nm_rek', 'kd_rek')
            ->all();
    }

    public function render()
    {
        return view('livewire.keuangan.buku-besar')
            ->layout(BaseLayout::class, ['title' => 'Jurnal Buku Besar']);
    }

    public function exportToExcel()
    {
        if (empty($this->kodeRekening)) {
            $this->flashError('Silahkan pilih rekening terlebih dahulu!');

            return;
        }

        $this->emit('flash.info', 'Proses ekspor laporan dimulai! Silahkan tunggu beberapa saat. Mohon untuk tidak menutup halaman agar proses ekspor dapat berlanjut.');

        // Validasi sebelum proses export dimulai
        $this->validateSheetNames();

        $this->emit('beginExcelExport');
    }

    protected function defaultValues()
    {
        $this->kodeRekening = '';
        $this->tglAwal = now()->startOfMonth()->format('Y-m-d');
        $this->tglAkhir = now()->endOfMonth()->format('Y-m-d');
    }

    protected function dataPerSheet(): array
    {
        $bukuBesar = Jurnal::bukuBesar($this->kodeRekening, $this->tglAwal, $this->tglAkhir)->get();

        return [
            collect($bukuBesar->toArray())
                ->merge([
                    [
                        'tgl_jurnal' => '',
                        'jam_jurnal' => '',
                        'no_jurnal' => '',
                        'no_bukti' => '',
                        'keterangan' => '',
                        'kd_rek' => '',
                        'nm_rek' => 'TOTAL :',
                        'debet' => optional($this->totalDebetDanKredit)->debet,
                        'kredit' => optional($this->totalDebetDanKredit)->kredit,
                    ]
                ])
                ->toArray(),
        ];
    }

    protected function columnHeaders(): array
    {
        return [
            'Tgl.',
            'Jam',
            'No. Jurnal',
            'No. Bukti',
            'Keterangan',
            'Kode',
            'Rekening',
            'Debet',
            'Kredit',
        ];
    }

    protected function pageHeaders(): array
    {
        return [
            'RS Samarinda Medika Citra',
            'Buku Besar rekening ' . $this->rekening[$this->kodeRekening],
            now()->translatedFormat('d F Y'),
            'Periode ' . carbon($this->tglAwal)->translatedFormat('d F Y') . ' s.d. ' . carbon($this->tglAkhir)->translatedFormat('d F Y'),
        ];
    }
}
