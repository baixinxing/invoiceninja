<?php namespace App\Http\Requests;

class UpdateInvoiceRequest extends InvoiceRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('edit', $this->entity());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $invoiceId = $this->entity()->id;
        
        $rules = [
            'client.contacts' => 'valid_contacts',
            'invoice_items' => 'valid_invoice_items',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoiceId . ',id,account_id,' . $this->user()->account_id,
            'discount' => 'positive',
        ];

        /* There's a problem parsing the dates
        if (Request::get('is_recurring') && Request::get('start_date') && Request::get('end_date')) {
            $rules['end_date'] = 'after' . Request::get('start_date');
        }
        */

        return $rules;
    }
}
