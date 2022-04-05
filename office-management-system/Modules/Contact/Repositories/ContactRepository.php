<?php

namespace Modules\Contact\Repositories;

use App\Traits\ImageStore;
use App\Traits\SendMail;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Importer;
use Modules\Account\Entities\ChartAccount;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Repositories\OpeningBalanceHistoryRepository;
use Modules\Contact\Entities\ContactModel;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Sale\Entities\Sale;

class ContactRepository implements ContactRepositoriesInterface
{
    use ImageStore;
    use SendMail;

    public function all()
    {
        return ContactModel::all();
    }

    public function serachBasedSupplier($search_keyword)
    {
        return ContactModel::whereLike(['business_name', 'name', 'email', 'mobile', 'tax_number'], $search_keyword)->supplier()->get();
    }

    public function serachBasedCustomer($search_keyword)
    {
        return ContactModel::whereLike(['business_name', 'name', 'email', 'mobile', 'tax_number'], $search_keyword)->customer()->get();
    }

    public function create(array $data)
    {
        $contact = new ContactModel();
        if (isset($data['file'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['file']));
        }

        $contact->fill($data)->save();
        if (app('general_setting')->first()->contact_login) {
            $user = new User();
            $user->name = $data['name'];
            $user->avatar = $data['avatar'] ?? '';
            $user->email = $data['email'];
            $user->is_active = 1;
            $user->password = bcrypt($data['password']);
            if ($contact->contact_type == 'Supplier') {
                $user->role_id = 4;
            } else {
                $user->role_id = 5;
            }
            $user->contact_id = $contact->id;
            $user->save();
            $contact->user_id = $user->id;
            $contact->save();
        }
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $contact->name;
        $chart_account->description = null;
        $chart_account->configuration_group_id = null;
        $chart_account->status = 1;
        if ($contact->contact_type == 'Supplier') {
            $chart_account->parent_id = 8;
            $chart_account->type = 2;
        } else {
            $chart_account->parent_id = 5;
            $chart_account->type = 1;
        }
        $chart_account->contactable_type = get_class(new ContactModel());
        $chart_account->contactable_id = $contact->id;
        $chart_account->save();

        $data = ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . sprintf('%02d', $chart_account->parent_id) . '-' . $chart_account->id]);
        if ($contact->opening_balance != null && $contact->opening_balance > 0) {
            $repo = new OpeningBalanceHistoryRepository();
            if ($contact->contact_type == 'Supplier') {
                $repo->createForUser([
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => $chart_account->id,
                    'liability_amount' => $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
                $repo->createForUser([
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                    'liability_amount' => '-' . $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                $repo->createForUser([
                    'asset_account_id' => $chart_account->id,
                    'asset_amount' => $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                    'liability_amount' => $contact->opening_balance,
                ]);
            }
            $repo->createForHistory([
                'account_id' => $chart_account->id,
                'type' => strtolower($contact->contact_type),
                'amount' => $contact->opening_balance,
            ]);
        }

        return $contact;
    }

    public function find($id)
    {
        return ContactModel::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $contact = ContactModel::findOrFail($id);
        if (isset($data['file'])) {
            if (File::exists($contact->avatar)) {
                File::delete($contact->avatar);
            }
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['file']));
        }
        $contact->update($data);
        if (app('general_setting')->first()->contact_login) {
            $user = User::find($contact->user_id);
            if (!$user) {
                $user = new User();
            }
            $user->name = $data['name'];
            $user->photo = $data['avatar'] ?? '';
            $user->avatar = $data['avatar'] ?? '';
            $user->email = $data['email'];
            if (isset($data['password']) && $data['password']) {
                $user->password = bcrypt($data['password']);
            }

            if ($contact->contact_type == 'Supplier') {
                $user->role_id = 4;
            } else {
                $user->role_id = 5;
            }

            $user->contact_id = $contact->id;

            $user->save();

            $contact->user_id = $user->id;
            $contact->save();
        }

        return $contact;
    }

    public function updateProfile(array $data, $id)
    {
        $contact = ContactModel::findOrFail($id);
        if (isset($data['file'])) {
            if (File::exists($contact->avatar)) {
                File::delete($contact->avatar);
            }
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['file']));
        }

        $contact->update($data);

        $user = User::find($contact->user_id);
        if (!$user) {
            $user = new User();
        }
        $user->name = $data['name'];
        $user->photo = $data['avatar'] ?? '';
        $user->avatar = $data['avatar'] ?? '';
        $user->email = $data['email'];
        if (isset($data['password']) && $data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        $contact->user_id = $user->id;
        $contact->save();

        return $contact;
    }

    public function delete($id): void
    {
        $contact = ContactModel::findOrFail($id);
        if ($contact->contact_type == 'Customer') {
            if ($contact->sales->count()) {
                Toastr::error('Contact has Invoice');

                return;
            }
        }
        if ($contact->contact_type == 'Supplier') {
            if ($contact->purchases->count()) {
                Toastr::error('Supplier has Purchase');

                return;
            }
        }
        Toastr::success(__('contact.Contact Deleted Successfully'));
        $contact->delete();
    }

    public function supplier()
    {
        return ContactModel::supplier()->latest()->get();
    }

    public function aciveSupplier()
    {
        return ContactModel::supplier()->where('is_active', 1)->get();
    }

    public function customer()
    {
        return ContactModel::customer()->latest()->get();
    }

    public function witoutWalkInCustomer()
    {
        return ContactModel::witoutWalkInCustomer()->get();
    }

    public function posCustomer()
    {
        return ContactModel::where('is_active', 1)->where('contact_type', 'Customer')->get();
    }

    public function statusChange(array $data): void
    {
        $contact = ContactModel::findOrFail($data['id']);
        $contact->is_active = $data['status'];
        $contact->save();

        $user = $contact->user;
        if ($user) {
            $user->is_active = $data['status'];
            $user->save();
        }
    }

    public function customerSaleHistory($id)
    {
        $saleHistory = ProductItemDetail::with('itemable', 'productSku.product')->whereHasMorph('itemable', [Sale::class], function ($query) use ($id): void {
            $query->where('customer_id', $id);
        })->get();

        return $saleHistory;
    }

    public function supplierPurchaseHistory($id)
    {
        $purchaseHistory = ProductItemDetail::with('itemable', 'productSku.product')->whereHasMorph('itemable', [PurchaseOrder::class], function ($query) use ($id): void {
            $query->where('supplier_id', $id);
        })->get();

        return $purchaseHistory;
    }

    public function csv_contact_upload($data): void
    {
        if (!empty($data['file'])) {
            ini_set('max_execution_time', 0);
            $a = $data['file']->getRealPath();
            $column_name = Importer::make('Excel')->load($a)->getCollection()->take(1)->first();
            foreach (Importer::make('Excel')->load($a)->getCollection()->skip(1) as $ke => $row) {
                $contact = ContactModel::create([
                    str_replace(' ', '', $column_name[0]) => $row[0],
                    str_replace(' ', '', $column_name[1]) => $row[1],
                    str_replace(' ', '', $column_name[2]) => $row[2],
                    str_replace(' ', '', $column_name[3]) => $row[3],
                    str_replace(' ', '', $column_name[4]) => $row[4],
                    str_replace(' ', '', $column_name[5]) => $row[5],
                    str_replace(' ', '', $column_name[6]) => $row[6],
                    str_replace(' ', '', $column_name[7]) => $row[7],
                    str_replace(' ', '', $column_name[8]) => $row[8],
                    str_replace(' ', '', $column_name[9]) => $row[9],
                    str_replace(' ', '', $column_name[10]) => (!empty($row[10])) ? $row[10] : 'n/a',
                ]);
                $this->create_chart_account($contact);
            }
        }
    }

    public function create_chart_account($contact): void
    {
        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $contact->name;
        $chart_account->description = null;
        $chart_account->configuration_group_id = null;
        $chart_account->status = 1;
        if ($contact->contact_type == 'Supplier') {
            $chart_account->parent_id = 8;
            $chart_account->type = 2;
        } else {
            $chart_account->parent_id = 5;
            $chart_account->type = 1;
        }
        $chart_account->contactable_type = get_class(new ContactModel());
        $chart_account->contactable_id = $contact->id;
        $chart_account->save();

        $data = ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-' . sprintf('%02d', $chart_account->parent_id) . '-' . $chart_account->id]);
        if ($contact->opening_balance != null && $contact->opening_balance > 0) {
            $repo = new OpeningBalanceHistoryRepository();
            if ($contact->contact_type == 'Supplier') {
                $repo->createForUser([
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => $chart_account->id,
                    'liability_amount' => $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
                $repo->createForUser([
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                    'liability_amount' => '-' . $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                $repo->createForUser([
                    'asset_account_id' => $chart_account->id,
                    'asset_amount' => $contact->opening_balance,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'time_period_id' => TimePeriodAccount::where('is_closed', 0)->latest()->first()->id,
                    'liability_account_id' => ChartAccount::where('code', '02-09-11')->first()->id,
                    'liability_amount' => $contact->opening_balance,
                ]);
            }
            $repo->createForHistory([
                'account_id' => $chart_account->id,
                'type' => strtolower($contact->contact_type),
                'amount' => $contact->opening_balance,
            ]);
        }
    }
}
