<?php

namespace App\Http\Controllers\Mail;

use App\Models\Mail;
use App\Models\MailTo;
use App\Models\MailDispostion;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MailDispostionController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'content',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $Mail = Mail::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });
           }
        });
        $Browse = $this->Browse($request, $Mail, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($Mail) {
                    return [ 'value' => $Mail->id, 'label' => $Mail->name ];
                });
            } else {
                $data->map(function($Mail) {
                    if (isset($Mail->point->balance)) {
                        $Mail->point->balance = (double)$Mail->point->balance;
                    }
                    return $Mail;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

}
