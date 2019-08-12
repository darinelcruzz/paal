@if (empty($item['submenu']))
    <li @if (!empty($item['class'])) class="{{ $item['class'] }}" @endif>
        <a href="{{ route($item['route']) }}">
            <i class="{{ $item['icon'] }}"></i> <span>{{ $item['title'] }}</span>
        </a>
    </li>
@else
    <li class="treeview">
        <a href="#">
            <i class="{{ $item['icon'] }}"></i> <span>{{ $item['title'] }}</span>
            @if (isset($item['label']) && pendingShippings() > 0)
                &nbsp;&nbsp;<span class="label label-danger">{{ $item['label'] }}</span>
            @endif
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @foreach ($item['submenu'] as $subitem)
                <li>
                    @if (is_array($subitem['route']))
                        <a href="{{ route($subitem['route'][0], $subitem['route'][1]) }}">{{ $subitem['title'] }}</a>
                    @else
                        <a href="{{ route($subitem['route']) }}">{{ $subitem['title'] }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </li>
@endif
