<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function ssd()
    {
        $user = User::query();

        return DataTables::of($user)->
            editColumn('login_at', function ($user) {
            $time = $user->login_at ? $user->login_at : '';
            return $time;
        })->
            addColumn('select', function ($user) {
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
            $url = route('admin.users.edit', $user->id);
            $edit_btn = "<a href=$url class='btn btn-xs btn-primary'><i class='fas fa-edit'></i> </a>";
            $delete_btn = "<button id='$user->id' class='btn btn-xs btn-danger delete'><i class='fas fa-trash'></i></button>";

            return "<div>$edit_btn.$delete_btn</div>";
        })
            ->rawColumns(['select', 'action', 'user_agent'])
            ->make(true);
    }

    public function index()
    {

        return view('backend.user.index');
    }
    public function create()
    {
        return view('backend.user.create');

    }
    public function store(UserStoreRequest $request)
    {

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            Wallet::updateOrCreate(
                ['user_id' => $user->id],
                ['account_number' => UUIDGenerator::accountNumber()]
            );
            DB::commit();

            return redirect()->route('admin.users.index')->with('message', 'Successfully Created User');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.users.index')->withErrors(['fail' => 'Something wrong'])->withInput();
        }

    }

    public function edit(User $user)
    {
        return view('backend.user.edit', compact('user'));

    }
    public function update($id, UserUpdateRequest $request)
    {
        $user = User::findOrFail($id);
        $password = $request->password ? Hash::make($request->password) : $user->password;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
        ]);
        return redirect()->route('admin.users.index')->with('message', 'Successfully Updated User');

    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => "User Deleted successfully."]);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Users Deleted successfully."]);
    }
}
