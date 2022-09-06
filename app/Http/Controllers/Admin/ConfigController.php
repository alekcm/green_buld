<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ConfigEnum;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\ConfigUpdateRequest;
use App\Services\Configs\ConfigService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ConfigController extends Controller
{
    public function __construct(protected ConfigService $configService)
    {
    }

    public function index(): Factory|View|Application
    {
        return view('admin.configs.index', [
            'items' => $this->configService->getAllAttributes(),
        ]);
    }

    public function edit(string $attr): Factory|View|Application
    {
        return view('admin.configs.create', $this->configService->getAttribute($attr));
    }

    /**
     * @param ConfigUpdateRequest $request
     * @param string $attr
     * @return RedirectResponse
     * @throws BusinessLogicException
     */
    public function update(ConfigUpdateRequest $request, string $attr): RedirectResponse
    {
        if ($config = $this->configService->update([
            $attr => $request->validated($attr)
        ])) {
            return redirect()->route('admin.configs.index')->with([
                'success' => trans(
                    'message.config.update.success', [
                        'name' => ConfigEnum::toUpper($attr),
                    ]
                )
            ]);
        } else {
            return back()->with([
                'error' => trans(
                    'message.config.update.error', [
                        'name' => ConfigEnum::toUpper($attr),
                    ]
                )
            ]);
        }
    }
}
