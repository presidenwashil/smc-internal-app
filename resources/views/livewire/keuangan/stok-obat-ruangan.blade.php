<div>
    <x-flash />

    <x-card>
        <x-slot name="header">
            <x-card.row-col>
                <x-filter.label constant-width>Ruangan :</x-filter.label>
                <x-filter.select2 name="bangsal" />
                <div class="w-25" wire:ignore>
                    <select class="form-control form-control-sm simple-select2-sm input-sm" id="bangsal" autocomplete="off">
                        <option value="-">-</option>
                        @foreach ($this->bangsal as $kode => $nama)
                            <option value="{{ $kode }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <x-filter.button-export-excel class="ml-auto" />
            </x-card.row-col>
            <x-card.row-col class="mt-2">
                <x-filter.select-perpage :constantWidth="true" />
                <x-filter.button-reset-filters class="ml-auto" />
                <x-filter.search class="ml-2" />
            </x-card.row-col>
        </x-slot>
        <x-slot name="body" class="table-responsive">
            <x-table sortable :sortColumns="$sortColumns">
                <x-slot name="columns">
                    <x-table.th name="nm_bangsal" title="Ruangan" />
                    <x-table.th name="kode_brng" title="Kode" />
                    <x-table.th name="nama_brng" title="Nama" />
                    <x-table.th name="satuan" title="Satuan" />
                    <x-table.th name="stok" title="Stok saat ini" />
                    <x-table.th name="h_beli" title="Harga" />
                    <x-table.th name="projeksi_harga" title="Projeksi Harga" />
                </x-slot>
                <x-slot name="body">
                    @foreach ($this->stokObatPerRuangan as $obat)
                        <x-table.tr>
                            <x-table.td>{{ $obat->nm_bangsal }}</x-table.td>
                            <x-table.td>{{ $obat->kode_brng }}</x-table.td>
                            <x-table.td>{{ $obat->nama_brng }}</x-table.td>
                            <x-table.td>{{ $obat->satuan }}</x-table.td>
                            <x-table.td>{{ $obat->stok }}</x-table.td>
                            <x-table.td>{{ rp($obat->h_beli) }}</x-table.td>
                            <x-table.td>{{ rp($obat->projeksi_harga) }}</x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-slot>
            </x-table>
        </x-slot>
        <x-slot name="footer">
            <x-paginator :data="$this->stokObatPerRuangan" />
        </x-slot>
    </x-card>
</div>
