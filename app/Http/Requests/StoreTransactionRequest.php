<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // add policy check if needed
    }

    public function rules()
    {
        return [
            'reference' => 'required|string|unique:transactions,reference',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'journal' => 'required|array|min:2',
            'journal.*.coa_id' => 'required|exists:chart_of_accounts,id',
            'journal.*.debit' => 'nullable|numeric|min:0',
            'journal.*.credit' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'journal.min' => 'At least two journal lines required (one debit and one credit).',
        ];
    }
}
