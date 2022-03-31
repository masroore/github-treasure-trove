<template>
    <div class="content-wrap notoppadding TravelCalculator" ref="top">

        <div class="section toppadding-sm notopmargin" v-if="tab1">
            <div class="container clearfix">
                <div class="portfolio grid-container clearfix">
                    <article v-for="(vehicle, i) in cars" :key="i" class="portfolio-item">
                        <div class="portfolio-image">
                            <img :src="[media_url + vehicle.image]" :alt="vehicle.name">
                        </div>
                        <div class="portfolio-desc center">
                            <h3>{{ vehicle.name }}
                                <!--<i v-if="(vehicle.name).substr((vehicle.name).length - 3) == 'ARD'" class="color icon-question-sign" data-toggle="popover" :title="lang.standard_popover_title" data-trigger="hover" data-html="true" data-placement="right" :data-content="lang.standard_popover"></i>
                                <i v-if="(vehicle.name).substr((vehicle.name).length - 3) == 'IUM'" class="color icon-question-sign" data-toggle="popover" :title="lang.premium_popover_title" data-trigger="hover" data-html="true" data-placement="right" :data-content="lang.premium_popover"></i>-->
                                <button type="button"
                                    @click="SelectModal('standard')"
                                    v-if="(vehicle.name).substr((vehicle.name).length - 3) == 'ARD'"
                                    class="btn btn-circle ml-10">
                                    <i class="color icon-question-sign" style="font-size: 27px;"></i>
                                </button>
                                <button
                                    @click="SelectModal('premium')"
                                    v-if="(vehicle.name).substr((vehicle.name).length - 3) == 'IUM'"
                                    class="btn btn-circle ml-10">
                                    <i class="color icon-question-sign" style="font-size: 27px;"></i>
                                </button>
                            </h3>
                            <span><a href="#">Min.- Max. {{ lang.traveler }} <strong>{{ vehicle.min_people + ' - ' + vehicle.max_people}}</strong></a></span>
                            <hr>
                            <div class="product-price"><ins>{{ (vehicle.price * km * 1).toFixed(2) }} kn</ins> | <ins>{{ ((vehicle.price / Number(euro)) * km).toFixed(2) }} €</ins></div>
                            <hr>
                            <toggle-button id="ag-switch" :value="vehicle.selected" :sync="true" :color="{checked: '#37b6ff', unchecked: '#b2b3c4'}"
                                           :labels="{checked: lang.selected_switch, unchecked: lang.reserve_switch}" :key="i" :height="30" :width="140" :speed="450" @change="SelectedCar(i); ScrollToTarget('steps');"/>
                        </div>
                    </article>
                </div>
            </div>
            <div class="container clearfix text-center" v-if="!km">
                <h4 style="color: #37b6ff; margin-bottom: 10px; margin-top: 20px;">{{ lang.ferry_error_1 }}</h4>
                <h5 style="color: #37b6ff; margin-bottom: 0px;">{{ lang.ferry_error_2 }}</h5>
            </div>
        </div>

        <div class="container clearfix">
            <div name="processTabs">
                <ul class="process-steps bottommargin clearfix topmargin">
                    <li :class="{ active: active.tab1 }">
                        <a class="i-circled i-bordered i-alt divcenter">1</a>
                        <h5>1. {{ lang.step }}</h5>
                    </li>
                    <li :class="{ active: active.tab2 }">
                        <a class="i-circled i-bordered i-alt divcenter">2</a>
                        <h5>2. {{ lang.step }}</h5>
                    </li>
                    <li :class="{ active: active.tab3 }">
                        <a class="i-circled i-bordered i-alt divcenter">3</a>
                        <h5>3. {{ lang.step }}</h5>
                    </li>
                    <li :class="{ active: active.tab4 }">
                        <a class="i-circled i-bordered i-alt divcenter">4</a>
                        <h5>4. {{ lang.step }}</h5>
                    </li>
                </ul>

                <div>
                    <!---->
                    <transition name="fade">
                        <div v-if="tab1" ref="steps">
                            <div class="fancy-title title-dotted-border title-center">
                                <h3>{{ lang.select_option }}</h3>
                            </div>
                            <div class="row pricing bottommargin clearfix">
                                <div class="col-md-5 offset-md-1">
                                    <div class="pricing-box">
                                        <div class="pricing-title">
                                            <h3><i class="icon-long-arrow-alt-right"></i>{{ lang.oneway.title }}</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table cart">
                                                <tbody>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        <a href="#">{{ lang.transfer }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount">{{ numberWithCommas((price.regular).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount">{{ numberWithCommas((price.regular / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        <a href="#">{{ lang.cash_10 }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount">- {{ numberWithCommas((price.cash).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount">- {{ numberWithCommas((price.cash / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name color">
                                                        <a href="#">{{ lang.total }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount color">{{ numberWithCommas((price.total).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount color">{{ numberWithCommas((price.total / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pricing-action">
                                            <button class="button text-center button-rounded btn-block tab-linker" v-if="tab1_vehicle_selected" @click="GoFront(1, 1); ScrollToTarget('top');">{{ lang.oneway.btn }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="pricing-box">
                                        <div class="pricing-title">
                                            <h3><i class="icon-exchange-alt"></i>{{ lang.returnway.title }}</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table cart">
                                                <tbody>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        <a href="#">{{ lang.transfer }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount">{{ numberWithCommas((price.regular_return).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount">{{ numberWithCommas((price.regular_return / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name">
                                                        <a href="#">{{ lang.cash_15 }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount">- {{ numberWithCommas((price.cash_return).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount">- {{ numberWithCommas((price.cash_return / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="cart-product-name color">
                                                        <a href="#">{{ lang.total }}</a>
                                                    </td>
                                                    <td class="cart-product-price">
                                                        <span class="amount color">{{ numberWithCommas((price.total_return).toFixed(2)) }} kn</span>
                                                    </td>
                                                    <td class="cart-product-subtotal">
                                                        <span class="amount color">{{ numberWithCommas((price.total_return / Number(euro)).toFixed(2)) }} €</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pricing-action">
                                            <button class="button text-center button-rounded btn-block tab-linker" v-if="tab1_vehicle_selected" @click="GoFront(1, 2); ScrollToTarget('top');">{{ lang.returnway.btn }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-md-2 font-size-sm" v-html="lang.price_disclamer" v-if="tab1_vehicle_selected"></div>
                            </div>
                        </div>
                    </transition>
                    <!---->
                    <transition name="fade">
                        <div v-if="tab2">
                            <div class="fancy-title title-dotted-border title-center">
                                <h3>{{ lang.fill_detail }}</h3>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <div class="row" v-if="errors2.length">
                                    <div class="col-12">
                                        <div class="style-msg2 errormsg">
                                            <div class="msgtitle">{{ lang.enter_data }}</div>
                                            <div class="sb-msg">
                                                <ul>
                                                    <li v-for="error in errors2" >{{ error }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PRVI SMJER -->
                            <div class="row pricing nobottommargin clearfix" v-if="selected_direction == 1 || selected_direction == 2">
                                <div class="col-md-8 offset-md-2">
                                    <div class="fancy-title title-bottom-border">
                                        <h3><i class="icon-long-arrow-alt-right"></i> {{ lang.oneway.direction }}</h3>
                                    </div>
                                    <div class="col_half nobottommargin">
                                        <h4>{{ lang.oneway.from.detail }}</h4>
                                        <div class="card carddetails">
                                            <label><span class="color">*</span> {{ lang.oneway.from.passangers }}:</label>
                                            <v-select :options="passangers" v-model="transfer.oneway.passangers" class="bottommargin-sm"></v-select>
                                            <label><span class="color">*</span> {{ lang.oneway.from.time }}: </label>
                                            <datetime type="datetime" class="bottommargin-sm theme-optima"
                                                      v-model="transfer.oneway.datetime"
                                                      :minute-step='minute_set'
                                                      :min-datetime="now"></datetime>
                                            <label><span class="color">*</span> {{ lang.oneway.from.address }}:</label>
                                            <input type="text" v-model="transfer.oneway.address_start" class="sm-form-control bottommargin-sm" />
                                            <label v-if="airports.from">{{ lang.oneway.from.flight_number }}:</label>
                                            <input type="text" v-if="airports.from" v-model="transfer.oneway.start_flight" class="sm-form-control bottommargin-sm" />
                                        </div>
                                    </div>
                                    <div class="col_half_last nobottommargin">
                                        <h4>{{ lang.oneway.to.detail }}</h4>
                                        <div class="card carddetails">
                                            <label><span class="color">*</span> {{ lang.oneway.to.address }}:</label>
                                            <input type="text" v-model="transfer.oneway.address_end" class="sm-form-control bottommargin-sm" />
                                            <label v-if="airports.to">{{ lang.oneway.from.flight_number }}:</label>
                                            <input type="text" v-if="airports.to" v-model="transfer.oneway.end_flight" class="sm-form-control bottommargin-sm" />
                                            <label>{{ lang.oneway.to.info }}: </label>
                                            <textarea class="sm-form-control" v-model="transfer.oneway.info" rows="7" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- POVRATNI SMJER -->
                            <div class="row pricing nobottommargin clearfix" v-if="selected_direction == 2">
                                <div class="col-md-8 offset-md-2">
                                    <div class="fancy-title title-bottom-border">
                                        <h3><i class="icon-exchange-alt"></i> {{ lang.returnway.direction }}</h3>
                                    </div>
                                    <div class="col_half nobottommargin">
                                        <h4>{{ lang.oneway.from.detail }}</h4>
                                        <div class="card carddetails">
                                            <label><span class="color">*</span> {{ lang.oneway.from.time }}: </label>
                                            <datetime type="datetime" class="bottommargin-sm theme-optima"
                                                      v-model="transfer.return.datetime"
                                                      :minute-step='minute_set'
                                                      :min-datetime="transfer.oneway.datetime"></datetime>
                                            <label><span class="color">*</span> {{ lang.oneway.from.address }}:</label>
                                            <input type="text" v-model="transfer.return.address_start" class="sm-form-control bottommargin-sm" />
                                            <label v-if="airports.to">{{ lang.oneway.from.flight_number }}:</label>
                                            <input type="text" v-if="airports.to" v-model="transfer.return.start_flight" class="sm-form-control bottommargin-sm" />
                                        </div>
                                    </div>
                                    <div class="col_half_last nobottommargin">
                                        <h4>{{ lang.oneway.to.detail }}</h4>
                                        <div class="card carddetails">
                                            <label><span class="color">*</span> {{ lang.oneway.to.address }}:</label>
                                            <input type="text" v-model="transfer.return.address_end" class="sm-form-control bottommargin-sm" />
                                            <label v-if="airports.from">{{ lang.oneway.from.flight_number }}:</label>
                                            <input type="text" v-if="airports.from" v-model="transfer.return.end_flight" class="sm-form-control bottommargin-sm" />
                                            <label>{{ lang.oneway.to.info }}: </label>
                                            <textarea class=" sm-form-control" v-model="transfer.return.info" rows="7" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center topmargin-sm">
                                <button class="button button-dark button-3d nomargin tab-linker" @click="GoBack(1); ScrollToTarget('top');">{{ lang.btn_back }}</button>
                                <button class="button button-3d nomargin tab-linker" @click="CheckTransferDetail(); ScrollToTarget('top');">{{ lang.btn_forward }}</button>
                            </div>
                        </div>
                    </transition>
                    <!---->
                    <transition name="fade">
                        <div v-if="tab3">
                            <div class="col-md-8 offset-md-2">
                                <div class="fancy-title title-dotted-border title-center">
                                    <h3>{{ lang.personal_title }}</h3>
                                </div>

                                <div class="row" v-if="errors3.length">
                                    <div class="col-12">
                                        <div class="style-msg2 errormsg">
                                            <div class="msgtitle">{{ lang.enter_data }}</div>
                                            <div class="sb-msg">
                                                <ul>
                                                    <li v-for="error in errors3" >{{ error }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card carddetails">
                                    <form name="shipping-form" class="nobottommargin" action="#" method="post">
                                        <div class="col_half">
                                            <label><span class="color">*</span> {{ lang.name }}:</label>
                                            <input type="text" v-model="user.fname" class="sm-form-control">
                                        </div>
                                        <div class="col_half col_last">
                                            <label><span class="color">*</span> {{ lang.lastname }}:</label>
                                            <input type="text" v-model="user.lname" class="sm-form-control">
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col_half">
                                            <label><span class="color">*</span> {{ lang.email }}:</label>
                                            <input type="text" v-model="user.email" class="sm-form-control">
                                        </div>
                                        <div class="col_half col_last">
                                            <label><span class="color">*</span> {{ lang.phone }}:</label>
                                            <input type="text" v-model="user.mobile" class="sm-form-control">
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col_half">
                                            <label><span class="color">*</span> {{ lang.address }}:</label>
                                            <input type="text" v-model="user.address" class="sm-form-control">
                                        </div>
                                        <div class="col_half col_last">
                                            <label><span class="color">*</span> {{ lang.zip }}:</label>
                                            <input type="text" v-model="user.zip" class="sm-form-control">
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col_half">
                                            <label><span class="color">*</span> {{ lang.city }}:</label>
                                            <input type="text" v-model="user.city" class="sm-form-control">
                                        </div>
                                        <div class="col_half col_last">
                                            <label><span class="color">*</span> {{ lang.state }}</label>
                                            <input type="text" v-model="user.state" class="sm-form-control">
                                        </div>
                                        <div class="clear"></div>
                                        <div class="col_full">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" v-model="user.gdpr">
                                                <label class="form-check-label" v-html="lang.gdpr"></label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="center topmargin-sm">
                                <button class="button button-dark button-3d nomargin tab-linker" @click="GoBack(2); ScrollToTarget('top');">{{ lang.btn_back }}</button>
                                <button class="button button-3d nomargin tab-linker" @click="CheckUserDetail(); ScrollToTarget('top');">{{ lang.btn_forward }}</button>
                            </div>
                        </div>
                    </transition>
                    <!---->
                    <transition name="fade">
                        <div v-if="tab4">
                            <div class="col-md-12">
                                <div class="fancy-title title-dotted-border title-center">
                                    <h3>{{ lang.payment_title }}</h3>
                                </div>
                            </div>
                            <div class="col_three_fifth ">
                                <div id="accordion">
                                    <div class="card bottommargin-sm">
                                        <div class="card-header" id="heading1">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                    <input id="radio-5" class="radio-style" name="naplata" type="radio" value="cash" checked="" v-model="payment" checked>
                                                    <label for="radio-5" class="radio-style-1-label">{{ lang.cash }}</label>
                                                </button>
                                                <i class="icon-money-bill-alt fright blue"></i>
                                            </h5>
                                        </div>
                                        <div id="collapse1" class="collapse " aria-labelledby="heading1" data-parent="#accordion">
                                            <div class="card-body" v-html="lang.cash_text"></div>
                                        </div>
                                    </div>
                                    <div class="card bottommargin-sm" v-if="km">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                    <input id="radio-6" class="radio-style" name="naplata" type="radio" value="card" checked="" v-model="payment">
                                                    <label for="radio-6" class="radio-style-1-label">{{ lang.card }}</label>
                                                </button>
                                                <i class="icon-credit-card fright blue"></i>
                                            </h5>
                                        </div>
                                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                                            <div class="card-body" v-html="lang.card_text"></div>
                                        </div>
                                    </div>
                                    <div class="card bottommargin-sm">
                                        <div class="card-header" id="heading3">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                    <input id="radio-7" class="radio-style" name="naplata" type="radio" value="ponuda" v-model="payment">
                                                    <label for="radio-7" class="radio-style-1-label">{{ lang.ponuda }}</label>
                                                </button>
                                                <i class="icon-file-invoice fright blue"></i>
                                            </h5>
                                        </div>
                                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
                                            <div class="card-body" v-html="lang.ponuda_text"></div>
                                        </div>
                                    </div>
                                    <div class="card bottommargin-sm" v-if="km">
                                        <div class="card-header" id="heading4">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                    <input id="radio-8" class="radio-style" name="naplata" type="radio" value="paypal" v-model="payment">
                                                    <label for="radio-8" class="radio-style-1-label">{{ lang.paypal }}</label>
                                                </button>

                                                <i class="icon-cc-paypal fright blue"></i>
                                            </h5>
                                        </div>
                                        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                                            <div class="card-body" v-html="lang.paypal_text"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container clearfix text-right" v-if="!km">
                                    <h5 style="color: #37b6ff; margin-bottom: 0px; margin-top: 30px;">
                                        {{ lang.ferry_error_1 }}<br>
                                        {{ lang.ferry_error_2 }}
                                    </h5>
                                </div>
                            </div>

                            <div class="col_two_fifth col_last">
                                <div class="row">
                                    <div class="col-8 offset-2">
                                        <img :src="[media_url + selected_car.image]" alt="Car">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p>
                                            <strong>{{ selected_car.name }} - {{ selected_direction == 1 ? lang.direction_title_1 : lang.direction_title_2 }}</strong><br>
                                            {{ lang.from }}: <strong>{{ from }}</strong><br>
                                            {{ lang.to }}: <strong>{{ to }}</strong><br>
                                            {{ lang.passangers }}: <strong>{{ transfer.oneway.passangers }}</strong><br>
                                        </p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <a href="#">{{ lang.transfer }}</a>
                                            </td>
                                            <td class="cart-product-price">
                                                <span class="amount">{{ numberWithCommas((selected_price.regular).toFixed(2)) }} kn</span>
                                            </td>
                                            <td class="cart-product-subtotal">
                                                <span class="amount">{{ numberWithCommas((selected_price.regular / Number(euro)).toFixed(2)) }} €</span>
                                            </td>
                                        </tr>

                                        <tr class="cart_item" v-if="selected_price.discount">
                                            <td class="cart-product-name">
                                                <a href="#">{{ lang.discount }} {{ selected_price.dis }}</a>
                                            </td>
                                            <td class="cart-product-price">
                                                <span class="amount">- {{ numberWithCommas((selected_price.discount).toFixed(2)) }} kn</span>
                                            </td>
                                            <td class="cart-product-subtotal">
                                                <span class="amount">- {{ numberWithCommas((selected_price.discount / Number(euro)).toFixed(2)) }} €</span>
                                            </td>
                                        </tr>

                                        <tr class="cart_item">
                                            <td class="cart-product-name color">
                                                <a href="#">{{ lang.total }}</a>
                                            </td>
                                            <td class="cart-product-price">
                                                <span class="amount color">{{ numberWithCommas((selected_price.total).toFixed(2)) }} kn</span>
                                            </td>
                                            <td class="cart-product-subtotal">
                                                <span class="amount color">{{ numberWithCommas((selected_price.total / Number(euro)).toFixed(2)) }} €</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col_full center topmargin-sm">
                                <button class="button button-dark button-3d nomargin tab-linker" @click="GoBack(3); ScrollToTarget('top');">{{ lang.btn_back }}</button>
                                <button class="button button-3d nomargin tab-linker" @click="ReserveTransfer(); ScrollToTarget('top');">{{ lang.reserve }}</button>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <!-- Standard modal -->
        <div class="modal fade standard-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">{{ lang.standard_popover_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div v-html="lang.standard_popover"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium modal -->
        <div class="modal fade premium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">{{ lang.premium_popover_title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div v-html="lang.premium_popover"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
  import { ToggleButton } from 'vue-js-toggle-button'

  import { Settings } from 'luxon'
  Settings.defaultLocale = window.locale

  export default {
    components: {
      ToggleButton
    },
    //
    props: {
      distance: String,
      vehicles: String,
      uri: String,
      redirect: String,
      date: String,
      from: String,
      from_latlng: String,
      to: String,
      to_latlng: String,
      ferry: String,
      airport: String,
      euro: String,
      locale: String,
    },
    //
    data() {
      return {
        cars: {},
        selected_car: '',
        selected_direction: 1,
        km: 0,
        passangers: [],
        payment: '',
        selected_payment: '',
        lang: window.trans.calculator,
        media_url: '',
        now: new Date().toISOString(),
        minute_set: 15,
        airports: [],
        price: {
          regular: 0,
          regular_return: 0,
          cash: 0,
          cash_return: 0,
          total: 0,
          total_return: 0
        },
        selected_price: {
          regular: 0,
          regular_return: 0,
          discount: 0,
          discount_return: 0,
          total: 0,
          total_return: 0,
          dis: 0
        },
        transfer: {
          oneway: {
            passangers: 0,
            datetime: '',
            address_start: '',
            start_flight: '',
            address_end: '',
            end_flight: '',
            info: ''
          },
          return: {
            datetime: '',
            address_start: '',
            start_flight: '',
            address_end: '',
            end_flight: '',
            info: ''
          }
        },
        user: {
          fname: '',
          lname: '',
          email: '',
          mobile: '',
          address: '',
          zip: '',
          city: '',
          state: '',
          gdpr: false,
        },
        tab1: true,
        tab1_vehicle_selected: false,
        tab2: false,
        tab2_pass: false,
        tab3: false,
        tab4: false,
        errors2: [],
        errors3: [],
        active: {
          tab1: true,
          tab2: false,
          tab3: false,
          tab4: false,
        },
        modal: {
          standard: false,
          premium: false,
        }
      }
    },
    //
    watch: {
      payment: {
        deep: true,
        handler(val) {
          console.log(val)
          this.SelectPaymentType(val)
        }
      }
    },
    //
    mounted() {
      this.media_url = window.location.origin + '/media/'

      if (this.ferry == '') {
        this.km = Number(this.distance.slice(0, -3))
      }

      this.cars = this.ReturnVehiclePrice(JSON.parse(this.vehicles), this.km)

      if (this.date != '') {
        this.transfer.oneway.datetime = this.date
      }

      if (this.from != '') {
        this.transfer.oneway.address_start = this.from
        this.transfer.return.address_end = this.from
      }

      if (this.to != '') {
        this.transfer.oneway.address_end = this.to
        this.transfer.return.address_start = this.to
      }

      this.SetAirports()

      if (this.$storage.has('transfer')) {
        this.ResolveCache()
      }
    },
    methods: {
      SelectModal(type) {
        if (type == 'standard') {
          $('.standard-modal').modal('show')
        }

        if (type == 'premium') {
          $('.premium-modal').modal('show')
        }
      },
      /**
       *  Return appropriate vehicle price per km.
       *
       * @param vehicles
       * @param km
       * @returns {*}
       */
      ReturnVehiclePrice(vehicles, km) {
        for (let i = 0; i < vehicles.length; i++) {
          if (this.km <= 100) {
            vehicles[i].price = vehicles[i].price_1
          }
          else if (this.km > 100 && this.km <= 999) {
            vehicles[i].price = vehicles[i].price_2
          }
          else if (this.km > 999) {
            vehicles[i].price = vehicles[i].price_3
          }

          vehicles[i].selected = false
        }

        return vehicles
      },

      /**
       * Sort cars switches, make them like radio buttons.
       * Sort passangers for select component.
       * Calculate price for 1 and 2 ways.
       *
       * @param index
       * @constructor
       */
      SelectedCar(index) {
        // Sort cars switches, make them like radio buttons.
        for (let i = 0; i < this.cars.length; i++) {
          if (i === index) {
            this.selected_car = this.cars[i]
            this.cars[i].selected = !this.cars[i].selected
          } else {
            this.cars[i].selected = false
          }
        }

        // Sort passangers for select component.
        for (let i = 0; i < this.cars.length; i++) {
          if (i === index) {
            this.passangers = []
            let min = Number(this.cars[i].min_people)
            let max = Number(this.cars[i].max_people) + 1

            for (let k = min; k < max; k++) {
              this.passangers.push(k)
            }
          }
        }

        // Calculate price for 1 and 2 ways.
        if (this.cars[index].selected) {
          this.tab1_vehicle_selected = true

          this.price.regular = this.cars[index].price * this.km
          this.price.regular_return = this.price.regular * 2
          this.price.cash = this.price.regular * 0.10
          this.price.cash_return = this.price.regular * 2 * 0.15
          this.price.total = this.price.regular - this.price.cash
          this.price.total_return = this.price.regular_return - this.price.cash_return

        } else {
          this.tab1_vehicle_selected = false

          this.price.regular = 0
          this.price.regular_return = 0
          this.price.cash = 0
          this.price.cash_return = 0
          this.price.total = 0
          this.price.total_return = 0
        }

        this.SetCache()
      },

      /**
       * Select first option.
       *
       * @param direction
       * @constructor
       */
      GoFront(tab, direction = null) {
        if (direction) {
          this.selected_direction = direction
        }

        let first = tab
        let second = tab + 1

        this['tab' + first] = false
        this['tab' + second] = true
        this.active['tab' + first] = false
        this.active['tab' + second] = true

        this.SetCache()
      },

      /**
       * Select first option.
       *
       * @param direction
       * @constructor
       */
      GoBack(tab) {
        let first = tab
        let second = tab + 1

        this['tab' + first] = true
        this['tab' + second] = false
        this.active['tab' + first] = true
        this.active['tab' + second] = false

        this.SetCache()
      },

      /**
       * Check user inserted transfer details.
       *
       * @constructor
       */
      CheckTransferDetail() {
        if (this.selected_direction == 1) {
          if (
            this.transfer.oneway.passangers == 0 ||
            this.transfer.oneway.datetime == '' ||
            this.transfer.oneway.address_start == '' ||
            this.transfer.oneway.address_end == ''
          ) {
            this.tab2_pass == false
            this.ShowTab2Errors()
          } else {
            this.tab2_pass == true
            this.GoFront(2)
          }

        } else if (this.selected_direction == 2) {
          if (
            this.transfer.oneway.passangers == 0 ||
            this.transfer.oneway.datetime == '' ||
            this.transfer.oneway.address_start == '' ||
            this.transfer.oneway.address_end == '' ||
            this.transfer.return.datetime == '' ||
            this.transfer.return.address_start == '' ||
            this.transfer.return.address_end == ''
          ) {
            this.tab2_pass == false
            this.ShowTab2Errors()
          } else {
            this.tab2_pass == true
            this.errors2 = []
            this.GoFront(2)
          }
        }

      },

      /**
       * Show transfer errors.
       *
       * @constructor
       */
      ShowTab2Errors() {
        this.errors2 = []
        // oneway
        if (this.transfer.oneway.passangers == 0) {
          this.errors2.push(this.lang.number_of_persons)
        }
        if (this.transfer.oneway.datetime == '') {
          this.errors2.push(this.lang.departure_time)
        }
        if (this.transfer.oneway.address_start == '') {
          this.errors2.push(this.lang.departure_address)
        }
        if (this.transfer.oneway.address_end == '') {
          this.errors2.push(this.lang.destination_address)
        }
        // return
        if (this.selected_direction == 2) {
          if (this.transfer.return.datetime == '') {
            this.errors2.push(this.lang.return_time)
          }
          if (this.transfer.return.address_start == '') {
            this.errors2.push(this.lang.return_departure_address)
          }
          if (this.transfer.return.address_end == '') {
            this.errors2.push(this.lang.address_of_the_destination)
          }
        }

        this.SetCache()
      },

      /**
       * Check user inserted details.
       *
       * @constructor
       */
      CheckUserDetail() {
        console.log('this.user.gdpr')
        console.log(this.user.gdpr)
        if (
          this.user.fname == '' ||
          this.user.lname == '' ||
          ! this.ValidateEmail(this.user.email) ||
          this.user.mobile == '' ||
          this.user.address == '' ||
          this.user.zip == '' ||
          this.user.city == '' ||
          this.user.state == '' ||
          this.user.gdpr == false
        ) {
          this.tab2_pass == false
          this.ShowTab3Errors()
        } else {
          this.tab2_pass == true
          this.errors3 = []
          this.GoFront(3)
        }
      },

      /**
       * Show user errors.
       *
       * @constructor
       */
      ShowTab3Errors() {
        this.errors3 = []

        if (this.user.fname == '') {
          this.errors3.push(this.lang.enter_your_name)
        }
        if (this.user.lname == '') {
          this.errors3.push(this.lang.enter_your_last_name)
        }
        if (! this.ValidateEmail(this.user.email)) {
          this.errors3.push(this.lang.enter_your_email)
        }
        if (this.user.mobile == '') {
          this.errors3.push(this.lang.enter_your_phone)
        }
        if (this.user.address == '') {
          this.errors3.push(this.lang.enter_your_address)
        }
        if (this.user.zip == '') {
          this.errors3.push(this.lang.enter_your_zip)
        }
        if (this.user.city == '') {
          this.errors3.push(this.lang.enter_your_city)
        }
        if (this.user.state == '') {
          this.errors3.push(this.lang.enter_your_state)
        }
        if (this.user.gdpr == false) {
          this.errors3.push(this.lang.accept_the_terms)
        }

        this.SetCache()
      },

      /**
       * Validate Email.
       *
       * @constructor
       */
      ValidateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let test = re.test(String(email).toLowerCase());
        return test
      },

      /**
       * Select payment type.
       *
       * @constructor
       */
      SelectPaymentType(payment) {
        this.ResetSelectedPrice()

        this.selected_price.regular = this.selected_car.price * this.km * this.selected_direction

        if (payment == 'cash') {
          this.selected_price.dis = '- 10%'
          this.selected_price.discount = this.selected_price.regular * 0.1
        }

        // return price
        if (this.selected_direction == 2) {
          if (payment == 'cash') {
            this.selected_price.dis = '- 15%'
            this.selected_price.discount = this.selected_price.regular * 0.15
          }
          if (payment == 'card' || payment == 'paypal' || payment == 'ponuda') {
            this.selected_price.dis = '- 5%'
            this.selected_price.discount = this.selected_price.regular * 0.05
          }
        }

        this.selected_price.total = this.selected_price.regular - this.selected_price.discount

        this.SetCache()
      },

      /**
       * Reset Selected Price.
       *
       * @constructor
       */
      ResetSelectedPrice() {
        this.selected_price = {
          regular: 0,
          regular_return: 0,
          discount: 0,
          discount_return: 0,
          total: 0,
          total_return: 0,
          dis: 0
        }
      },

      /**
       * Reserve transfer with all data.
       *
       * @constructor
       */
      ReserveTransfer() {
        let context = this
        let request = {
          selected_vehicle: this.selected_car,
          transfer_details: this.transfer,
          user_details: this.user,
          payment: this.payment,
          selected_price: this.selected_price,
          transfer: this.selected_direction == 1 ? 'oneway' : 'return',
          km: this.km,
          from_latlng: this.from_latlng,
          to_latlng: this.to_latlng,
        }
        axios.post(context.uri, {data: request})
          .then(r => {
            console.log(r.data)
            if (r.data.success) {
              location = this.redirect + '/' + r.data.response
            }
          })
          .catch(e => {
            console.log(e)

          });
      },

      /**
       * Cache the application object.
       *
       * @constructor
       */
      SetCache() {
        if (this.$storage.has('transfer')) {
          this.$storage.remove('transfer')
        }
        this.$storage.set('transfer', this.SetCacheString())
      },

      /**
       * Cache the application object.
       *
       * @constructor
       */
      SetCacheString() {
        return {
          price: this.price,
          selected_price: this.selected_price,
          transfer: this.transfer,
          user: this.user,
          selected_car: this.selected_car,
          selected_direction: this.selected_direction,
          km: this.km,
          payment: this.payment,
          from_latlng: this.from_latlng,
          to_latlng: this.to_latlng,
          tab1: this.tab1,
          tab1_vehicle_selected: this.tab1_vehicle_selected,
          tab2: this.tab2,
          tab2_pass: this.tab2_pass,
          tab3: this.tab3,
          tab4: this.tab4,
          errors2: this.errors2,
          errors3: this.errors3,
          active: this.active,
          cars: this.cars,
          passangers: this.passangers,
          selected_payment: this.selected_payment,
          lang: this.lang,
          media_url: this.media_url,
          now: this.now,
          minute_set:this.minute_set,
          airports: this.airports,
          ferry: this.ferry,
          airport: this.airport,
          euro: this.euro,
          locale: this.locale,
        }
      },

      /**
       * Set the Aplication variables
       * from Cache storage.
       *
       * @constructor
       */
      ResolveCache() {
        let cache = this.$storage.get('transfer')

        console.log(cache)

        this.selected_car = cache.selected_car
        this.transfer = cache.transfer
        this.user = cache.user
        this.payment = cache.payment
        this.selected_price = cache.selected_price
        this.selected_direction = cache.selected_direction
        this.km = cache.km
        this.from_latlng = cache.from_latlng
        this.to_latlng = cache.to_latlng
        this.price = cache.price
        this.tab1 = cache.tab1
        this.tab1_vehicle_selected = cache.tab1_vehicle_selected
        this.tab2 = cache.tab2
        this.tab2_pass = cache.tab2_pass
        this.tab3 = cache.tab3
        this.tab4 = cache.tab4
        this.errors2 = cache.errors2
        this.errors3 = cache.errors3
        this.active = cache.active
        this.price = cache.price
        this.cars = cache.cars
        this.passangers = cache.passangers
        this.selected_payment = cache.selected_payment
        this.lang = cache.lang
        this.media_url = cache.media_url
        this.now = cache.now
        this.minute_set = cache.minute_set
        this.airports = cache.airports
        this.ferry = cache.ferry
        this.airport = cache.airport
        this.euro = cache.euro
        this.locale = cache.locale
      },

      /**
       * Scroll to Ref target.
       *
       * @constructor
       */
      ScrollToTarget(refName) {
        let element = this.$refs[refName];
        let top = element.offsetTop;

        if (refName == 'steps') {
          top = top + 760
          let scrollOptions = {
            left: 0,
            top: top,
            behavior: 'smooth'
          }
          window.scrollTo(scrollOptions);
        }

        window.scrollTo(0, top - 1);
      },

      /**
       * Set the airports array.
       *
       * @constructor
       */
      SetAirports() {
        let airs = (this.airport).split(':')
        this.airports.from = Number(airs[0])
        this.airports.to = Number(airs[1])
      },

      /**
       * Return formated number with thousand separator.
       *
       * @param x
       * @returns {*}
       */
      numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },

    }
  };
</script>

<style lang="scss">
    .vue-js-switch#ag-switch {
        font-size: 14px !important;

        span {
            line-height: 30px !important;
        }
    }

    .theme-optima .vdatetime-popup__header,
    .theme-optima .vdatetime-calendar__month__day--selected > span > span,
    .theme-optima .vdatetime-calendar__month__day--selected:hover > span > span {
        background: #37b6ff !important;
    }

    .theme-optima .vdatetime-year-picker__item--selected,
    .theme-optima .vdatetime-time-picker__item--selected,
    .theme-optima .vdatetime-popup__actions__button {
        color: #37b6ff !important;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .6s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }


    .popover {
        max-width: 500px;
        width: 500px;
    }

    .popover-body {
        padding: 24px;
    }


    /* */
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 300px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

