<?php

namespace App\Rules;

use App\Models\Sign\MasterSignature;
use App\Models\SignatureHeader;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidationPinCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $signatureCode;
    protected $step;
    protected $pincode;
    
    public function __construct($signature_code, $step,$pincode)
    {
        $this->signature_code = $signature_code;
        $this->step = $step;
        $this->pincode = $pincode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        
        $head= SignatureHeader::where('signature_code',$this->signature_code)->first();
        $result = false;
        $detail =User::where('id', $head->step_approval_id)
                    ->first();        
        $result = $detail->pincode == $this->pincode ? true : false;
        return $result;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'invalid pincode, remember your pincode';
    }
}
