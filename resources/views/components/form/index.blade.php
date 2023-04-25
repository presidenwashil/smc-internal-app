@props([
    'livewire' => false,
    'submit' => null,

    'action' => null,
    'method' => 'POST',
    'files' => false,
])

@php
    $methodHTML = 'POST';

    if ((string) str($method)->upper() === 'GET') {
        $methodHTML = 'GET';
    }
@endphp

<form {{ $attributes
    ->merge(['method' => $methodHTML])
    ->when($files, fn ($attr) => $attr->merge(['enctype' => 'multipart/form-data']))
    ->when($livewire, fn ($attr) => $attr->merge(['wire:submit.prevent' => $submit]))
    ->when(!$livewire && !is_null($action), fn ($attr) => $attr->merge(compact('action')))
}}>
    @csrf
    @method($method)
    {{ $slot }}
</form>