<?php

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Project;

if (!function_exists('getPaymentInvoice')) {
    function getPaymentInvoice($id) {
        $invoice = Invoice::find($id);
        $payment = InvoicePayment::where('id_inv',$id)->whereNull('deleted_at')->get()->sum('total');
        $sisa = $invoice->grand_total - $payment;
        $final = $sisa < 0 ? 0 : $sisa;
        $data[] = [
            'sisa' => $final,
            'payment' => $payment,
        ];
        return $data;
    }
}

if (!function_exists('totalRemainingProject')) {
    function totalRemainingProject($arr_id = null) {
        $query = Invoice::whereNull('deleted_at')->orderBy('created_at', 'desc');

        if (!is_null($arr_id)) {
            $query->whereIn('id', $arr_id);
        }

        $invoices = $query->get();
        $total_remaining = 0;

        foreach ($invoices as $inv) {
            $getPaymentInfo = getPaymentInvoice($inv->id);
            $remain = $getPaymentInfo[0]['sisa'];
            $total_remaining += $remain;
        }

        return $total_remaining;
    }
}


if (!function_exists('idStatusInvoice')) {
    function idStatusInvoice($status) {
        $invoices = Invoice::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        $invoiceIds = [];

        foreach ($invoices as $inv) {
            if ($inv->category == 1) {
                $getPaymentInfo = getPaymentInvoice($inv->id); // Asumsi method getPaymentInfo() ada di model Invoice
                if ($getPaymentInfo[0]['payment'] == 0) {
                    $currentStatus = 'UNPAID';
                } elseif ($getPaymentInfo[0]['sisa'] > 0) {
                    $currentStatus = 'PARTIAL';
                } else {
                    $currentStatus = 'PAID';
                }
            } else {
                $currentStatus = 'PAID';
            }

            if ($currentStatus == $status) {
                $invoiceIds[] = $inv->id;
            }
        }
        
        return $invoiceIds;
    }
}

