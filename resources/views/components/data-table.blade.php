<table class="datatable">
    <thead>
    <tr>
        @foreach($columnFields as $column)
            <th style="{{ $column['style'] ?? '' }}">{{ $column['label'] }}</th>
        @endforeach
        @if(isset($actions))
            @foreach($actions as $action)
                <th></th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($items as $item)
        <tr>
            @foreach($columnFields as $column)
                @if ($column['attribute'] instanceof Closure)
                    <td>{!! $column['attribute']($item) !!}</td>
                @else
                    <td>{{ $item[$column['attribute']] }}</td>
                @endif
            @endforeach

            @if(isset($actions))

                @isset($actions['show'])
                    <td>
                        <x-actions.show :url="$actions['show']($item)"/>
                    </td>
                @endisset

                @isset($actions['edit'])
                    <td>
                        <x-actions.edit :url="$actions['edit']($item)"/>
                    </td>
                @endisset

                @isset($actions['destroy'])
                    <td>
                        <x-actions.destroy :url="$actions['destroy']($item)"/>
                    </td>
                @endisset

                @isset($actions['block'])
                    <td>
                        @component('components.actions.block',[
                            'url' => $actions['block']['url']($item),
                            'is_blocked' => $actions['block']['is_blocked']($item),
                        ])@endcomponent
                    </td>
                @endisset
            @endif
        </tr>
    @empty
        <tr class="odd">
            <td
                colspan="{{ isset($actions) ? count($columnFields) + count($actions) : count($columnFields) }}"
                class="dataTables_empty">
                Записи не найдены
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

@isset($perPage)
    {{ $items->onEachSide(2)->withQueryString()->links('components.pagination') }}
@endisset
