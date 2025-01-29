<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function deposit(DepositRequest $request, $userId)
    {
        $validated = $request->validated();
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Provided ID is invalid',
            ], 404);
        }

        DB::beginTransaction();

        try {
            $user->balance += $validated['amount'];
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'type' => 'deposit',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Deposit successful',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Deposit failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function withdraw(WithdrawRequest $request, $userId)
    {
        $validated = $request->validated();
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Provided ID is invalid',
            ], 404);
        }

        if ($user->balance < $validated['amount']) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient funds'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $user->balance -= $validated['amount'];
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $validated['amount'],
                'type' => 'withdrawal',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Withdrawal successful',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Withdrawal failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
