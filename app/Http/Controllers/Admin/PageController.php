<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BusinessLogicException;
use App\Http\Requests\Admin\Pages\IconDeleteRequest;
use App\Http\Requests\Admin\Pages\IconStoreRequest;
use App\Http\Requests\Admin\Pages\PageStoreRequest;
use App\Http\Resources\Response\JsonErrorResponse;
use App\Http\Resources\Response\JsonSuccessResponse;
use App\Models\Page;
use App\Services\Pages\PageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class PageController extends BaseController
{
    public function __construct(protected PageService $pageService)
    {
        $this->className = Page::class;
        $this->routesPath = 'admin.pages';
        $this->viewsPath = 'admin.pages';
        $this->showClassName = 'Страница';
    }

    public function index(Request $request, array $searchFields = []): View|Factory|Application
    {
        $search = [
            ['callback' => function (Builder $query, array $params) {
                return !is_null($params['value']) ? $query->where($params['key'], $params['operator'], $params['value']) : $query;
            },
                'items' => [
                    ['key' => 'title', 'value' => '%' . $request->get('q') . '%', 'operator' => 'like']
                ]
            ]
        ];

        return parent::index(
            $request,
            $search,
        );
    }

    /**
     * @throws Throwable
     */
    public function store(PageStoreRequest $request): RedirectResponse
    {
//        dd($request->validated());
        if ($model = $this->pageService->create($request->validated(), $request->getPageContent())) {
            return redirect()->route($this->routesPath . '.' . self::INDEX_ACTION)
                ->with(['success' => trans('message.page.create.success', ['title' => $model->title])]);
        } else {
            return redirect()->back()
                ->with(['error' => trans('message.page.create.error')]);
        }
    }

    public function edit(string $slug): Factory|View|RedirectResponse|Application
    {
        $model = $this->getModel()::query()->where('slug', $slug)->first();

        if ($model) {
            return view($this->viewsPath . '.' . static::CREATE_ACTION, [
                'model' => $model,
            ]);
        }

        return redirect()->route($this->viewsPath . '.' . static::INDEX_ACTION)->with([
            'error' => 'Объект ' . $this->showClassName . ' ' . $slug . ' не найден',
        ]);
    }

    public function update(PageStoreRequest $request, string $slug): RedirectResponse
    {
        /** @var Page $model */
        $model = $this->getModel()::query()->where('slug', $slug)->first();

        if ($model && $model = $this->pageService->update($model, $request->validated(), $request->getPageContent())) {
            return redirect()->route($this->routesPath . '.' . self::INDEX_ACTION)
                ->with(['success' => trans('message.page.update.success', ['title' => $model->title])]);

        } else {
            return redirect()->back()->with(['error' => trans('message.page.update.error', ['title' => $model->title ?? ''])]);
        }
    }

    public function destroy(string $slug): RedirectResponse
    {
        /** @var Page $model */
        $model = $this->getModel()::query()->where('slug', $slug)->first();

        if ($model?->delete()) {
            return redirect()->back()->with(['success' => trans('message.page.delete.success', ['title' => $model->title])]);
        }

        return redirect()->back()->with(['error' => trans('message.page.delete.error', ['title' => $model->title])]);
    }

    /**
     * @param IconStoreRequest $request
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function saveIcon(IconStoreRequest $request): JsonResponse
    {
        $filename = $this->pageService->saveIcon($request->getIcon());
        return response()->json(
            $filename
                ? new JsonSuccessResponse(['icon' => $filename], trans('message.page.icon.upload.success'))
                : new JsonErrorResponse([], trans('message.page.icon.upload.error'))
        );
    }

    /**
     * @param IconDeleteRequest $request
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function deleteIcon(IconDeleteRequest $request): JsonResponse
    {
        return response()->json(
            $this->pageService->deleteIcon($request->getPage())
                ? new JsonSuccessResponse([], trans('message.page.icon.delete.success'))
                : new JsonErrorResponse([], trans('message.page.icon.delete.error'))
        );
    }

    /**
     * @throws BusinessLogicException
     */
    public function uploadImage(Request $request): JsonResponse
    {
        return response()->json(
            new JsonSuccessResponse(['url' => $this->pageService->uploadImage($request->file('image'))], trans('message.page.image.upload.success'))
        );
    }
}
