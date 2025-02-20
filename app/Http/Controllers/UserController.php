<?php

namespace App\Http\Controllers;

use AmdadulHaq\Guard\Models\Role;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
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
            ->paginate(config('setting.pagination_limit'));

        $roles = Role::select(['id', 'name', 'label'])->get();

        return view('backend.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gate::authorize('user.create');

        DB::transaction(function () use ($request) {
            $user = new User;
            $user->fill($request->validated())->save();

            if ($request->filled('role')) {
                $user->roles()->attach($request->role);
            }

            toastr()->success(__(':name created successfully!', ['name' => __('User')]));
        });

        return Redirect::route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        if (! request()->ajax()) {
            Gate::authorize('user.view');
            abort(Response::HTTP_NOT_FOUND);
        }

        if (! $user->can('user.view')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'user' => $user->load('roles'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('user.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('user.update');

        $user->update($request->validated());

        $user->roles()->sync($request->role);

        toastr()->success(__(':name updated successfully!', ['name' => __('User')]));

        return Redirect::route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if($user->id == auth()->id(), Response::HTTP_FORBIDDEN);

        Gate::authorize('user.delete');

        $user->roles()->detach();

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('User')]),
        ]);
    }
}
