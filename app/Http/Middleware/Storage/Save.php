<?php

namespace App\Http\Middleware\Storage;

use DB;
use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Save extends BaseMiddleware
{
    protected $file = null;
    private $AllowedMimeTypes = [
        'a' => 'application/octet-stream',
        'ai' => 'application/postscript',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'au' => 'audio/basic',
        'avi' => 'video/x-msvideo',
        'bat' => 'text/plain',
        'bin' => 'application/octet-stream',
        'bmp' => 'image/x-ms-bmp',
        'c' => 'text/plain',
        'cdf' => 'application/x-cdf',
        'csh' => 'application/x-csh',
        'css' => 'text/css',
        'dll' => 'application/octet-stream',
        'doc' => 'application/msword',
        'dot' => 'application/msword',
        'dvi' => 'application/x-dvi',
        'eml' => 'message/rfc822',
        'eps' => 'application/postscript',
        'etx' => 'text/x-setext',
        'exe' => 'application/octet-stream',
        'gif' => 'image/gif',
        'gtar' => 'application/x-gtar',
        'h' => 'text/plain',
        'hdf' => 'application/x-hdf',
        'htm' => 'text/html',
        'html' => 'text/html',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'js' => 'application/x-javascript',
        'ksh' => 'text/plain',
        'latex' => 'application/x-latex',
        'm1v' => 'video/mpeg',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'mht' => 'message/rfc822',
        'mhtml' => 'message/rfc822',
        'mif' => 'application/x-mif',
        'mov' => 'video/quicktime',
        'movie' => 'video/x-sgi-movie',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'mpa' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'ms' => 'application/x-troff-ms',
        'nc' => 'application/x-netcdf',
        'nws' => 'message/rfc822',
        'o' => 'application/octet-stream',
        'obj' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pbm' => 'image/x-portable-bitmap',
        'pdf' => 'application/pdf',
        'pfx' => 'application/x-pkcs12',
        'pgm' => 'image/x-portable-graymap',
        'png' => 'image/png',
        'pnm' => 'image/x-portable-anymap',
        'pot' => 'application/vnd.ms-powerpoint',
        'ppa' => 'application/vnd.ms-powerpoint',
        'ppm' => 'image/x-portable-pixmap',
        'pps' => 'application/vnd.ms-powerpoint',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.ms-powerpoint',
        'ps' => 'application/postscript',
        'pwz' => 'application/vnd.ms-powerpoint',
        'py' => 'text/x-python',
        'pyc' => 'application/x-python-code',
        'pyo' => 'application/x-python-code',
        'qt' => 'video/quicktime',
        'ra' => 'audio/x-pn-realaudio',
        'ram' => 'application/x-pn-realaudio',
        'ras' => 'image/x-cmu-raster',
        'rdf' => 'application/xml',
        'rgb' => 'image/x-rgb',
        'roff' => 'application/x-troff',
        'rtx' => 'text/richtext',
        'sgm' => 'text/x-sgml',
        'sgml' => 'text/x-sgml',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'snd' => 'audio/basic',
        'so' => 'application/octet-stream',
        'src' => 'application/x-wais-source',
        'swf' => 'application/x-shockwave-flash',
        't' => 'application/x-troff',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texi' => 'application/x-texinfo',
        'texinfo'=> 'application/x-texinfo',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'tr' => 'application/x-troff',
        'tsv' => 'text/tab-separated-values',
        'txt' => 'text/plain',
        'ustar' => 'application/x-ustar',
        'vcf' => 'text/x-vcard',
        'wav' => 'audio/x-wav',
        'wiz' => 'application/msword',
        'wsdl' => 'application/xml',
        'xbm' => 'image/x-xbitmap',
        'xlb' => 'application/vnd.ms-excel',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.ms-excel',
        'xml' => 'text/xml',
        'xpdl' => 'application/xml',
        'xpm' => 'image/x-xpixmap',
        'xsl' => 'application/xml',
        'xwd' => 'image/x-xwindowdump',
        'zip' => 'application/zip',

        'doc' => 'application/msword',
        'dot' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
        'xls' => 'application/vnd.ms-excel',
        'xlt' => 'application/vnd.ms-excel',
        'xla' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pot' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint',
        'ppa' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12'
    ];

    private function Initiate()
    {
        $this->file = json_decode($this->_Request->input('file'));
        $this->object = $this->_Request->input('object');
        $this->object_id = $this->_Request->input('object_id');
    }

    private function Validation()
    {
        if (!isset($this->file->key)) {
            $this->Json::set('exception.code', 'InvalidKeyFile');
            $this->Json::set('exception.message', message('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if (!isset($this->file->extension)) {
            $this->Json::set('exception.code', 'InvalidExtensionFile');
            $this->Json::set('exception.message', message('validation.'.$this->Json::get('exception.code')));
            return false;
        }
        if (!Storage::disk('temporary')->exists($this->file->key . '.' . $this->file->extension)) {
            $this->Json::set('errors.file', [
                message('validation.file_not_exist', ['attribute' => 'file'])
            ]);
            return false;
        }
        if (!in_array(Storage::disk('temporary')->mimeType($this->file->key . '.' . $this->file->extension), $this->AllowedMimeTypes)) {
            $this->Json::set('response.code', 400);
            $this->Json::set('exception.code', 'InvalidFile');
            $this->Json::set('exception.message', trans('Equinox::Validation.'.$this->Json::get('exception.code')));
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('File', $this->file);
            $this->Payload->put('Object', $this->object);
            $this->Payload->put('ObjectId', $this->object_id);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
