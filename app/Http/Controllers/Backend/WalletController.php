<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WalletController extends Controller
{
    public function ssd()
    {
        $user = Wallet::with('user');

        return DataTables::of($user)->
            editColumn('created_at', function ($each) {
            $time = $each->created_at ? $each->created_at : '';
            return $time;
        })->
            editColumn('updated_at', function ($each) {
            $time = $each->updated_at ? $each->updated_at->diffForHumans() : '';
            return $time;
        })->
            addColumn('select', function ($each) {
            $checkbox = "<div><input id='$each->id' type='checkbox' name='$each->id'/></div>";
            return $checkbox;
        })->
            addColumn('user_account', function ($each) {
            $user = $each->user;
            if ($user) {
                $user_account = "<p>Name : $user->name</p><p>Email : $user->email</p><p>Phone : $user->phone</p>";
                return $user_account;
            }
            return '-';
        })->
            addColumn('action', function ($each) {
            $url = route('admin.users.edit', $each->id);
            $edit_btn = "<a href=$url class='btn btn-xs btn-primary'><i class='fas fa-edit'></i> </a>";
            $delete_btn = "<button id='$each->id' class='btn btn-xs btn-danger delete'><i class='fas fa-trash'></i></button>";

            return "<div>$edit_btn.$delete_btn</div>";
        })
            ->rawColumns(['select', 'action', 'user_account'])
            ->make(true);
    }

    public function index()
    {

        return view('backend.wallet.index');
    }
    public function create()
    {
        return abort(404);
    }

    public function edit()
    {
        return abort(404);
    }

    public function destroy($id)
    {
        Wallet::findOrFail($id)->delete();
        return response()->json(['success' => "User Deleted successfully."]);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        Wallet::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "Users Deleted successfully."]);
    }
}
