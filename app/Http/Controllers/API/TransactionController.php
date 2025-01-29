<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transfer(TransferRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $fromUser = User::find($validated['from_user_id']);
            $toUser = User::find($validated['to_user_id']);

            if (!$fromUser || !$toUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'One or both users do not exist'
                ], 404);
            }

            if ($fromUser->balance < $validated['amount']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient funds'
                ], 400);
            }

            $fromUser->balance -= $validated['amount'];
            $toUser->balance += $validated['amount'];

            $fromUser->save();
            $toUser->save();

            Transaction::create([
                'user_id' => $fromUser->id,
                'amount' => $validated['amount'],
                'type' => 'transfer',
                'target_user_id' => $toUser->id,
            ]);

            Transaction::create([
                'user_id' => $toUser->id,
                'amount' => $validated['amount'],
                'type' => 'transfer',
                'target_user_id' => $fromUser->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transfer successful',
                'from_user' => $fromUser,
                'to_user' => $toUser
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Transaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTransactions($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Provided ID is invalid',
            ], 404);
        }

        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'transactions' => $transactions
        ]);
    }
}
