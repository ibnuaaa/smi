<?php

if (! function_exists('message')) {
    function message($id = null, $replace = [], $locale = null, $autoCapitalize = true) {
        if (is_null($id)) {
            return app('translator');
        }
        foreach ($replace as $key => $value) {
            if ($key === 'attribute') {
                $replace[$key] = app('translator')->trans('validation.attributes.'.$value, [], $locale);
            }
        }
        $message = app('translator')->trans($id, $replace, $locale);
        if ($autoCapitalize) {
            return ucfirst($message);
        }
        return $message;
    }
}

if (! function_exists('message_choice')) {
    function message_choice($id, $number, array $replace = [], $locale = null)
    {
        return app('translator')->transChoice($id, $number, $replace, $locale);
    }
}

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('getTable'))
{
    function getTable($Model)
    {
        return with(new $Model())->getTable();
    }
}

if ( ! function_exists('getPrefix'))
{
    function getPrefix($TableName = '')
    {
        return config('database.connections.mysql.prefix') . $TableName;
    }
}

if ( ! function_exists('QueryRoute'))
{
    function QueryRoute($request)
    {
        $QueryRoute = new \App\Support\QueryRoute($request);
        return $QueryRoute->get();
    }
}

if ( ! function_exists('now'))
{
    function now()
    {
        return \Carbon\Carbon::now();
    }
}

if ( ! function_exists('carbon_parse'))
{
    function carbon_parse($date)
    {
        return \Carbon\Carbon::parse($date);
    }
}

if ( ! function_exists('set_if_false'))
{
    function set_if_false($new, $old)
    {
        if ($new) {
            return $new == $old;
        }
        return true;
    }
}

if ( ! function_exists('is_updated'))
{
    function is_updated($changes, $thing)
    {
        return isset($changes[$thing]);
    }
}

if ( ! function_exists('getPayloadChanges'))
{
    function getPayloadChanges($payload)
    {
        if (isset($payload->all()['Changes'])) {
            return $payload->all()['Changes'];
        }
        return [];
    }
}

if ( ! function_exists('getDirty'))
{
    function getDirty($Model)
    {
        return $Model->getDirty();
    }
}

if ( ! function_exists('isModelChanged'))
{
    function isModelChanged($Model, $thing)
    {
        if (isset($Model->getDirty()[$thing])) {
            return true;
        }
        return false;
    }
}

if ( ! function_exists('___TableGetCurrentPage'))
{
    function ___TableGetCurrentPage($request, $TableKey)
    {
        $CurrentPage = (int)$request->input($TableKey.'-page');
        if (!$CurrentPage) {
            $CurrentPage = (int)1;
        } else {
            $CurrentPage = (int)$CurrentPage;
        }
        return $CurrentPage;
    }
}

