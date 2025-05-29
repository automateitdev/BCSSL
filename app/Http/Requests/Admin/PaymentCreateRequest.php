<?php

namespace App\Http\Requests\Admin;

use App\Models\PaymentInfo;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PaymentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // public function rules()
    // {
    //     // dd(request()->all());
    //     $roles = [
    //         // 'ladger_id' => 'required|numeric',
    //         'ladger_id' =>  isset(request()->payment_type) && request()->payment_type == PaymentInfo::PAYMENT_TYPE_MANUAL  ? ['required','numeric'] : ['nullable'],
    //         'total_amount' => ['required','numeric'] ,
    //         'member_id' => ['required','numeric','exists:members,id'],
    //         'fee_assign_id' => ['required'],
    //         'fee_assign_id.*' => ['required'],
    //     ];

    //     if(Auth::guard('admin')->check()){
    //         $roles['document_files'] = 'nullable';
    //         $roles['document_files.*'] = 'nullable';
    //         $roles['payment_type'] = 'nullable';
    //     }else{
    //         if(request()->payment_type == PaymentInfo::PAYMENT_TYPE_MANUAL){
    //             $roles['document_files'] = ['required'];
    //             $roles['document_files.*'] = ['required'];
    //         }

    //         $roles['payment_type'] = ['required'];
    //     }
    //         // dd(request()->all());
    //     return $roles;
    // }

    public function rules()
    {
        $paymentType = data_get(request()->all(), 'payment_type'); // Prevent undefined key error

        $rules = [
            'ladger_id' => ($paymentType == PaymentInfo::PAYMENT_TYPE_MANUAL) ? ['required', 'numeric'] : ['nullable'],
            'total_amount' => ['required', 'numeric'],
            'member_id' => ['required', 'numeric', 'exists:members,id'],
            'fee_assign_id' => ['required', 'array'], // Ensure it's an array
            'fee_assign_id.*' => ['required', 'numeric', 'exists:fee_assigns,id'], // Validate each ID properly
            // 'payment_type' => ['required', 'in:' . PaymentInfo::PAYMENT_TYPE_MANUAL . ',' . PaymentInfo::PAYMENT_TYPE_ONLINE],
        ];

        // Document files validation
        if (Auth::guard('admin')->check()) {
            $rules['document_files'] = ['nullable', 'array'];
            $rules['document_files.*'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx'];
            $rules['payment_type'] = ['nullable'];
        } else {
            $rules['payment_type'] = ['required', 'in:' . PaymentInfo::PAYMENT_TYPE_MANUAL . ',' . PaymentInfo::PAYMENT_TYPE_ONLINE];
            if ($paymentType == PaymentInfo::PAYMENT_TYPE_MANUAL) {
                $rules['document_files'] = ['required', 'array'];
                $rules['document_files.*'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx'];
            }
        }

        return $rules;
    }
}
