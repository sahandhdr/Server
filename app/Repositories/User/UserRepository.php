<?php

namespace App\Repositories\User;

use App\Http\Resources\Api\v1\User\UserResource;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\User\UserRepositoryInterfaces;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserRepository extends BaseRepository implements UserRepositoryInterfaces
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function upload_pic(array $attributes): array
    {
        $user_id = Auth::id();
        if ($this->checkExists($user_id))
        {
            $picName = $user_id.'_'.Carbon::now()->microsecond . '_' . $attributes['pic']->getClientOriginalName();
            $picPath = 'users'.'/'.$user_id.'/'.'profile_pic';
            if ($attributes['pic']->storeAs($picPath, $picName, 'public'))
            {
                $user = $this->show($user_id);
                $this->delete_pic($user->pic_path);
                $user->pic_path = $picPath . '/' . $picName;
                if ($user->save())
                    return ['message' => 'success'];
                return ['message' => 'save-failed'];
            }
            return ['message' => 'upload-failed'];
        }
        return ['message' => 'user-notExists'];
    }

    public function removeUserPicFromStorage(int $user_id): array
    {
        if ($this->checkExists($user_id))
        {
            $user = $this->show($user_id);
            $pic_path = $user->pic_path;
            if ($this->delete_pic($pic_path)['status'] == 'success')
            {
                $user->pic_path = null;
                if ($user->save())
                    return ['message' => 'pic-removed'];
                return ['message' => 'save-failed'];
            }
            return ['message' => 'remove-failed'];
        }
        return ['message' => 'user-notFound'];
    }

    public function delete_pic($pic_path): array
    {
        if (!is_null($pic_path))
            return (Storage::disk('public')->delete($pic_path)) ? ['status' => 'success'] : ['status' => 'failed'];
    }


}
