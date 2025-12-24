@php
    $specifications = $getRecord()->specifications;
@endphp

@if (!empty($specifications) && is_array($specifications))
    <div class="fi-in-entry-wrp">
        <div class="text-sm">
            <table class="w-full text-left rtl:text-right">
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @foreach ($specifications as $key => $value)
                        <tr class="fi-in-text-entry">
                            <td class="px-3 py-2 w-1/3">
                                <strong class="text-gray-950 dark:text-white">{{ $key }}</strong>
                            </td>
                            <td class="px-3 py-2">
                                <span class="text-gray-950 dark:text-white">{{ $value }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="fi-in-entry-wrp">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            No hay especificaciones disponibles.
        </div>
    </div>
@endif
