<?php

namespace App\Observers;

use App\Payment;

class PaymentObserver
{
    function updated(Payment $payment)
    {
        if (request('update_path') == 'edit') {
            $description = '';

            $keys = ['cash' => 'efectivo', 'check' => 'cheque', 'transfer' => 'transferencia', 'credit_card' => 't. crédito', 'debit_card' => 't. débito', 'reference' => 'referencia', 'card_number' => 'número de tarjeta'];

            foreach ($keys as $key => $value) {
                if ($payment->wasChanged($key)) {
                    $description .= 'La columna ' . $value . ' ahora tiene el valor de ' . $payment->$key . ' (antes era ' . $payment->getOriginal($key) . '), ';
                }
            }

            // dd($description);

            $payment->logs()->create([
                'description' => $description,
                'user_id' => auth()->user()->id,
            ]);
        }
    }
}
