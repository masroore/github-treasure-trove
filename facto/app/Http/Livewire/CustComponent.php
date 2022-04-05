<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustComponent extends Component
{
    public $customer_id;

    public $page;

    public $checked = false;

    public $password;

    public $message;

    public $test;

    public function render()
    {
        $customer = Customer::find($this->customer_id);

        return view('livewire.cust-component', [
            'title' => $customer->title,
            'customer' => $customer,
        ]);
    }

    public function mount($customerid, $page)
    {
        $this->customer_id = $customerid;
        $this->checked = false;
        $this->page = $page;

        $key = 'cust-pass-' . $this->customer_id;
        $this->test = session()->get($key);

        if (session()->get($key) == 'ok') {
            return redirect()->route('customers.show', [
                'customer' => $this->customer_id,
            ]);
        }
        // dd('22  ');
    }

    public function updatingPassword(): void
    {
        $this->message = '';
    }

    public function checkPassword()
    {
        sleep(1);
        $customer = Customer::find($this->customer_id);
        if ($customer->password == $this->password) {
            $key = 'cust-pass-' . $this->customer_id;
            session()->put($key, 'ok');

            return redirect()->route('customers.show', [
                'customer' => $this->customer_id,
            ]);
        }
        $this->message = '비밀번호가 일치하지 않습니다.';
        $this->reset('password');
    }
}
