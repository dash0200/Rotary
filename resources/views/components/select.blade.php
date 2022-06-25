@props(['options'])

{{-- @php
$options = [1 => 'one', 2 => 'two', 3 => 'three'];
@endphp --}}

<select name='types' placeholder='Select'>
    {{$slot}}
</select>