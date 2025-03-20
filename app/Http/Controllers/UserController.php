<?php

namespace App\Http\Controllers;

use AmdadulHaq\Guard\Models\Role;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('user.viewAny');

        $users = User::select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
            ->with('roles:id,name,label')
            ->latest()
            ->paginate(config('setting.pagination_limit'));

        $roles = Role::select(['id', 'name', 'label'])->get();

        return view('backend.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        Gate::authorize('user.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        Gate::authorize('user.create');

        DB::transaction(function () use ($request) {
            $user = new User;
            $user->fill($request->validated())->save();

            if ($request->filled('roles')) {
                $user->roles()->attach($request->roles);
            }

            if ($request->input('welcome_email')) {
                event(new Registered($user));
            }

            toastr()->success(__(':name created successfully!', ['name' => __('User')]));
        });

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): void
    {
        Gate::authorize('user.view');

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): JsonResponse
    {
        Gate::authorize('user.update');

        $data = $user->load('roles:id,name')->toArray();
        $data['roles'] = $user->roles->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'user' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        Gate::authorize('user.update');

        $user->update($request->validated());

        $user->roles()->sync($request->roles);

        toastr()->success(__(':name updated successfully!', ['name' => __('User')]));

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        abort_if($user->id == auth()->id(), Response::HTTP_FORBIDDEN);

        Gate::authorize('user.delete');

        $user->roles()->detach();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => __(':name deleted successfully!', ['name' => __('User')]),
        ]);
    }
}
