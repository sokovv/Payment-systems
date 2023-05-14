<?php

namespace App\Services;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

/**
 * Summary of TransferService
 */
class TransferService
{
    public $data;

    /**
     * Summary of transferCreate
     * @param mixed $sum_client
     * @param mixed $name_client
     * @param mixed $date_transfer
     * @return array
     */
    public function transferCreate($sum_client, $name_client, $date_transfer, $id_client): array
    {
        $user = Auth::user();
        $user_active = User::class::find($user->id);
        $user_active->balance -= (int) $sum_client;
        $user_active->save();


        $this->data = [
            'user_id' => $user->id,
            'name_sender' => $user->name,
            'name_recipient' => $name_client,
            'id_recipient' => $id_client,
            'summa' => $sum_client,
            'date_transfer' => $date_transfer,

        ];

        return $this->data;
    }

}
