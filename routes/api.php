<?php

use App\Http\Controllers\Api\v1\Agent\AgentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//================================================= Auth =================================================
Route::post('/auth/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
Route::post('/auth/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
Route::get('/auth/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/auth/change_password/{user_id}', [\App\Http\Controllers\Api\Auth\AuthController::class, 'changePassword']);

//================================================= User =================================================
Route::get('/v1/users', [\App\Http\Controllers\Api\v1\User\UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/user/store', [\App\Http\Controllers\Api\v1\User\UserController::class, 'store'])->middleware('auth:sanctum');
Route::get('/v1/user/show/{user_id}', [\App\Http\Controllers\Api\v1\User\UserController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/user/update/{user_id}', [\App\Http\Controllers\Api\v1\User\UserController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/user/delete/{user_id}', [\App\Http\Controllers\Api\v1\User\UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/v1/user/search', [\App\Http\Controllers\Api\v1\User\UserController::class, 'search'])->middleware('auth:sanctum');
Route::post('/v1/user/upload_pic', [\App\Http\Controllers\Api\v1\User\UserController::class, 'upload_pic'])->middleware('auth:sanctum');
Route::get('/v1/user/remove_pic/{user_id}', [\App\Http\Controllers\Api\v1\User\UserController::class, 'remove_pic'])->middleware('auth:sanctum');

/* ------------------------------| departments |------------------------------ */
Route::get("/v1/user/attach_department/{user_id}/{dept_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "attachDepartmentToUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/user/detach_department/{user_id}/{dept_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "detachDepartmentFromUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/user/sync_departments/{user_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "syncDepartmentsWithUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

/* ------------------------------| roles |------------------------------ */
Route::get("/v1/user/attach_role/{user_id}/{role_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "attachRoleToUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/user/detach_role/{user_id}/{role_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "detachRoleFromUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/user/sync_roles/{user_id}", [\App\Http\Controllers\Api\v1\User\UserRelationController::class, "syncRolesWithUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Role =================================================
Route::get('/v1/roles', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/role/store', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'store'])->middleware('auth:sanctum');
Route::get('/v1/role/show/{role_id}', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/role/update/{role_id}', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/role/delete/{role_id}', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/role/search', [\App\Http\Controllers\Api\v1\Role\RoleController::class, 'search'])->middleware('auth:sanctum');

/* ------------------------------| permissions |------------------------------ */
Route::get("/v1/role/attach_permission/{role_id}/{permission_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "attachPermissionToRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/role/detach_permission/{role_id}/{permission_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "detachPermissionFromRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/role/sync_permissions/{role_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "syncPermissionsWithRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

/* ------------------------------| users |------------------------------ */
Route::get("/v1/role/attach_user/{role_id}/{user_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "attachUserToRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/role/detach_user/{role_id}/{user_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "detachUserFromRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/role/sync_users/{role_id}", [\App\Http\Controllers\Api\v1\Role\RoleRelationController::class, "syncUsersWithRole"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Permission =================================================
Route::get('/v1/permissions', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/permission/store', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'store'])->middleware('auth:sanctum');
Route::get('/v1/permission/show/{permission_id}', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/permission/update/{permission_id}', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/permission/delete/{permission_id}', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/permission/search', [\App\Http\Controllers\Api\v1\Permission\PermissionController::class, 'search'])->middleware('auth:sanctum');

/* ------------------------------| roles |------------------------------ */
Route::get("/v1/permission/attach_role/{permission_id}/{role_id}", [\App\Http\Controllers\Api\v1\Permission\PermissionRelationController::class, "attachRoleToPermission"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/permission/detach_role/{permission_id}/{role_id}", [\App\Http\Controllers\Api\v1\Permission\PermissionRelationController::class, "detachRoleFromPermission"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/permission/sync_roles/{permission_id}", [\App\Http\Controllers\Api\v1\Permission\PermissionRelationController::class, "syncRolesWithPermission"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Department =================================================
Route::get('/v1/departments', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/department/store', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'store'])->middleware('auth:sanctum');
Route::get('/v1/department/show/{dept_id}', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/department/update/{dept_id}', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/department/delete/{dept_id}', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/department/search', [\App\Http\Controllers\Api\v1\Department\DepartmentController::class, 'search'])->middleware('auth:sanctum');

/* ------------------------------| users |------------------------------ */
Route::get("/v1/department/attach_user/{dept_id}/{user_id}", [\App\Http\Controllers\Api\v1\Department\DepartmentRelationController::class, "attachDepartmentToUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/department/detach_user/{dept_id}/{user_id}", [\App\Http\Controllers\Api\v1\Department\DepartmentRelationController::class, "detachDepartmentFromUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/department/sync_users/{dept_id}", [\App\Http\Controllers\Api\v1\Department\DepartmentRelationController::class, "syncDepartmentsWithUser"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Tag =================================================
Route::get('/v1/tags', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/tag/store', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'store'])->middleware('auth:sanctum');
Route::get('/v1/tag/show/{tag_id}', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/tag/update/{tag_id}', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/tag/delete/{tag_id}', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/tag/search', [\App\Http\Controllers\Api\v1\Tag\TagController::class, 'search'])->middleware('auth:sanctum');

/* ------------------------------| agents |------------------------------ */
Route::get("/v1/tag/attach_agent/{tag_id}/{agent_id}", [\App\Http\Controllers\Api\v1\Tag\TagRelationController::class, "attachAgentToTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/tag/detach_agent/{tag_id}/{agent_id}", [\App\Http\Controllers\Api\v1\Tag\TagRelationController::class, "detachAgentFromTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/tag/sync_agents/{tag_id}", [\App\Http\Controllers\Api\v1\Tag\TagRelationController::class, "syncAgentsWithTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Agent =================================================
Route::get('/v1/agents', [AgentController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/agent/store', [AgentController::class, 'store']);
Route::get('/v1/agent/show/{agent_id}', [AgentController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/agent/update/{agent_id}', [AgentController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/agent/delete/{agent_id}', [AgentController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/agent/search', [AgentController::class, 'search'])->middleware('auth:sanctum');

/* ------------------------------| tags |------------------------------ */
Route::get("/v1/agent/attach_tag/{agent_id}/{tag_id}", [\App\Http\Controllers\Api\v1\Agent\AgentRelationController::class, "attachAgentToTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::get("/v1/agent/detach_tag/{agent_id}/{tag_id}", [\App\Http\Controllers\Api\v1\Agent\AgentRelationController::class, "detachAgentFromTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);
Route::post("/v1/agent/sync_tags/{agent_id}", [\App\Http\Controllers\Api\v1\Agent\AgentRelationController::class, "syncAgentsWithTag"])->middleware('auth:sanctum')->middleware([\App\Http\Middleware\CheckRole::class.':admin-developer']);

//================================================= Agent Snapshot =================================================
Route::get('/v1/agent/snapshots', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'index'])->middleware('auth:sanctum');
Route::post('/v1/agent/snapshot/store', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'store'])->middleware(\App\Http\Middleware\CheckToken::class);
Route::get('/v1/agent/snapshot/show/{snapshot_id}', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'show'])->middleware('auth:sanctum');
Route::post('/v1/agent/snapshot/update/{snapshot_id}', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'update'])->middleware('auth:sanctum');
Route::get('/v1/agent/snapshot/delete/{snapshot_id}', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/v1/agent/snapshot/search', [\App\Http\Controllers\Api\v1\AgentSnapshot\AgentSnapshotController::class, 'search'])->middleware('auth:sanctum');





Route::post('/agent_request', [\App\Http\Controllers\Api\v1\AgentController::class, 'agent_request']);
Route::post('/agent/store', [\App\Http\Controllers\Api\v1\AgentController::class, 'store']);
Route::post('/agent/snapshot/store', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'store']);

Route::get('/cpu/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'cpu']);
Route::get('/ram/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'ram']);
Route::get('/disk/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'disk']);
Route::get('/network/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'network']);

Route::get('/cpu/critical/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'criticalCPU']);
Route::get('/cpu/insert/{agent_id}', [\App\Http\Controllers\Api\v1\AgentSnapshotController::class, 'insert']);

Route::get('/online', [\App\Http\Controllers\Api\v1\AgentController::class, 'online']);
