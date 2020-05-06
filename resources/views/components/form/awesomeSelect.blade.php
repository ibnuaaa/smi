<select class="{{ !empty($class) ? $class : 'full-width'  }}" {!! isset($placeholder) ? 'data-placeholder="'.$placeholder.'"' : '' !!} name="{{ isset($name) ? $name : 'unknown' }}" data-init-plugin="select2" {{ isset($multiple) && $multiple ? 'multiple' : '' }} {!! isset($search) && $search ? '' : "data-minimum-results-for-search=\"Infinity\"" !!} data-link="/user" >
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
                    <option value="{{ $item['value'] }}" {{ !empty($item['dataset']) ? $item['dataset'] : '' }} selected>{{ $item['label'] }}</option>
                @else
                    <option value="{{ $item['value'] }}" {{ !empty($item['dataset']) ? $item['dataset'] : '' }}>{{ $item['label'] }}</option>
                @endif
            @else
                @if ($item['value'] == $selected)
                    <option value="{{ $item['value'] }}" {{ !empty($item['dataset']) ? $item['dataset'] : '' }} selected>{{ $item['label'] }}</option>
                @else
                    <option value="{{ $item['value'] }}" {{ !empty($item['dataset']) ? $item['dataset'] : '' }}>{{ $item['label'] }}</option>
                @endif
            @endif

        @endforeach
    @endif
</select>
