<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSpamMessageRequest;
use App\Models\SpamMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;

class SpamMessageController extends Controller
{    
    /**
     * Get all spam messages without paginate
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $spamMessages = SpamMessage::all();

        View::share('spam_messages', $spamMessages);

        return $this->responseSuccess($spamMessages);
    }

    /**
     * Update spam message
     *
     * @param  UpdateSpamMessageRequest $request
     * @param  string $id
     * @return JsonResponse
     */
    public function update(UpdateSpamMessageRequest $request, string $id): JsonResponse
    {
        $result = SpamMessage::find($id)->update($request->all());

        if ($result) {
            return $this->messageSuccess('Cập nhật thành công !');
        }

        return $this->responseFail('Cập nhật thất bại !');
    }
}
