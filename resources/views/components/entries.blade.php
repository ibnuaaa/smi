<style>
.sort{
    width: auto ;
    text-align:left ;
    float:left;
}
.sort .select{
    line-height: 1.5;
    display: inline-block!important;
    vertical-align: middle;
}
.sort p {
    padding-top:10px;
    padding-left:0px;
    display: inline-block!important;
    vertical-align: middle;
}
</style>
<div class="sort">
    <p>Show</p>
    <div class="select">
        <form />
        <select name="user-table-show"  onchange="this.form.submit()">
            @foreach ($options as $option) {
                @if($option == $selected){
                    <option selected='selected' >{{$option}} </option>
                }
                @else{
                    <option> {{$option}} </option>
                    }
                @endif
            }
            @endforeach
        </select>
    </div>
    <p>Entries</p>
</div>