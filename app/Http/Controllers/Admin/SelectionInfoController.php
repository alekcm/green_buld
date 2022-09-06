<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SelectionInfos\FileStoreRequest;
use App\Http\Requests\Admin\SelectionInfos\SelectionInfoStoreRequest;
use App\Http\Resources\Response\JsonSuccessResponse;
use App\Services\SelectionInfos\SelectionInfoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SelectionInfoController extends Controller
{
    public function __construct(protected SelectionInfoService $service)
    {
    }

    public function create(): Factory|View|Application
    {
        return view('admin.selection_infos.create');
    }

    public function store(SelectionInfoStoreRequest $request): RedirectResponse
    {
        if ($this->service->store($request->getFilename())) {
            return redirect()->route('admin.selection_info.create')
                ->with(['success' => trans('message.selection_info.store.success')]);
        }

        return redirect()->back()->with(['error' => trans('message.selection_info.store.error')]);
    }

    /**
     * @param FileStoreRequest $request
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function upload(FileStoreRequest $request): JsonResponse
    {
        return response()->json(
            new JsonSuccessResponse([
                'filename' => $this->service->upload($request->getFile())
            ], trans('message.page.image.upload.success'))
        );
    }
}
