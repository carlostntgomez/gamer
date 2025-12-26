@php
    $state = $getState();
@endphp

@if (is_array($state) && count($state) > 0)
    <dl>
        @foreach ($state as $key => $value)
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; padding-bottom: 0.5rem;">
                <dt style="font-weight: 600;">{{ $key }}</dt>
                <dd>{{ $value }}</dd>
            </div>
        @endforeach
    </dl>
@endif
