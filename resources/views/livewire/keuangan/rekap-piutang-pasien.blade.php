<div>
    <x-flash />

    <x-card>
        <x-slot name="header">
            <x-card.row-col>
                <x-filter.range-date />
                <x-filter.button-export-excel class="ml-auto" />
            </x-card.row-col>
            <x-card.row-col class="mt-2">
                <x-filter.select-perpage />
                <x-filter.label class="ml-auto" constant-width>Penjamin:</x-filter.label>
                <x-filter.select2 name="caraBayar" model="caraBayar" :options="$this->penjamin" placeholder="-" style="width: 16rem" />
            </x-card.row-col>
            <x-card.row-col class="mt-2">
                <span class="text-sm" style="width: 5rem">TOTAL:</span>
                <span class="text-sm font-weight-bold">{{ rp($this->totalTagihanPiutangPasien) }}</span>
                <x-filter.button-reset-filters class="ml-auto" />
                <x-filter.search class="ml-2" />
            </x-card.row-col>
        </x-slot>
        <x-slot name="body" class="table-responsive">
            <x-table style="min-width: 100%; width: 100rem" sortable :sortColumns="$sortColumns">
                <x-slot name="columns">
                    <x-table.th name="no_rawat" title="No. Rawat" />
                    <x-table.th name="no_rkm_medis" title="No. RM" />
                    <x-table.th name="nm_pasien" title="Pasien" />
                    <x-table.th name="tgl_piutang" title="Tgl. Piutang" />
                    <x-table.th name="status" title="Status" />
                    <x-table.th name="total" title="Total" />
                    <x-table.th name="uang_muka" title="Uang Muka" />
                    <x-table.th name="terbayar" title="Terbayar" />
                    <x-table.th name="sisa" title="Sisa" />
                    <x-table.th name="tgltempo" title="Tgl. Jatuh Tempo" />
                    <x-table.th name="penjamin" title="Penjamin" />
                </x-slot>
                <x-slot name="body">
                    @forelse ($this->piutangPasien as $data)
                        <x-table.tr>
                            <x-table.td>{{ $data->no_rawat }}</x-table.td>
                            <x-table.td>{{ $data->no_rkm_medis }}</x-table.td>
                            <x-table.td>{{ $data->nm_pasien }}</x-table.td>
                            <x-table.td>{{ $data->tgl_piutang }}</x-table.td>

                            <x-table.td>{{ $data->status }}</x-table.td>
                            <x-table.td>{{ rp($data->total) }}</x-table.td>
                            <x-table.td>{{ rp($data->uang_muka) }}</x-table.td>
                            <x-table.td>{{ rp($data->terbayar) }}</x-table.td>

                            <x-table.td>{{ rp($data->sisa) }}</x-table.td>
                            <x-table.td>{{ $data->tgltempo }}</x-table.td>
                            <x-table.td>{{ $data->penjamin }}</x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr-empty colspan="11" />
                    @endforelse
                </x-slot>
            </x-table>
        </x-slot>
        <x-slot name="footer">
            <x-paginator :data="$this->piutangPasien" />
        </x-slot>
    </x-card>
</div>
