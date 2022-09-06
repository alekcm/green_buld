<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Feedbacks\FeedbackStoreRequest;
use App\Http\Resources\Response\JsonErrorResponse;
use App\Http\Resources\Response\JsonSuccessResponse;
use App\Models\Config;
use App\Notifications\FeedbackNotification;
use App\Services\Feedbacks\FeedbackService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function __construct(protected FeedbackService $feedbackService)
    {
    }

    public function store(FeedbackStoreRequest $request): JsonResponse
    {
        return response()->json(
            $this->feedbackService->send($request->validated())
                ? new JsonSuccessResponse([], trans('message.feedback.success'))
                : new JsonErrorResponse([], trans('message.feedback.error'))
        );
    }
}
