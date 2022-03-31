<template>
    <div class="OrderProducts">
        <label>Upiše Proizvod za Dodati</label>
        <input type="text" v-model="query" @keyup="autoComplete" class="form-control">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group agm">
                <li class="list-group-item" v-for="result in results" @click="select(result)">
                    {{ result.name }}
                </li>
            </ul>
        </div>

        <div class="block black mt-50" v-if="items.length">
            <!--<div class="block-header block-header-default">
                Proizvodi
            </div>-->
            <div class="block-content-full">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr class="bg-light">
                        <th class="text-center px-0" style="width: 20px;"></th>
                        <th class="text-center" style="width: 45px;">#</th>
                        <th>Ime</th>
                        <th class="text-center" style="width: 72px;">Kol.</th>
                        <th class="text-right" style="width: 99px;">Cijena</th>
                        <th class="text-right" style="width: 99px;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in items">
                        <td class="text-center px-0"><i class="si si-trash text-danger float-right" style="margin-top: 2px; cursor: pointer;" @click="removeRow(index)"></i></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ product.name }}</td>
                        <td class="text-center">
                            <div class="form-material" style="padding-top: 0;">
                                <input type="text" class="form-control py-0" style="height: 26px;" :value="product.quantity" @keyup="ChangeQty(product.id, $event)" @blur="Recalculate()">
                            </div>
                        </td>
                        <td class="text-right">{{ Number(product.price).toFixed(2) }} kn</td>
                        <td class="text-right font-w600">{{ Number(product.quantity * product.price).toFixed(2) }} kn</td>
                    </tr>

                    <tr v-if="totals.length" v-for="(total, index) in sums">
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-right">
                            <span v-if="total.code == 'shipping'" class="mr-10">
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" v-model="is_shipping" class="css-control-input" :checked="is_shipping" @change="Recalculate()">
                                    <span class="css-control-indicator"></span>
                                </label>
                            </span>
                            {{ total.name }}:
                        </td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-w600">{{ Number(total.value).toFixed(2) }} kn</td>
                    </tr>

                    <input type="hidden" :value="JSON.stringify(items)" name="items">
                    <input type="hidden" :value="JSON.stringify(sums)" name="sums">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            products: {
                type: Object,
                required: false,
                default: []
            },
            totals: {
                type: Object,
                required: false,
                default: []
            },
            products_autocomplete_url: {
                type: String,
                required: true
            }
        },
        //
        data() {
            return {
                query: '',
                results: [],
                items: [],
                sums: [],
                selected_product: {},
                is_shipping: true,
                shipping_value: 30,
                is_action: false,
                action_value: 0
            }
        },
        //
        mounted() {
            if (this.products.length && this.totals.length) {
                this.products = JSON.parse(this.products)
                this.totals = JSON.parse(this.totals)
                this.Sort()
            }

            console.log(this.totals)
        },
        //
        methods: {
            //
            Sort() {
                this.products.forEach((item) => {
                    this.items.push({
                        id: item.product_id,
                        name: item.name,
                        quantity: item.quantity,
                        price: item.price,
                        total: item.total,
                        action: item.product.actions ? -item.price * (item.product.actions.discount / 100) * item.quantity : 0
                    })
                })

                this.Recalculate()
            },
            //
            select(selected) {
                this.results = []
                this.query = ''

                this.items.push({
                    id: selected.id,
                    name: selected.name,
                    quantity: 1,
                    price: selected.price,
                    total: selected.price,
                    action: selected.actions ? -selected.price * (selected.actions.discount / 100) : 0
                })

                this.Recalculate()
            },
            //
            removeRow(row, product) {
                this.items.splice(row, 1)

                if ( ! this.items.length) {
                    this.sums = []
                }

                this.Recalculate()
            },
            //
            ChangeQty(id, event) {
                for (let i = 0; i < this.items.length; i++) {
                    if (this.items[i].id == id) {
                        let old_qty = this.items[i].quantity

                        this.items[i].quantity = Number(event.target.value)
                        this.items[i].action = (this.items[i].action / old_qty) * this.items[i].quantity
                    }
                }
            },
            //
            Recalculate() {
                let shipping = this.calculateShipping();
                this.sums = []
                this.action_value = 0
                let subtotal = 0
                let total = 0

                this.items.forEach((item) => {
                    let price = item.price
                    this.action_value += item.action

                    if (item.action) {
                        this.is_action = true
                    }

                    subtotal += price * item.quantity
                })

                this.sums.push({
                    name: 'Ukupno',
                    value: subtotal,
                    code: 'subtotal'
                })

                if (this.is_action) {
                    this.sums.push({
                        name: 'Popust',
                        value: this.action_value,
                        code: 'action'
                    })
                }

                this.sums.push({
                    name: 'Poštarina',
                    value: shipping,
                    code: 'shipping'
                })

                total = subtotal + this.action_value + shipping

                this.sums.push({
                    name: 'Sveukupno',
                    value: total,
                    code: 'total'
                })
            },
            //
            autoComplete() {
                this.results = []

                if (this.query.length > 1) {
                    axios.get(this.products_autocomplete_url, { params: { query: this.query }}).then(response => {
                        this.results = response.data;
                    })
                }
            },
            //
            calculateShipping() {
                let ship_value = 0;

                this.totals.forEach((total) => {
                    if (total.code == 'shipping') {
                        ship_value = Number(total.value);
                    }
                });

                console.log(ship_value)

                if (!ship_value) {
                    this.is_shipping = false;
                }

                return ship_value;
            }
        }
    };
</script>

<style>
    .panel-footer {
        width: 100%;
        position: absolute;
        z-index: 999;
        padding-right: 30px;
    }

    ul li agm {
        cursor: pointer;
    }
    ul li:hover agm {
        background-color: #eeeeee;
    }
</style>
