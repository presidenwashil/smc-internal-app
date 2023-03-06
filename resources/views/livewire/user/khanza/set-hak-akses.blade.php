<div>
    @once
        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    $('#modal-khanza-set').on('shown.bs.modal', e => {
                        @this.emit('khanza.show-sha')
                    })

                    $('#modal-khanza-set').on('hide.bs.modal', e => {
                        @this.emit('khanza.hide-sha')
                    })

                    $('#modal-khanza-set').on('hidden.bs.modal', e => {
                        $('#checkbox-utama-khanza-set').prop('checked', false)
                        $('#checkbox-utama-khanza-set').trigger('change')
                    })

                    // $('#checkbox-utama-khanza-set').change(e => {
                    //     let isChecked = e.target.checked
                    //     let els = $('input[type=checkbox][id*=sk-]')

                    //     let checkedHakAkses = new Map()

                    //     els.each((i, el) => {
                    //         el.checked = isChecked

                    //         checkedHakAkses.set(el.value, isChecked)
                    //     })
                        
                    //     if (! isChecked) {
                    //         checkedHakAkses.clear()
                    //     }

                    //     @this.set('checkedHakAkses', Object.fromEntries(checkedHakAkses), true)
                    // })
                })
            </script>
        @endpush
    @endonce
    <x-modal livewire title="Set hak akses user untuk SIMRS Khanza" id="modal-khanza-set">
        <x-slot name="body" class="p-0" style="overflow-x: hidden">
            <x-row-col class="px-3 pt-3">
                <div class="d-flex justify-content-start">
                    <div class="w-100">
                        <label>User:</label>
                        <p>{{ "{$nrp} {$nama}" }}</p>
                    </div>
                </div>
            </x-row-col>
            <x-row class="pt-2">
                <div class="col-12 table-responsive">
                    <x-table>
                        <x-slot name="columns">
                            <x-table.th>
                                <input id="checkbox-utama-khanza-set" type="checkbox" name="__checkbox_utama">
                                <label for="checkbox-utama-khanza-set"></label>
                            </x-table.th>
                            <x-table.th title="Nama Field" />
                            <x-table.th title="Judul Menu" />
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($this->hakAksesKhanza as $hakAkses)
                                <x-table.tr>
                                    <x-table.td>
                                        <input id="sk-{{ $hakAkses->nama_field }}" type="checkbox" wire:model.defer="checkedHakAkses.{{ $hakAkses->nama_field }}">
                                        <label for="sk-{{ $hakAkses->nama_field }}" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; cursor: pointer; margin: 0"></label>
                                    </x-table.td>
                                    <x-table.td>{{ $hakAkses->nama_field }}</x-table.td>
                                    <x-table.td>{{ $hakAkses->judul_menu }}</x-table.td>
                                </x-table.tr>
                            @empty
                                <x-table.tr-empty colspan="3" />
                            @endforelse
                        </x-slot>
                    </x-table>
                </div>
            </x-row>
        </x-slot>
        <x-slot name="footer" class="justify-content-start">
            <x-filter.search method="$refresh" />
            <x-filter.toggle class="ml-1" id="show-checked-khanza-set" title="Tampilkan yang dipilih" model="showChecked" />
            <x-button class="btn-default ml-auto" data-dismiss="modal" title="Batal" />
            <x-button class="btn-primary ml-2" data-dismiss="modal" wire:click="$emit('khanza.simpan')" title="Simpan" icon="fas fa-save" />
        </x-slot>
    </x-modal>
</div>
