<div class="checkbox check-success">
    <input type="checkbox" {!! isset($checked) && $checked ? "checked=\"checked\"" : '' !!} value="{{ $value }}">
    <label for="checkbox2">{{ $label }}</label>
</div>
