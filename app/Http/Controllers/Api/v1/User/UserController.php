<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UploadPicRequest;
use App\Http\Resources\Api\v1\User\UserResource;
use App\Services\Interfaces\User\UserServiceInterfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    private UserServiceInterfaces $service;

    public function __construct(UserServiceInterfaces $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if (DB::table('users')->count() > 0)
        {
            $users = $this->service->index();
            return $this->successResponse(UserResource::collection($users), 200);
        }
        return $this->errorResponse('no-user', 404);
    }

    public function store(StoreRequest $request)
    {
        $user = $this->service->store($request->validated());
        if ($user)
            return $this->successResponse(new UserResource($user), 201);
        return $this->errorResponse('save-failed', 500);
    }

    public function show(int $id)
    {
        if ($this->checkExistsUserById($id))
        {
            $user = $this->service->show($id);
            if ($user)
                return $this->successResponse(new UserResource($user), 201);
            return $this->errorResponse('save-failed', 500);
        }
        return $this->errorResponse('user-notFound', 404);
    }

    public function update(UpdateRequest $request, int $id)
    {
        if ($this->checkExistsUserById($id))
        {
            $user = $this->service->update($request->validated(), $id);
            if ($user)
                return $this->successResponse('', 201, 'updated-successfully');
            return $this->errorResponse('save-failed', 500);
        }
        return $this->errorResponse('user-notFound', 404);
    }

    public function destroy(int $id)
    {
        if (!$this->checkExistsUserById($id))
            return $this->errorResponse('user-notFound', 404);

        if ($this->service->delete($id))
            return $this->successResponse('', 201, 'deleted-successfully');
    }

    public function search(SearchRequest $request)
    {
        $columns = $request->input('columns', ['*']);
        $relations = $request->input('relations', []);
        $filters = $request->only(['search', ...array_keys($request->except(['columns', 'relations', 'page', 'limit']))]);

        $results = $this->service->search($columns, $relations, $filters);

        return $this->successResponse($results, 200);
    }

    public function upload_pic(UploadPicRequest $request)
    {
        $upload = $this->service->upload_pic($request->validated());
        if ($upload['message'] !== 'success')
            return $this->errorResponse($upload['message'], 500);

        return $this->successResponse('', 201, 'uploaded-successfully');
    }

    public function remove_pic(int $id)
    {
        $remove = $this->service->removeUserPicFromStorage($id);
        if ($remove['message'] !== 'pic-removed')
            return $this->errorResponse($remove['message'], 500);

        return $this->successResponse('', 201, 'removed-successfully');
    }
    private function checkExistsUserById($id)
    {
        return $this->service->checkExistsUserById($id);
    }
}
