<?php

namespace App\Traits;

use Modules\Account\Entities\ChartAccount;
use Modules\Setup\Entities\Tax;

trait Accounts
{
    public function defaultSalesAccount()
    {
        return ChartAccount::where('code', '04-15')->first()->id;
    }

    public function defaultSalesReturnAccount()
    {
        return ChartAccount::where('code', '03-23')->first();
    }

    public function defaultProductTaxAccount()
    {
        return ChartAccount::where('code', '02-12-13')->first()->id;
    }

    public function othersTaxAccountByTaxId($id)
    {
        if (Tax::findOrFail($id)->account) {
            return Tax::findOrFail($id)->account->id;
        }

        return $this->defaultProductTaxAccount();
    }

    public function shippingOrOthersChargeIncome()
    {
        return ChartAccount::where('code', '04-16-28')->first()->id;
    }

    public function shippingOrOthersChargeExpense()
    {
        return ChartAccount::where('code', '01-27')->first()->id;
    }

    public function defaultOtherPurchaseTaxAccount()
    {
        return ChartAccount::where('code', '01-27')->first()->id;
    }

    public function defaultPurchaseAccount()
    {
        return ChartAccount::where('code', '01-07')->first()->id;
    }

    public function defaultPurchaseReturnAccount()
    {
        return ChartAccount::where('code', '04-24')->first();
    }

    public function defaultCostofGoodsSoldAccount()
    {
        return ChartAccount::where('code', '03-19')->first()->id;
    }

    public function defaultWalkInCustomerAccount()
    {
        return ChartAccount::where('code', '01-05-25')->first();
    }

    public function inventoryBankAccount($account_id)
    {
        return ChartAccount::findOrFail($account_id)->id;
    }

    public function AccountFind($contactable_id, $contactable_type)
    {
        return ChartAccount::where('contactable_id', $contactable_id)->where('contactable_type', $contactable_type)->first();
    }

    public function GetAccountId($contactable_id, $contactable_type)
    {
        return ChartAccount::where('contactable_id', $contactable_id)->where('contactable_type', $contactable_type)->first()->id;
    }

    public function defaultRetailEarningProfitAccount()
    {
        return ChartAccount::where('code', '02-14')->first()->id;
    }
}
