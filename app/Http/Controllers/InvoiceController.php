<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Menampilkan daftar invoice.
     */
    public function index()
    {
        $invoices = Invoice::with('order')->get();
        return response()->json($invoices);
    }

    /**
     * Menyimpan invoice baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'invoice_number' => 'required|string|max:500|unique:invoices',
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Pending,Paid,Cancelled',
            'issued_at' => 'required|date',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice = Invoice::create($request->all());

        return response()->json(['message' => 'Invoice created successfully', 'invoice' => $invoice], 201);
    }

    /**
     * Menampilkan detail invoice tertentu.
     */
    public function show($id)
    {
        $invoice = Invoice::with('order')->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json($invoice);
    }

    /**
     * Memperbarui invoice tertentu.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'exists:orders,id',
            'invoice_number' => 'string|max:500|unique:invoices,invoice_number,' . $id,
            'total_amount' => 'numeric|min:0',
            'payment_status' => 'in:Pending,Paid,Cancelled',
            'issued_at' => 'date',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice->update($request->all());

        return response()->json(['message' => 'Invoice updated successfully', 'invoice' => $invoice]);
    }

    /**
     * Menghapus invoice tertentu.
     */
    public function delete($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
