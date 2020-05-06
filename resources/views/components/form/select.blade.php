<select class="cs-select cs-skin-slide" name="{{ isset($name) ? $name : 'unknown' }}" data-init-plugin="cs-select">
    @if (isset($items))
        @if (isset($placeholder))
            <option value="">{{ $placeholder }}</option>
        @endif
        @if (isset($option_all))
            <option value="{{ $option_all['value'] }}">{{ $option_all['label'] }}</option>
        @endif
        @foreach ($items as $item)
            @if (is_array($selected))
                @if (in_array($item['value'], $selected))
                    <option value="{{ $item['value'] }}" selected>{{ $item['label'] }}</option>
                @else
                    <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                @endif
            @else
                @if ($item['value'] == $selected)
                    <option value="{{ $item['value'] }}" selected>{{ $item['label'] }}</option>
                @else
                    <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                @endif
            @endif

        @endforeach
    @endif
</select>
