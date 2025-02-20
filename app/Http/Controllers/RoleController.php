<?php

namespace App\Http\Controllers;

use AmdadulHaq\Guard\GuardServiceProvider;
use AmdadulHaq\Guard\Models\Permission;
use AmdadulHaq\Guard\Models\Role;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('role.viewAny');

        $roles = Role::paginate(config('setting.pagination_limit'));

        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('role.create');

        $permissions = $this->getPermissions();

        return view('backend.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Gate::authorize('role.create');

        $role = Role::create($request->only(['name', 'label']));

        $role->permissions()->sync($request->input('permissions'));

        GuardServiceProvider::clearCache();

        toastr()->success(__(':name created successfully!', ['name' => __('Role')]));

        return Redirect::route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('role.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('role.update');

        $permissions = $this->getPermissions();

        return view('backend.roles.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        Gate::authorize('role.update');

        $role->update($request->only(['name', 'label']));

        $role->permissions()->sync($request->input('permissions'));

        GuardServiceProvider::clearCache();

        toastr()->success(__(':name updated successfully!', ['name' => __('Role')]));

        return Redirect::route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('role.delete');

        if ($role->users()->exists()) {
            return response()->json([
                'status' => false,
                'message' => __(':name cannot be deleted because it is assigned to users.', ['name' => __('Role')]),
            ]);
        }

        $role->delete();

        return response()->json([
            'status' => true,
            'message' => __(':name deleted successfully!', ['name' => __('Role')]),
        ]);
    }

    private function getPermissions(): Collection
    {
        return Permission::select(['id', 'name', 'label'])
            ->get()
            ->mapToGroups(function ($item) {
                $nameParts = explode('.', $item->name);
                $group = Str::headline($nameParts[0]);
                $label = isset($nameParts[1]) ? Str::headline($nameParts[1]) : '';

                return [
                    $group => [
                        'id' => $item->id,
                        'name' => $item->name,
                        'label' => $label,
                    ],
                ];
            });
    }
}
