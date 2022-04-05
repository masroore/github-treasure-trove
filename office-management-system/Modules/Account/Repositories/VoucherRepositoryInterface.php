<?php

namespace Modules\Account\Repositories;

interface VoucherRepositoryInterface
{
    public function voucher_payment_all();

    public function voucher_recieve_all();

    public function voucher_list_all();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function delete($id);

    public function category();

    public function recieveCategoryAccounts();

    public function get_recieveByAccount_account();

    public function get_chart_account();

    public function CashPaymentAccount();

    public function BankPaymentAccount();

    public function LiabilityAccount();

    public function get_account(array $data);

    public function findChartAccount(array $data);

    public function status_approval(array $data);

    public function get_voucher_details(array $data);

    public function allApproved();

    public function expenses($type);

    public function dailyProfit($id);

    public function weeklyProfit($id);

    public function monthlyProfit($id);

    public function yearlyProfit($id);
}
