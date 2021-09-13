<?php


namespace App\services;


use App\Models\Invoice;
use App\Models\InvoiceInfo;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    /**
     *
     * This function generates the invoices for all the active members
     */
    public function generateMemberFeeInvoices(){

    }

    /*
     *
     * This function generates the late Fees for all of the overdue loans
     * this function is run every day at 00:00:00
     * */
    public function generateLateFeeInvoices(){

    }

    /*
     * get All the information (member , reason and payments for the selected fee)
     * */
    public function getInvoiceInfo($invoiceId){
        return InvoiceInfo::where('id','=',$invoiceId)->select('*')->first();
    }

    public function makePayment(array $data){
        try{
            DB::transaction(function() use($data){
               Payment::create($data);
               $invoice = Invoice::findOrFail($data['invoice_id']);
               if($data['amount'] >= $invoice->open_amount){
                   $invoice->open_amount = 0;
                   $invoice->paid_date = Carbon::now()->toDateTimeString();
                   $invoice->status_id = 6;
               }
               else{
                   $invoice->open_amount = $invoice->open_amount - $data['amount'];
                   $invoice->status_id = 9;
               }
               $invoice->save();
            });
            return true;
        }
        catch (Exception $e){
            return false;
        }
    }

    public function updatePayment($paymentId, array $data){

    }

    public function deletePayment($paymentId){
        try {
            $payment = Payment::findOrFail($paymentId);
            $invoice = Invoice::findOrFail($payment->invoice_id);
            $invoice->open_amount = $invoice->open_amount + $payment->amount;
            $invoice->status_id = 10;
            $invoice->save();
            $payment->delete();
            return true;
        }
        catch (Exception $e){
            return false;
        }
    }
    public function getPayments(array $filterOptions){
        $payments = DB::table('payment_info')->select('*');
        if(isset($filterOptions['invoiceId']) && $filterOptions['invoiceId'] != 0){
            $payments = $payments->where('invoice_id','=',$filterOptions['invoiceId']);
        }
        return $payments;
    }

    public function getInvoices(array $filterOptions){
        $invoices = DB::table('invoice_info')->select('*');
        if(isset($filterOptions['type_id']) && $filterOptions['type_id'] != 0){
            $invoices = $invoices->where('invoice_type','=',$filterOptions['type_id']);
        }
        if(isset($filterOptions['status_id']) && $filterOptions['status_id'] != 0){
            $invoices = $invoices->where('status_id','=',$filterOptions['status_id']);
        }
        if(isset($filterOptions['member_id']) && $filterOptions['member_id'] != 0){
            $invoices = $invoices->where('member_id', '=', $filterOptions['member_id']);
        }
        return $invoices;
    }

    public function updateInvoice($invoiceId, array $data){
        $invoice = Invoice::findOrFail($invoiceId);
        try {
            $paidAmount = $invoice->total_amount - $invoice->open_amount;
            $invoice->update([
                'total_amount' =>$data['amount'],
                'open_amount' =>$data['amount'] - $paidAmount,
                'invoice_date' => Carbon::parse($data['invoice_date'])->toDateTimeString(),
                'member_id' => $data['member_id'],
                'invoice_type' => $data['invoice_type']
            ]);
            return true;
        }
        catch (Exception $exception){
            return false;
        }
    }

    public function deleteInvoice($invoiceId){
        $result = true;
        try{
            $invoice = Invoice::findOrFail($invoiceId);
            $invoice->delete();
            $result = true;
        }
        catch (Exception $e){
            $result = false;
        }
        return $result;
    }

    public function addInvoice(array $data){
        $result = true;
        try {
            $$result = DB::table('invoices')->insert([
                'member_id' => $data['member_id'],
                'status_id' => 10,
                'invoice_type' => $data['invoice_type'],
                'invoice_date' => $data['invoice_date'],
                'total_amount' => $data['amount'],
                'open_amount' => $data['amount'],
                'paid' => false,
                'paid_date' => null,
                'description' => $data['description'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
            $result = true;
        }
        catch (Exception $e){
            $result = false;
        }
        return $result;
    }
}
