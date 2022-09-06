<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Resources\Response\JsonErrorResponse;
use App\Http\Resources\Response\JsonSuccessResponse;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordService $forgotPasswordService)
    {
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        return response()->json(
            $this->forgotPasswordService->sendPassword($request->getEmail())
                ? new JsonSuccessResponse([], trans('message.forgot_password.success'))
                : new JsonErrorResponse([], trans('message.forgot_password.error'))
        );
    }
}
