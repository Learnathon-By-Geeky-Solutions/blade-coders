<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PermissionDeleteController extends Controller
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = Config::get('laratrust.models.permission');
    }

    public function __invoke($id)
    {
        $usersAssignedToPermission = DB::table(Config::get('laratrust.tables.permission_user'))
            ->where(Config::get('laratrust.foreign_keys.permission'), $id)
            ->count();

        if ($usersAssignedToPermission > 0) {
            Session::flash('laratrust-warning', 'Permission is added to one or more users. It can not be deleted');
        } else {
            Session::flash('laratrust-success', 'Permission deleted successfully');
            $this->permissionModel::destroy($id);
        }

        return redirect(route('laratrust.permissions.index'));
    }
}
