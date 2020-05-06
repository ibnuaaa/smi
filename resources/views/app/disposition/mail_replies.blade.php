@foreach ($mail_disposition_reply_mail as $key => $value)
<div class="row">
    <div class="card social-card share  col-6" data-social="item">
        <div class="circle" data-toggle="tooltip" title="Label" data-container="body">
        </div>
        <div class="card-header clearfix">
            <div class="user-pic">
                <img alt="Profile Image" width="33" height="33" data-src-retina="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" src="/assets/img/profiles/avatar.jpg">
            </div>
            <h5>{{ !empty($value->created_user->name) ? $value->created_user->name : '' }}</h5>
            <h6>
                {{ !empty($value->created_user->position->shortname) ? $value->created_user->position->shortname : '' }}
            </h6>
        </div>
        <div class="card-description">
        Membuat <a href='/surat/preview/{{ $value->id }}/surat_keluar' class="btn btn-primary btn-xs">{{ $value->template->name }}</a>
        <div class="via">{{ $value->created_at }}</div>
        </div>
    </div>
</div>
@endforeach
