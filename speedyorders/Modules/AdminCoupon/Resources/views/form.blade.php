
            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Code</label>
                <div class="col-md-4">
                    <input type="text" name="code" value="{{ old('code', isset($coupon) ? $coupon->code : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Type</label>
                <div class="col-md-4">
                    <select class="form-control m-b js-dropdown-select2" name="type">
                        <option value="percentage" @if (old('type', isset($coupon) ? $coupon->type : null) == 'Percentage') selected @endif>Percentage</option>
                        <option value="flat" @if (old('type', isset($coupon) ? $coupon->type : null) == 'Flat') selected @endif>Flat</option>
                    </select>
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Value</label>
                <div class="col-md-4">
                    <input type="text" name="amount" value="{{ old('amount', isset($coupon) ? $coupon->amount : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Max Limit</label>
                <div class="col-md-4">
                    <input type="text" name="max_limit" value="{{ old('max_limit', isset($coupon) ? $coupon->max_limit : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Limit(per user)</label>
                <div class="col-md-4">
                    <input type="text" name="limit_per_user" value="{{ old('limit_per_user', isset($coupon) ? $coupon->limit_per_user : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Min Order Amount</label>
                <div class="col-md-4">
                    <input type="text" name="min_order_amount" value="{{ old('min_order_amount', isset($coupon) ? $coupon->min_order_amount : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Start Date</label>
                <div class="col-md-4">
                    <input type="date" name="start_date" value="{{ old('start_date', isset($coupon) ? $coupon->start_date : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Expiry Date</label>
                <div class="col-md-4">
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', isset($coupon) ? $coupon->expiry_date : null) }}"
                        class="form-control">
                </div>
            </div>

            <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-md-2 control-label">Publish Status</label>
                <div class="col-md-4">
                    <select class="form-control m-b js-dropdown-select2" name="status">
                        <option value="1" @if (old('status', isset($coupon) ? $coupon->status : null) == 1) selected @endif>Yes</option>
                        <option value="0" @if (old('status', isset($coupon) ? $coupon->status : null) == 0) selected @endif>No</option>
                    </select>
                </div>
            </div>

