<?php

namespace App\Http\Controllers\Web;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\Pages\PageService;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('web.pages.index', [
            'pages' => Page::showMain()->available(Auth::user())->sortByOrder()->get()->filter(function (Page $item) {
                return Auth::user()->role === UserRoleEnum::ADMIN || !in_array(false, $item->ancestors()->get('is_published')->pluck('is_published')->toArray());
            }),
        ]);
    }

    public function show(string $path): Factory|View|Application
    {
        $model = Page::available(Auth::user())->where('path', $path)->firstOrFail();

        if (Auth::user()->role !== UserRoleEnum::ADMIN) {
            if (in_array(false, $model->ancestors()->get('is_published')->pluck('is_published')->toArray())) {
                throw new NotFoundHttpException();
            }
        }

        return view('web.pages.show', [
            'model' => $model,
        ]);
    }
}
