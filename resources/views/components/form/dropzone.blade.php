<div class="pointer" style="top: 0px;position:absolute;right: 0px;padding: 10px;z-index: 9999999;" id="{{ $id }}-remove-files">
    <i class="fas fa-refresh"></i> {{ isset($removeLabel) ? $removeLabel : 'Remove all files' }}
</div>
<div id="{{ $id }}" class="dropzone no-margin dz-clickable" style="{{ $style }}">
    <div class="dz-default dz-message"><span>{{ $value }}</span></div>
</div>
<div id="{{ $id }}-preview" class="dz-upload-preview-image empty">
    <div style="padding: 10px 0px;background: white;">
        <span style="font-size:24px">PREVIEW</span>
    </div>
    <img class="img-fluid"/>
</div>
