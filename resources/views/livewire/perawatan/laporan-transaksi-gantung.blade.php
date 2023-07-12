<div wire:init="loadProperties">
    <x-flash />

    <x-card use-default-filter use-loading loading-target="loadProperties">
        <x-slot name="body">
            <x-table :sortColumns="$sortColumns" style="min-width: 100%" sortable zebra hover sticky nowrap>
                <x-slot name="columns">
                    {{-- <x-table.th name="biaya_admin" title="Biaya Admin" /> --}}
                    <x-table.th name="nm_dokter" title="Dr. Dituju" />
                    <x-table.th name="no_rkm_medis" title="No. RM" />
                    <x-table.th name="nm_pasien" title="Nama Pasien" />
                    <x-table.th name="nm_poli" title="Poliklinik" />
                    <x-table.th name="p_jawab" title="P. J." />
                    <x-table.th name="almt_pj" title="Alamat" />
                    <x-table.th name="hubunganpj" title="Hubungan" />
                    <x-table.th name="penjamin" title="Penjamin" />
                    <x-table.th name="stts" title="Status" />
                    <x-table.th name="no_rawat" title="No. Rawat" />
                    <x-table.th name="tgl_registrasi" title="Tgl. Masuk" />
                    <x-table.th name="jam_reg" title="Jam" />
                    <x-table.th name="diagnosa" title="Diagnosa" />
                    <x-table.th name="tindakan" title="Tindakan" />
                    <x-table.th name="obat" title="Obat" />
                    <x-table.th name="lab" title="Laboratorium" />
                    <x-table.th name="rad" title="Radiologi" />
                    {{-- <x-table.th name="kasir" title="Kasir" /> --}}
                    {{-- <x-table.th name="billing" title="Billing" /> --}}
                </x-slot>
                <x-slot name="body">
                    @forelse ($this->dataLaporanTransaksiGantung as $item)
                        <x-table.tr>
                            <x-table.td>{{ $item->nm_dokter }}</x-table.td>
                            <x-table.td>{{ $item->no_rkm_medis }}</x-table.td>
                            <x-table.td>{{ $item->nm_pasien }}</x-table.td>
                            <x-table.td>{{ $item->nm_poli }}</x-table.td>
                            <x-table.td>{{ $item->p_jawab }}</x-table.td>
                            <x-table.td>{{ $item->almt_pj }}</x-table.td>
                            <x-table.td>{{ $item->hubunganpj }}</x-table.td>
                            <x-table.td>{{ $item->penjamin }}</x-table.td>
                            <x-table.td>{{ $item->stts }}</x-table.td>
                            <x-table.td>{{ $item->no_rawat }}</x-table.td>
                            <x-table.td>{{ $item->tgl_registrasi }}</x-table.td>
                            <x-table.td>{{ $item->jam_reg }}</x-table.td>
                            <x-table.td>{{ $item->diagnosa ? 'Ada' : 'Tidak ada' }}</x-table.td>
                            <x-table.td>{{ $item->ralan_perawat ? 'Ada' : 'Tidak ada' }}</x-table.td>
                            <x-table.td>{{ $item->obat ? 'Ada' : 'Tidak ada' }}</x-table.td>
                            <x-table.td>{{ $item->status_order_lab }}</x-table.td>
                            <x-table.td>{{ $item->status_order_rad }}</x-table.td>
                            {{-- <x-table.td>{{ $item->kasir }}</x-table.td> --}}
                            {{-- <x-table.td>{{ $item->billing }}</x-table.td> --}}
                        </x-table.tr>
                    @empty
                        <x-table.tr-empty colspan="17" padding />
                    @endforelse
                </x-slot>
            </x-table>
        </x-slot>
        <x-slot name="footer">
            <x-paginator :data="$this->dataLaporanTransaksiGantung" />
        </x-slot>
    </x-card>
</div>
