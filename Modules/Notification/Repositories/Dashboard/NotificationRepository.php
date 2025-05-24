<?php

namespace Modules\Notification\Repositories\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\DeviceToken\Entities\DeviceToken;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;

class NotificationRepository extends CrudRepository
{
    use SendNotification;
    protected $token;
    protected $notification;

    public function __construct(DeviceToken $token, GeneralNotification $notification)
    {
        $this->token = $token;
        $this->notification = $notification;
        parent::__construct(GeneralNotification::class);
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = [
                'user_id' => auth()->id(),
                'title' => $request->title,
                'body' => $request->body,
            ];

            $notification = $this->notification->create($data);

            DB::commit();
            return $notification;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function sendToAllFcmTokens($notification)
    {
        $this->token->whereNotNull('device_token')->chunk(500, function($tokens) use($notification){
            foreach ($tokens as $token) {
                $data = [
                    'title' => $notification->getTranslation('title', $token->lang) ?? '',
                    'body' => $notification->getTranslation('body', $token->lang) ?? '',
                ];

                $data['type'] = 'general';
                $data['id'] = null;
                $this->send($data, [$token->device_token]);
            }
        });
    }

    public function getAllUserTokens($userId)
    {
        return $this->token->where('user_id', $userId)->pluck('device_token')->toArray();
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
