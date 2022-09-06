<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public const INDEX_ACTION = 'index';
    public const CREATE_ACTION = 'create';
    public const SHOW_ACTION = 'show';
    public const DELETE_ACTION = 'delete';
    public const DESTROY_ACTION = 'destroy';
    public const STORE_ACTION = 'store';
    public const EDIT_ACTION = 'edit';
    public const UPDATE_ACTION = 'update';

    public string $className;
    public string $routesPath;
    public string $viewsPath;
    public string $showClassName;

    public function getModel(): Model
    {
        return new $this->className;
    }

    public function index(Request $request, array $searchFields = []): Factory|View|Application
    {
        $perPage = $request->input('per_page', 10);
        $items = $this->getModel()::query();

        foreach ($searchFields as $searchField) {
            $callback = $searchField['callback'];
            foreach ($searchField['items'] as $params) {
                $items = $callback($items, $params);
            }
        }

        $items = $items->paginate($perPage);

        return view($this->viewsPath . '.' . self::INDEX_ACTION, [
            'items' => $items,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View|Factory|Application
    {
        return view($this->viewsPath . '.' . static::CREATE_ACTION);
    }
}
