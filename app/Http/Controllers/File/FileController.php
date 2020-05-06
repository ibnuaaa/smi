<?php

namespace App\Http\Controllers\File;

use Cache;
use Closure;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Support\Response\Json;
use App\Support\Generate\Hash as GenerateKey;
use Illuminate\Support\Facades\Input;
use App\Models\Images;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class FileController extends Controller
{
    protected $ImageTypes = ['image/png', 'image/jpeg'];

    public function Upload(Request $request)
    {
        $File = $request->Payload->all()['File'];
        $NameFile = $File->getClientOriginalName();
        $ExtensionFile = $File->getClientOriginalExtension();
        $KeyName = GenerateKey::Random('', 64);
        $Name = "$KeyName.$ExtensionFile";
        $StoragePath = Storage::disk('temporary')->getAdapter()->getPathPrefix();
        $File->move($StoragePath, $Name);

        Json::set('data', [
            'name' => $NameFile,
            'key' => $KeyName,
            'extension' => $ExtensionFile
        ]);
        return response()->json(Json::get(), 201);
    }

    public function createThumbnail($StoragePath, $Name, $KeyName)
    {
        $MimeType = Storage::disk('temporary')->mimeType($Name);
        if (in_array($MimeType, $this->ImageTypes)) {
            $IMG = Image::make($StoragePath . $Name);

            $IMG->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });
            // $IMG->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // });
            $IMG->save($StoragePath . $KeyName . '-tumb.jpg');
            return $KeyName . '-tumb.jpg';
        }
        return null;
    }
}
