@foreach ($mail_disposition_reply as $key => $value)
<div class="row">
    <div class="card social-card share  col-6" data-social="item">
        <div class="circle" data-toggle="tooltip" title="Label" data-container="body">
        </div>
        <div class="card-header clearfix">
            <div class="user-pic">
                <img alt="Profile Image" width="33" height="33" data-src-retina="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" src="/assets/img/profiles/avatar.jpg">
            </div>
            <h5>{{ $value->user->name }}</h5>
            <h6>
                {{ ucwords(strtolower($value->user->satker)) }}
            </h6>
        </div>
        <div class="card-description">
        {!! $value->messages !!}
        <div class="via">{{ $value->created_at }}</div>
        </div>
    </div>
</div>
@endforeach
