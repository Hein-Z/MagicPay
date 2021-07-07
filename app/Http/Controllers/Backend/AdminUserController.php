<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\DataTables;

class AdminUserController extends Controller
{
    public function ssd()
    {
        $user = AdminUser::query();

        return DataTables::of($user)->
            editColumn('created_at', function ($user) {

            $time = $user->created_at ? $user->created_at->diffForHumans() : '';
            return $time;
        })->
            addColumn('select', function ($user) {
            if ($user->id == '1') {
                return '';
            }
            $checkbox = "<div><input id='$user->id' type='checkbox' name='$user->id'/></div>";
            return $checkbox;
        })->
            editColumn('user_agent', function ($user) {
            if ($user->user_agent) {
                $agent = new Agent();
                $agent->setUserAgent($user->user_agent);
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();
                $table = "<table><tbody>
                    <tr><td>Device</td><td>$device</td></tr>
                    <tr><td>Platform</td><td>$platform </td></tr>
                    <tr><td>Browser</td><td>$browser</td></tr>
                    </tbody></table>";
                return $table;
            }
            return '-';
        })->
            addColumn('action', function ($user) {
            if ($user->id == '1') {
                return '';
            }
            $url = route('admin.admin-users.edit', $user->id);
            $edit_btn = "<a href=$url class='btn btn-xs btn-primary'><i class='fas fa-edit'></i> </a>";
            $delete_btn = "<button id='$user->id' class='btn btn-xs btn-danger delete'><i class='fas fa-trash'></i></button>";

            return "<div>$edit_btn.$delete_btn</div>";
        })
            ->rawColumns(['select', 'action', 'user_agent'])
            ->make(true);
    }

    public function index()
    {

        return view('backend.admin_user.index');
    }
    public function create()
    {
        return view('backend.admin_user.create');

    }
    public function store(AdminUserStoreRequest $request)
    {

        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.admin-users.index')->with('message', 'Successfully Created User');
    }

    public function edit($id)
    {
        $user = AdminUser::find($id);
        return view('backend.admin_user.edit', compact('user'));
    }
    public function update($id, AdminUserUpdateRequest $request)
    {
        $user = AdminUser::findOrFail($id);
        $password = $request->password ? Hash::make($request->password) : $user->password;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
        ]);
        return redirect()->route('admin.admin-users.index')->with('message', 'Successfully Updated User');

    }
    public function destroy($id)
    {
        AdminUser::findOrFail($id)->delete();
        return response()->json(['success' => "User Deleted successfully."]);

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        AdminUser::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Users Deleted successfully."]);
    }
}
