<table id="productTable" class="table table-bordered table-striped speedy-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Product Sku</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Tax</th>
            <th>Shipping Price</th>
            <th>Order Date</th>
            <th>Invoice No</th>
            <th>Address 1</th>
            <th>Payment Name</th>
            <th>Payment Company</th>
            <th>Payment Addres</th>
            <th>Payment Code</th>
            <th>Shipping Name</th>
            <th>Shipping Company</th>
            <th>Shipping Address</th>
            <th>Shipping City</th>
            <th>Shipping Method</th>
            <th>Latest Comment</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orderProducts as $orderProduct)
        <tr>
            <td>{{ $orderProduct->order->first_name.' '.$orderProduct->order->last_name }}</td>
            <td>{{ $orderProduct->order->email }}</td>
            <td>{{ $orderProduct->sku }}</td>
            <td>{{ $orderProduct->price }}</td>
            <td>{{ $orderProduct->quantity }}</td>
            <td>{{ $orderProduct->tax }}</td>
            <td>{{ $orderProduct->shipping_price }}</td>
            <td>{{ $orderProduct->created_at }}</td>
            <td>{{ $orderProduct->order->invoice_number }}</td>
            <td>{{ $orderProduct->order->address1 }}</td>
            <td>{{ $orderProduct->order->payment_first_name.' '.$orderProduct->order->payment_last_name  }}</td>
            <td>{{ $orderProduct->order->payment_company }}</td>
            <td>{{ $orderProduct->order->payment_address1 }}</td>
            <td>{{ $orderProduct->order->payment_unique_code }}</td>
            <td>{{ $orderProduct->order->shipping_first_name.' '.$orderProduct->order->shipping_last_name }}</td>
            <td>{{ $orderProduct->order->shipping_company }}</td>
            <td>{{ $orderProduct->order->shipping_address1 }}</td>
            <td>{{ $orderProduct->order->shipping_city }}</td>
            <td>{{ $orderProduct->order->shipping_method }}</td>
            <td>{{ $orderProduct->order->orderHistories[0]->comment?? ' ' }}</td>
        </tr>

        @empty
        <tfoot>
            <tr>
                <td class="text-center" colspan="10">
                    <span>No data available in the table...</span>
                </td>
            </tr>
        </tfoot>
        @endforelse
    </tbody>
    </table>
