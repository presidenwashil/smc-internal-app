<div wire:init="loadProperties">
    <x-flash />

    <x-card use-loading>
        <x-slot name="header">
            <x-row-col-flex>
                <x-filter.range-date />
                <x-filter.button-export-excel class="ml-auto" />
            </x-row-col-flex>
            <x-row-col-flex class="mt-2">
                <x-filter.label constant-width>Status:</x-filter.label>
                <x-filter.select model="jenisPerawatan" :options="['semua' => 'Semua', 'ralan' => 'Rawat Jalan', 'ranap' => 'Rawat Inap']" selected="semua" />
                <x-filter.label class="ml-auto">Asuransi Pasien:</x-filter.label>
                <x-filter.select2 livewire name="jaminanPasien" show-key class="ml-3" :options="$this->penjamin" selected="-" />
            </x-row-col-flex>
            <x-row-col-flex :class="Arr::toCssClasses([
                'mt-2',
                'pb-3' => auth()->user()->can('keuangan.account-receivable.validasi-piutang'),
            ])">
                <x-filter.select-perpage />
                <x-filter.button-reset-filters class="ml-auto" />
                <x-filter.search class="ml-2" />
            </x-row-col-flex>
            @can('keuangan.account-receivable.validasi-piutang')    
                <x-row-col-flex class="pt-3 border-top">
                    <x-filter.date model="tglBayar" title="Tgl. Bayar" />
                    <x-filter.label class="ml-auto pr-3">Akun pembayaran:</x-filter.label>
                    <x-filter.select
                        model="rekeningAkun"
                        :options="$this->akunBayar"
                        show-key
                    />
                </x-row-col-flex>
                <x-row-col-flex class="mt-2">
                    <x-filter.label constant-width class="font-weight-bold">Dibayar:</x-filter.label>
                    <x-filter.label class="font-weight-bold">{{ rp($this->totalDibayar) }}</x-filter.label>
                    <x-button variant="primary" size="sm" title="Validasi" icon="fas fa-check" wire:click="validasiPiutang" class="ml-auto" />
                </x-row-col-flex>
            @endcan
        </x-slot>
        <x-slot name="body">
            <x-table :sortColumns="$sortColumns" style="width: 200rem" sortable zebra hover sticky nowrap>
                <x-slot name="columns">
                    @can('keuangan.account-receivable.validasi-piutang')
                        <x-table.th-checkbox-all
                            livewire
                            id="ar-cb-all"
                            name="validateCheckbox"
                            lookup="ar-id-"
                            method="pilihSemua"
                        />
                    @endcan
                    <x-table.th style="width: 15ch" name="no_tagihan" title="No. Tagihan" />
                    <x-table.th style="width: 15ch" name="no_rawat" title="No. Rawat" />
                    <x-table.th style="width: 12ch" name="tgl_tagihan" title="Tgl. Tagihan" />
                    <x-table.th style="width: 12ch" name="tgl_jatuh_tempo" title="Tgl. Jatuh Tempo" />
                    <x-table.th style="width: 20ch" name="tgl_bayar" title="Tgl. Bayar" />
                    <x-table.th name="no_rkm_medis" title="No RM" />
                    <x-table.th name="nm_pasien" title="Pasien" />
                    <x-table.th name="penjab_pasien" title="Jaminan Pasien" />
                    <x-table.th name="penjab_piutang" title="Jaminan Akun Piutang" />
                    <x-table.th name="catatan" title="Catatan" />
                    <x-table.th style="width: 12ch" name="status" title="Status Piutang" />
                    <x-table.th name="nama_bayar" title="Nama Bayar" />
                    <x-table.th name="total_piutang" title="Piutang" />
                    <x-table.th name="besar_cicilan" title="Cicilan" />
                    <x-table.th name="sisa_piutang" title="Sisa" />
                    @can('keuangan.account-receivable.validasi-piutang')
                        <x-table.th name="diskon_piutang" title="Diskon (Rp)" />
                    @endcan
                    <x-table.th style="width: 20ch" title="0 - 30" />
                    <x-table.th style="width: 20ch" title="31 - 60" />
                    <x-table.th style="width: 20ch" title="61 - 90" />
                    <x-table.th style="width: 20ch" title="> 90" />
                </x-slot>
                <x-slot name="body">
                    @forelse ($this->dataAccountReceivable as $item)
                        <x-table.tr>
                            @can('keuangan.account-receivable.validasi-piutang')
                                <x-table.td-checkbox
                                    livewire
                                    model="tagihanDipilih"
                                    :id="str_replace('/', '-', implode('_', [$item->no_tagihan, $item->kd_pj_tagihan, $item->no_rawat]))"
                                    :key="implode('_', [$item->no_tagihan, $item->kd_pj_tagihan, $item->no_rawat]) . '.selected'"
                                    prefix="ar-id-"
                                    obscure-checkbox
                                />
                            @endcan
                            <x-table.td>{{ $item->no_tagihan }}</x-table.td>
                            <x-table.td>{{ $item->no_rawat }}</x-table.td>
                            <x-table.td>{{ $item->tgl_tagihan }}</x-table.td>
                            <x-table.td>{{ $item->tgl_jatuh_tempo }}</x-table.td>
                            <x-table.td>{{ $item->tgl_bayar ?? '-' }}</x-table.td>
                            <x-table.td>{{ $item->no_rkm_medis }}</x-table.td>
                            <x-table.td>{{ $item->nm_pasien }}</x-table.td>
                            <x-table.td>{{ $item->penjab_pasien }}</x-table.td>
                            <x-table.td>{{ $item->penjab_tagihan }}</x-table.td>
                            <x-table.td>{{ $item->catatan }}</x-table.td>
                            <x-table.td>{{ $item->status }}</x-table.td>
                            <x-table.td>{{ $item->nama_bayar }}</x-table.td>
                            <x-table.td>{{ rp($item->total_piutang) }}</x-table.td>
                            <x-table.td>{{ rp($item->besar_cicilan) }}</x-table.td>
                            <x-table.td>{{ rp($item->sisa_piutang) }}</x-table.td>
                            <x-table.td>
                                <div class="form-group">
                                    <input
                                        type="number"
                                        class="form-text"
                                        id="{{ 'tagihanDipilih.' . implode('_', [$item->no_tagihan, $item->kd_pj_tagihan, $item->no_rawat]) . '.diskon_piutang' }}"
                                        wire:model.defer="{{ 'tagihanDipilih.' . implode('_', [$item->no_tagihan, $item->kd_pj_tagihan, $item->no_rawat]) . '.diskon_piutang' }}"
                                    >
                                </div>
                            </x-table.td>
                            <x-table.td>{{ $item->umur_hari <= 30 ? rp($item->sisa_piutang) : '-' }}</x-table.td>
                            <x-table.td>{{ is_between($item->umur_hari, 31, 60, true) ? rp($item->sisa_piutang) : '-' }}</x-table.td>
                            <x-table.td>{{ is_between($item->umur_hari, 61, 90, true) ? rp($item->sisa_piutang) : '-' }}</x-table.td>
                            <x-table.td>{{ $item->umur_hari > 90 ? rp($item->sisa_piutang) : '-' }}</x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr-empty :colspan="auth()->user()->can('keuangan.account-receivable.validasi-piutang') ? 20 : 19" padding />
                    @endforelse
                </x-slot>
                <x-slot name="footer">
                    <x-table.tr>
                        <x-table.th :colspan="auth()->user()->can('keuangan.account-receivable.validasi-piutang') ? 12 : 11" />
                        <x-table.th title="TOTAL :" />
                        <x-table.th :title="rp(optional($this->dataTotalAccountReceivable)['totalPiutang'])" />
                        <x-table.th :title="rp(optional($this->dataTotalAccountReceivable)['totalCicilan'])" />
                        <x-table.th :title="rp(optional($this->dataTotalAccountReceivable)['totalSisaCicilan'])" />
                        <x-table.th :title="rp(optional(optional($this->dataTotalAccountReceivable)['totalSisaPerPeriode'])->get('periode_0_30'))" />
                        <x-table.th :title="rp(optional(optional($this->dataTotalAccountReceivable)['totalSisaPerPeriode'])->get('periode_31_60'))" />
                        <x-table.th :title="rp(optional(optional($this->dataTotalAccountReceivable)['totalSisaPerPeriode'])->get('periode_61_90'))" />
                        <x-table.th :title="rp(optional(optional($this->dataTotalAccountReceivable)['totalSisaPerPeriode'])->get('periode_90_up'))" />
                    </x-table.tr>
                </x-slot>
            </x-table>
        </x-slot>
        <x-slot name="footer">
            <x-paginator :data="$this->dataAccountReceivable" />
        </x-slot>
    </x-card>
</div>
