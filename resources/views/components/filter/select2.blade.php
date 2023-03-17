@props([
    'name',
    'options',
    'model' => null,
    'placeholder' => null,
    'placeholderValue' => null,
    'resetOn' => 'button#reset-filter',
    'selected' => null,
])

@php
    $id = Str::slug($name);
    $title = Str::camel($name);

    $isList = ! Arr::isAssoc($options);
@endphp

@once
    @push('css')
        <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet">
    @endpush
    @push('js')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            let dropdownSelect2 = $('select#{{ Str::slug($name) }}')

            $(document).on('DOMContentLoaded', e => {
                dropdownSelect2.select2({
                    dropdownCssClass: 'text-sm px-0',
                })

                @notnull($model)
                    Livewire.hook('element.updated', (el, component) => {
                        dropdownSelect2.select2({
                            dropdownCssClass: 'text-sm px-0',
                        })
                    })

                    dropdownSelect2.on('select2:select', e => {
                        @this.set('{{ $model }}', dropdownSelect2.val(), true)
                    })

                    dropdownSelect2.on('select2:unselect', e => {
                        @this.set('{{ $model }}', dropdownSelect2.val(), true)
                    })
                @endnotnull

                @notnull($resetOn)
                    $('{{ $resetOn }}').click(e => {
                        dropdownSelect2.val('')

                        dropdownSelect2.trigger('change')
                    })
                @endnotnull
            })
        </script>
    @endpush
@endonce

<div wire:ignore {{ $attributes->whereDoesntStartWith('wire:') }}>
    <select class="form-control form-control-sm simple-select2-sm input-sm" id="{{ $id }}" autocomplete="off" name="{{ $name }}">
        @if ($placeholder)
            <option value="{{ $placeholderValue }}">{{ $placeholder }}</option>
        @endif
        @forelse ($options as $key => $value)
            <option value="{{ $key }}">{{ $key }} - {{ $value }}</option>
        @empty
            <option disabled>---NO DATA---</option>
        @endforelse
    </select>
</div>
