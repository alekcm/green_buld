<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SelectionInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $procedureNumber = $request->get('procedure_number');

        $result = null;

        if (!is_null($procedureNumber)) {
            $result = SelectionInfo::where('procedure_number', $procedureNumber)->get();
        }

        return view('web.search.index', ['result' => $result]);
    }
}