if ( ! function_exists('___TablePaginate'))
{
    function ___TablePaginate($total, $limit, $now)
    {
        $paginationNumber = [];
        $adjacents = 2;
        $pages = $limit ? ceil($total / $limit) : 0;
        if ($pages) {
            if ($pages < 7 + ($adjacents * 2)) {
                for ($i = 1; $i <= $pages; $i++) {
                    $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                }
            } else if ($pages > 5 + ($adjacents * 2)) {
                if ($now < 1 + ($adjacents * 2)) {
                    for ($i = 1; $i < 4 + ($adjacents * 2); $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    $paginationNumber[] = [ 'page' => $pages, 'name' => $pages ];
                } else if($pages - ($adjacents * 2) > $now && $now > ($adjacents * 2)) {
                    $paginationNumber[] = [ 'page' => 1, 'name' => 1 ];
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    for ($i = $now - $adjacents; $i <= $now + $adjacents ; $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    $paginationNumber[] = [ 'page' => $pages, 'name' => $pages ];
                } else {
                    $paginationNumber[] = [ 'page' => 1, 'name' => 1 ];
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    for ($i = $pages - (2 + ($adjacents * 2)); $i <= $pages; $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                }
            }
        }
        $table = [
            'pages' => $pages,
            'paginationNumber' => $paginationNumber
        ];
        $table['startentries'] = $total > 0 ? ((($now - 1 ) * $limit) + 1) : 0;
        $table['endentries'] = $table['startentries'] + ($limit - 1);
        if ($table['endentries'] > $total){
            $table['endentries'] = $total;
        }
        return (object)$table;
    }
}

if ( ! function_exists('___TableGetSkip'))
{
    function ___TableGetSkip($request, $TableKey, $take = 10)
    {
        $Skip = (int)$request->input($TableKey.'-page');
        if (!$Skip) {
            $Skip = (int)0;
        } else {
            $Skip = (int)$Skip * (int)$take - (int)$take;
        }
        return $Skip;
    }
}

if ( ! function_exists('___TableGetFilterSearch'))
{
    function ___TableGetFilterSearch($request, $TableKey)
    {
        return $request->input("$TableKey-filter_search");
    }
}

if ( ! function_exists('___TableGetTake'))
{
    function ___TableGetTake($request, $TableKey)
    {
        return $request->input("$TableKey-take") ? $request->input("$TableKey-take") : 10;
    }
}

if ( ! function_exists('___TableGetRefreshAction'))
{
    function ___TableGetRefreshAction($request, $TableKey)
    {
        $IsRefesh = false;
        $refresh = $request->input("$TableKey-refresh");
        if ($refresh && $refresh === 'true') {
            $IsRefesh = true;
        }
        return $IsRefesh;
    }
}

if ( ! function_exists('___TableGetQuery'))
{
    function ___TableGetQuery($request, $TableKey)
    {
        $Take = ___TableGetTake($request, $TableKey);
        $Skip = ___TableGetSkip($request, $TableKey, $Take);
        $CurrentPage = ___TableGetCurrentPage($request, $TableKey);
        $FilterSearch = ___TableGetFilterSearch($request, $TableKey);
        $IsRefesh = ___TableGetRefreshAction($request, $TableKey);
        return (object)[
            'take' => $Take,
            'skip' => $Skip,
            'currentPage' => $CurrentPage,
            'filterSearch' => $FilterSearch,
            'isRefesh' => $IsRefesh,
        ];
    }
}



if ( ! function_exists('UrlPrevious'))
{
    function UrlPrevious($urlBackup = null)
    {
        $referer = null;
        $host = null;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        }
        if (!$referer && $urlBackup) {
            $referer = $urlBackup;
        }
        if ($referer === \URL::full()) {
            $referer = $urlBackup ? $urlBackup : url();
        }
        return $referer;
    }
}

if ( ! function_exists('MyAccount'))
{
    function MyAccount($urlBackup = null)
    {
        return Auth::user();
    }
}

function getMenuCounter($Id)
{
    return \App\Support\Counter::getCount($Id);
}

if ( ! function_exists('FormSelect'))
{
    function FormSelect($Data, $toArray = false, $value = 'id', $label = 'name')
    {
        $options = $Data->map(function($item) use($value, $label) {
            return [ 'value' => $item->{$value}, 'label' => $item->{$label} ];
        });
        if ($toArray) {
            return $options->toArray();
        }
        return $options;
    }
}

// Browse Helper
if ( ! function_exists('BrowseData'))
{
    function BrowseData($Browse)
    {
        return $Browse->original['data'];
    }
}

// Satellite Helper
if ( ! function_exists('SatelliteClient'))
{
    function SatelliteClient()
    {
        return new App\Support\Satellite\Client();
    }
}

// URL Helper
if ( ! function_exists('baseUrl'))
{
    function baseUrl($extra)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $extra = ltrim($extra, '/');
        return env('BASE_URL', $actual_link).'/'.$extra;
    }
}

// URL Helper
if ( ! function_exists('fullUrl'))
{
    function fullUrl()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }
}

if ( ! function_exists('fullUri'))
{
    function fullUri($QueryString = [], $DeleteQuery = [], $withFullUrl = false)
    {
        $Qs = $_SERVER['QUERY_STRING'];
        parse_str($Qs, $QsArr);
        $MergedQuery = array_merge($QsArr, $QueryString);
        foreach ($DeleteQuery as $DeleteQueryKey) {
            if (isset($MergedQuery[$DeleteQueryKey])) {
                unset($MergedQuery[$DeleteQueryKey]);
            }
        }
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        if (count($MergedQuery) > 0) {
            $url .= '?'.http_build_query($MergedQuery);
        }
        if ($withFullUrl) {
            return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";
        }
        return $url;
    }
}

if ( ! function_exists('likeMatch'))
{
    function likeMatch($pattern, $subject)
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }
}

if ( ! function_exists('searchData'))
{
    function searchData($Data, $Search = '', $SearchField = '*')
    {
        $filtered = $Data->filter(function ($value, $key) use($Search, $SearchField) {
            $filtered = array_filter($value, function($v, $k) use($Search, $SearchField) {
                if (is_array($SearchField)) {
                    if (in_array($k, $SearchField)) {
                        return likeMatch("%$Search%", $v);
                    } else {
                        return false;
                    }
                } else {
                    return likeMatch("%$Search%", $v);
                }
            }, ARRAY_FILTER_USE_BOTH);
            return count($filtered) > 0;
        });
        return $filtered;
    }
}

