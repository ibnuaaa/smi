<style>
.table-search{
    width:20%;
    float:right;
}
.btn-cons{
    margin-right:0px;
}
.form-group-default {
    border-radius:0px!important;
}
.btn-search{
    border-radius:0px!important;
    margin-bottom:1px!important;
}
</style>

<button id="filterAction" class="btn btn-block btn-info btn-cons m-b-10 btn-search" style="width:10%;height:34px;float:right;"><i class="fas fa-search"></i> Search</button>
    <div class="form-group form-group-default table-search">
        <input name="filter_search" value="{{ $filter_search }}" class="form-control" type="text" >
    </div>
