<?php

namespace App\Http\Livewire;

use App\Models\Cat;
use App\Models\Customer;
use Illuminate\Support\MessageBag;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;
    // use MessageBag;

    public $ccat_id;

    public $mode;

    public $customer_id;

    public $message;

    public $search;

    public $password;

    public $title;

    public $name;

    public $content;

    protected $queryString = [
        'ccat_id',
        'mode',
        'customer_id',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name' => 'required|string|min:3|max:20',
        'password' => 'required|string|min:3|max:20',
        'title' => 'required|string|min:3|max:20',
        'content' => 'required|string|min:6|max:1000',
    ];
    // public function hydrate()
    // {
    //     $this->resetErrorBag();
    //     $this->resetValidation();
    // }

    public function updating($name, $value): void
    {
        $this->emit('urlChanged', http_build_query([$name => $value]));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingMode(): void
    {
        // dd('123');
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::where('ccat_id', $this->ccat_id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        $customers->withPath('customers');

        $customer = Customer::where('id', $this->customer_id)->first();
        $ccat = Cat::find($this->ccat_id);

        return view('livewire.customers', [
            'ccat' => $ccat,
            'customer' => $customer,
            'customers' => $customers,
        ]);
    }

    public function mount($ccatid): void
    {
        // session()->flash('message', 'Post successfully updated.');
        // $this->fill(request()->only('search', 'page'));
        $this->ccat_id = $ccatid;
    }

    public function setMode($mode, $customer_id = null): void
    {
        $this->resetPage();
        $this->mode = $mode;
        $this->customer_id = $customer_id;
    }

    public function setPassword(): void
    {
        $this->checkPassword($this->ccat_id, $this->customer_id, $this->password);
    }

    protected function chechkPassword($ccat_id, $customer_id, $password): void
    {
        $customer = Customer::where('ccat_id', $ccat_id)
            ->where('id', $customer_id)
            ->where('password', $password);
        $exists = $customer->exists();
        if ($exists) {
            $this->customer = $customer->first();
        } else {
            $this->errors['customer'] = 'no Data';
        }
    }

    public function saveMessage(): void
    {
        $customer = Customer::create(
            [
                'ccat_id' => $this->ccat_id,
                'name' => $this->name,
                'password' => $this->password,
                'title' => $this->title,
                'content' => $this->content,
                'user_ip' => request()->ip(),
            ]
        );

        if ($customer) {
            session()->flash('message', '문의가 입력되었습니다.');
            $this->mode = null;
        }
    }

    public function showMe($customer_id): void
    {
        $this->customer_id = $customer_id;
        $this->mode = 'show';
    }
}
