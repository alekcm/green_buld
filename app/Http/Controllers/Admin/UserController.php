<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BusinessLogicException;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(protected UserService $userService)
    {
        $this->className = User::class;
        $this->routesPath = 'admin.users';
        $this->viewsPath = 'admin.users';
        $this->showClassName = 'Пользователь';
    }

    public function index(Request $request, array $searchFields = []): View|Factory|Application
    {
        $search = [
            ['callback' => function (Builder $query, array $params) {
                return !is_null($params['value']) ? $query->orWhere($params['key'], $params['operator'], $params['value']) : $query;
            },
                'items' => [
                    ['key' => 'email', 'value' => '%' . $request->get('q') . '%', 'operator' => 'like'],
                    ['key' => 'name', 'value' => '%' . $request->get('q') . '%', 'operator' => 'like'],
                ]
            ]
        ];

        return parent::index(
            $request,
            $search,
        );
    }

    public function edit(int $id): Factory|View|RedirectResponse|Application
    {
        $model = $this->getModel()::query()->findOrFail($id);

        if ($model) {
            return view($this->viewsPath . '.' . static::CREATE_ACTION, [
                'model' => $model,
            ]);
        }

        return redirect()->route($this->viewsPath . '.' . static::INDEX_ACTION)->with([
            'error' => trans('message.user.not_found', ['id' => $id]),
        ]);
    }

    /**
     * @param UserUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws BusinessLogicException
     */
    public function update(UserUpdateRequest $request, int $id): RedirectResponse
    {
        /** @var User $model */
        $model = $this->getModel()::query()->find($id);

        if ($model && $model = $this->userService->update($model, $request->validated())) {
            return redirect()->route($this->routesPath . '.' . self::INDEX_ACTION)->with([
                'success' => trans(
                    'message.user.update.success', [
                        'name' => $model->name ?? $model->email,
                    ]
                )
            ]);
        } else {
            return back()->with([
                'error' => trans(
                    'message.user.update.error', [
                        'name' => $model->name ?? '',
                    ]
                )
            ]);
        }
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws BusinessLogicException
     */
    public function block(int $id): RedirectResponse
    {
        /** @var User $model */
        $model = $this->getModel()::query()->find($id);

        if ($model && $model = $this->userService->toggleBlock($model)) {
            return redirect()->back()->with([
                'success' => trans_choice(
                    'message.user.is_blocked.change.success',
                    (int)$model->is_blocked, [
                        'name' => $model->name ?? $model->email,
                    ]
                )
            ]);

        } else {
            return redirect()->back()->with([
                'error' => trans_choice(
                    'message.user.is_blocked.change.error',
                    (int)$model?->is_blocked, [
                        'name' => $model->name ?? '',
                    ]
                )
            ]);
        }
    }
}