if ( ! function_exists('__GETACCSERVICE'))
{
    function __GETACCSERVICE($TableKey, $FLAG_ACTION, $REFRESH = false)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($FLAG_ACTION) {
            $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'doSendDataVerifyCMS' => [
                        'FLAG_ACTION' => $FLAG_ACTION
                    ]
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}

if ( ! function_exists('__GETACCSERVICETABLEPARAMS'))
{
    function __GETACCSERVICETABLEPARAMS($TableKey, $PARAMS, $REFRESH = false, $REDIRECT = true)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($PARAMS) {
            $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'doSendDataVerifyCMS' => $PARAMS
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH && $REDIRECT) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}

if ( ! function_exists('__GETACCSERVICEWITHPARAMS'))
{
    function __GETACCSERVICEWITHPARAMS($PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataVerifyCMS' => $PARAMS
            ]
        ]);
        $data = $Data->getOutData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return [];
        }
    }
}


if ( ! function_exists('__POSTACCSERVICE'))
{
    function __POSTACCSERVICE($URL = '', $PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataAccount' => $PARAMS
            ]
        ]);
        return $Data->getOutMess();
    }
}


if ( ! function_exists('__POSTACCSERVICECUSTOMER'))
{
    function __POSTACCSERVICECUSTOMER($URL = '', $PARAMS = [], $isMessage = true)
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataCustomer' => $PARAMS
            ]
        ]);
        if ($isMessage) {
            return $Data->getOutMess();
        } else {
            return $Data->getOutData();
        }
    }
}

if ( ! function_exists('__POSTACCSERVICEVERIFY'))
{
    function __POSTACCSERVICEVERIFY($URL = '', $PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataVerifyCMS' => $PARAMS
            ]
        ]);
        return $Data->getOutMess();
    }
}

if ( ! function_exists('__POSTACCSERVICECONTENT'))
{
    function __POSTACCSERVICECONTENT($PARAMS = [], $isMessage = true)
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataContent' => $PARAMS
            ]
        ]);
        if ($isMessage) {
            return $Data->getOutMess();
        } else {
            return $Data->getOutData();
        }
    }
}

if ( ! function_exists('__GETACCSERVICECONTENTWITHPARAMS'))
{
    function __GETACCSERVICECONTENTWITHPARAMS($PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataContent' => $PARAMS
            ]
        ]);
        $data = $Data->getOutData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return [];
        }
    }
}

if ( ! function_exists('__GETACCSERVICECONTENT'))
{
    function __GETACCSERVICECONTENT($TableKey, $FLAG_ACTION, $REFRESH = false, $REDIRECT = true)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($FLAG_ACTION) {
            $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'dataContent' => [
                        'FLAG_ACTION' => $FLAG_ACTION
                    ]
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH && $REDIRECT) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}


if ( ! function_exists('__GETLISTJABATAN'))
{
    function __GETLISTJABATAN($withAdmin = false)
    {
        $Data = SatelliteClient()->post('/restV2/accpartner/user/account', [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataAccount' => [
                    'FLAG_ACTION' => 'GET_LIST_DATA_JABATAN'
                ]
            ]
        ]);
        $data = $Data->getOutData();
        if (!$withAdmin) {
            foreach ($data as $index => $value) {
                if ($value['NO_SR'] == 'A' || $value['DESC_GCM'] == 'ADMIN') {
                    unset($data[$index]);
                }
            }
        }
        $options = $data->map(function($item) {
            return [ 'value' => $item['NO_SR'], 'label' => $item['DESC_GCM'] ];
        });
        return $options;
    }
}


// Cetak
if ( ! function_exists('cetak'))
{
    function cetak($string)
    {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }
}

if ( ! function_exists('convertToReadableSize'))
{
    function convertToReadableSize($size){
      $base = log($size) / log(1024);
      $suffix = array("", "KB", "MB", "GB", "TB");
      $f_base = floor($base);
      return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
}

if ( ! function_exists('getPermissions'))
{
    function getPermissions($key = null)
    {
      return \App\Support\Permission::getPermissions($key);
    }
}

if ( ! function_exists('encodeId'))
{
    function encodeId($id){
      return  md5($id . '-' . env('APP_KEY'));
    }
}

if ( ! function_exists('dateIndo'))
{
    function dateIndo($datetime){
        $month_num =  strftime('%m',  strtotime($datetime));

        $months = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        return  strftime('%d ' . $months[$month_num] . ' %Y',  strtotime($datetime));
    }
}

if ( ! function_exists('timeIndo'))
{
    function timeIndo($datetime){
        return  strftime('%H:%M:%S ',  strtotime($datetime));
    }
}


