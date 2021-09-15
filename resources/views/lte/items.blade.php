@if (empty($item['submenu']))
    <li @if (!empty($item['class'])) class="{{ $item['class'] }}" @endif>
        @if (is_array($item['route']))
            <a href="{{ route($item['route'][0], $item['route'][1]) }}">
                <i class="{{ $item['icon'] }}"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $item['title'] }}</span>
            </a>
        @else
            <a href="{{ route($item['route']) }}">
                <i class="{{ $item['icon'] }}"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $item['title'] }}</span>
                @if (isset($item['label']))
                    @if (is_array($item['label']))
                        @foreach($item['label'] as $color => $value)
                            &nbsp;<span class="label label-{{ $color }}">{{ $value }}</span>
                        @endforeach
                    @else
                        &nbsp;&nbsp;<span class="label label-danger">{{ $item['label'] }}</span>
                    @endif
                @endif
            </a>
        @endif
    </li>
@else
    <li class="treeview">
        <a href="#">
            <i class="{{ $item['icon'] }}"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $item['title'] }}</span>
            @if (isset($item['label']))
                @if (is_array($item['label']))
                    @foreach($item['label'] as $color => $value)
                        &nbsp;&nbsp;<span class="label label-{{ $color }}">{{ $value }}</span>
                    @endforeach
                @else
                    &nbsp;&nbsp;<span class="label label-danger">{{ $item['label'] }}</span>
                @endif
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

