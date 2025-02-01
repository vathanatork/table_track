<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperadminPaymentGateway extends Model
{
    protected $guarded = ['id'];

    public function getRazorpayKeyAttribute()
    {
        return ($this->razorpay_type == 'test' ? $this->test_razorpay_key : $this->live_razorpay_key);
    }

    public function getRazorpaySecretAttribute()
    {
        return ($this->razorpay_type == 'test' ? $this->test_razorpay_secret : $this->live_razorpay_secret);
    }

    public function getStripeKeyAttribute()
    {
        return ($this->stripe_type == 'test' ? $this->test_stripe_key : $this->live_stripe_key);
    }

    public function getStripeSecretAttribute()
    {
        return ($this->stripe_type == 'test' ? $this->test_stripe_secret : $this->live_stripe_secret);
    }

}
