<div>
    @push('js')
        <script>
            $('#modal-input-pelaporan-rkat').on('shown.bs.modal', e => {
                @this.emit('pelaporan-rkat.show-modal')
            })

            $('#modal-input-pelaporan-rkat').on('hide.bs.modal', e => {
                @this.emit('pelaporan-rkat.hide-modal')
            })
        </script>
    @endpush
    <x-modal id="modal-input-pelaporan-rkat" :title="$this->isUpdating() ? 'Edit Kategori Anggaran' : 'Tambah Kategori Anggaran Baru'" livewire centered>
        <x-slot name="body" class="p-0" style="overflow-x: hidden">
            <x-form id="form-input-pelaporan-rkat" livewire :submit="$anggaranBidangId !== -1 ? 'update' : 'create'">
                <x-row-col class="sticky-top bg-white py-1 px-3">
                    <div class="form-group mt-3">
                        <label for="anggaran-bidang-id">Anggaran bidang digunakan:</label>
                        <x-form.select2 
                            livewire
                            name="anggaranBidangId"
                            :options="$this->dataRKATPerBidang"
                            :selected="$anggaranBidangId"
                            width="full-width"
                        />
                    </div>
                    <div class="form-group mt-3">
                        <label for="tgl-pemakaian">Tgl. Pemakaian</label>
                        <x-form.date model="tglPakai" />
                    </div>
                    <div class="form-group mt-3">
                        <label for="nominal-anggaran">Nominal</label>
                        <input type="text" id="nominal-anggaran" wire:model.defer="nama" class="form-control form-control-sm" />
                    </div>
                    <div class="form-group mt-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" wire:model.defer="deskripsi" class="form-control form-control-sm"></textarea>
                    </div>
                </x-row-col>
            </x-form>
        </x-slot>
        <x-slot name="footer" class="justify-content-start">
            <x-button size="sm" class="ml-auto" data-dismiss="modal" id="batalsimpan" title="Batal" />
            <x-button size="sm" variant="primary" type="submit" class="ml-2" id="simpandata" title="Simpan" icon="fas fa-save" form="form-input-pelaporan-rkat" />
        </x-slot>
    </x-modal>
</div>
