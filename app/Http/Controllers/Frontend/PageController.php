<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Transcation;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.home');
    }

    public function account()
    {
        return view('frontend.account');
    }

    public function editPassword()
    {
        return view('frontend.update_password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $auth = auth()->user();
        if (!Hash::check($request->old_password, $auth->password)) {
            return redirect()->back()->withErrors(['old-password' => 'Wrong Password!']);
        }
        $auth->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('account')->with('message', 'Successfully Updated Password!');
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id', auth()->user()->id)->with('user')->first();

        return view('frontend.wallet', compact('wallet'));
    }

    public function transfer(Request $request)
    {
        $auth = auth()->guard('web')->user();
        if ($request->to_phone) {
            if ($to_user = DB::table('users')
                ->select('name','phone')
                ->where('phone', $request->to_phone)
                ->first()) {
                return view('frontend.transfer', compact('auth', 'to_user'));
            }
            return redirect()->back()->with(['fail' => 'Invalid phone number']);
        }
        return view('frontend.transfer', compact('auth'));
    }

    public function confirmTransfer($request, $to_user, $auth)
    {
        $wallet_amount = $auth->wallet->amount;
        if (!$to_user) {
            return ['isConfirmed' => false, 'to_phone' => 'This phone number do not have account'];
        }
        if ($wallet_amount < $request->amount) {
            return ['isConfirmed' => false, 'amount' => 'Exceeded amount'];
        }
        if ($auth->phone == $request->to_phone) {
            return ['isConfirmed' => false, 'to_phone' => 'Invalid Phone Number'];
        }
        return ['isConfirmed' => true];
    }

    public function transferConfirmation(TransferRequest $request)
    {
        $to_user = User::where('phone', $request->to_phone)->first();
        $auth = auth()->guard('web')->user();

        $confirmTransfer = $this->confirmTransfer($request, $to_user, $auth);
        if (!$confirmTransfer['isConfirmed']) {
            return redirect()->route('transfer')->withErrors($confirmTransfer)->withInput();
        }

        $data = [
            'from_phone' => $auth->phone,
            'to_name' => $to_user->name,
            'to_phone' => $request->to_phone,
            'amount' => $request->amount,
            'description' => $request->description,
        ];

        return view('frontend.transfer_confirmation', compact('data'));

    }

    public function checkUser(Request $request)
    {
        if ($request->to_phone == auth()->guard('web')->user()->phone) {
            return response()->json(['success' => false, 'user' => 'Invalid']);
        }
        if ($user = DB::table('users')
            ->select('name')
            ->where('phone', $request->to_phone)
            ->first()) {
            return response()->json(['success' => true, 'user' => $user->name]);
        }
        return response()->json(['success' => false, 'user' => 'Not Found']);
    }

    public function checkPassword(Request $request)
    {
        if (Hash::check($request->password, auth()->guard('web')->user()->password)) {
            return response()->json(['confirmed' => true]);
        }
        return response()->json(['confirmed' => false]);

    }

    public function transferProcess(TransferRequest $request)
    {
        $to_user = User::where('phone', $request->to_phone)->first();
        $auth = auth()->guard('web')->user();

        $confirmTransfer = $this->confirmTransfer($request, $to_user, $auth);
        if (!$confirmTransfer['isConfirmed']) {
            return redirect()->route('transfer')->withErrors($confirmTransfer)->withInput();
        }

        DB::beginTransaction();
        try {

            $from_wallet = $auth->wallet;
            $to_wallet = $to_user->wallet;

            if (!$from_wallet && !$to_wallet) {
                throw new Exception();
            }

            $from_wallet->decrement('amount', $request->amount);
            $to_wallet->increment('amount', $request->amount);

            $ref_no = UUIDGenerator::ref_no();
            Transcation::create([
                'ref_no' => $ref_no,
                'trx_id' => UUIDGenerator::trx_id(),
                'user_id' => $auth->id,
                'type' => 2,
                'amount' => $request->amount,
                'source_id' => $to_user->id,
                'description' => $request->description,
            ]);
            Transcation::create([
                'ref_no' => $ref_no,
                'trx_id' => UUIDGenerator::trx_id(),
                'user_id' => $to_user->id,
                'type' => 1,
                'amount' => $request->amount,
                'source_id' => $auth->id,
                'description' => $request->description,
            ]);
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('home')->with(['fail' => 'Something wrong'])->withInput();
        }

        return redirect()->route('home')->with(['message' => 'Successfully transfer']);
    }

    public function qrCode()
    {
        return view('frontend.QRcode');
    }

    public function scan()
    {
        return view('frontend.scan');
    }

    public function transaction(){
        $user_id=auth()->user()->id;

        $transactions=Transcation::where('user_id',$user_id)->get();
        return view('frontend.transaction',compact('transactions'));
    }
}
