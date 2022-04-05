@foreach($list as $supply)
<tr>
	<td class="hidden"><input name="supply_{{$supply['id']}}" value="{{$supply['id']}}"></td>
	<td>
		<div class=" input-group" style="padding-left:5px;width:100%">
			<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" style="width:75%" name="SUPPLD_DATE_{{$supply['id']}}" value="{{$supply['SUPPLD_DATE']}}">
			<span class="input-group-addon" style="float: right;width:25%;">
				<i class="icon-calendar bigger-110"></i>
			</span>
		</div>
	</td>
	<td><input type="text" class="form-control" name="PLACE_{{$supply['id']}}" value="{{$supply['PLACE']}}"></td>
	<td>
		<select class="form-control" name="AC_ITEM_{{$supply['id']}}">
			<option value="DO" @if($supply['AC_ITEM'] == 'DO') selected @endif>DO</option>
			<option value="FO" @if($supply['AC_ITEM'] == 'FO') selected @endif>FO</option>
			<option value="LO" @if($supply['AC_ITEM'] == 'LO') selected @endif>LO</option>
			<option value="FW" @if($supply['AC_ITEM'] == 'FW') selected @endif>FW</option>
			<option value="S&S" @if($supply['AC_ITEM'] == 'S&S') selected @endif>S&S</option>
		</select>
	</td>
	<td><input type="text" class="form-control" name="DESCRIPTION_{{$supply['id']}}" value="{{$supply['DESCRIPTION']}}"></td>
	<td><input type="text" class="form-control" name="PART_NO_{{$supply['id']}}" value="{{$supply['PART_NO']}}"></td>
	<td><input type="number" class="form-control" name="QTY_{{$supply['id']}}" value="{{$supply['QTY']}}"></td>
	<td>
		<select class="form-control" name="UNIT_{{$supply['id']}}">
			<option value="MT" @if($supply['UNIT'] == 'MT') selected @endif>MT</option>
			<option value="KG" @if($supply['UNIT'] == 'KG') selected @endif>KG</option>
			<option value="L" @if($supply['UNIT'] == 'L') selected @endif>L</option>
		</select>
	</td>
	<td><input type="number" class="form-control" name="PRCE_{{$supply['id']}}" value="{{$supply['PRCE']}}"></td>
	<td><input type="number" class="form-control" name="AMOUNT_{{$supply['id']}}" value="{{$supply['AMOUNT']}}"></td>
	<td><input type="text" class="form-control" name="REMARK_{{$supply['id']}}" value="{{$supply['REMARK']}}"></td>
	<td class="action-buttons">
		<a href="javascript:void(0);" class="red" onclick="deleteOilSupply($(this))"><i class="icon-trash bigger-130"></i></a>
	</td>
</tr>
@endforeach
<tr>
	<td class="hidden"><input name="new_1" value="1"></td>
	<td>
		<div class=" input-group" style="padding-left:5px;width:100%">
			<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" style="width:75%" name='SUPPLD_DATE_new_1'>
			<span class="input-group-addon" style="float: right;width:25%;">
				<i class="icon-calendar bigger-110"></i>
			</span>
		</div>
	</td>
	<td><input type="text" class="form-control" name="PLACE_new_1"></td>
	<td>
		<select class="form-control" name="AC_ITEM_new_1">
			<option value="DO">DO</option>
			<option value="FO">FO</option>
			<option value="LO">LO</option>
			<option value="FW">FW</option>
			<option value="S&S">S&S</option>
		</select>
	</td>
	<td><input type="text" class="form-control" name="DESCRIPTION_new_1"></td>
	<td><input type="text" class="form-control" name="PART_NO_new_1"></td>
	<td><input type="number" class="form-control" name="QTY_new_1"></td>
	<td>
		<select class="form-control" name="UNIT_new_1">
			<option value="MT">MT</option>
			<option value="Kg">Kg</option>
			<option value="L">L</option>
		</select>
	</td>
	<td><input type="number" class="form-control" name="PRCE_new_1"></td>
	<td><input type="number" class="form-control" name="AMOUNT_new_1"></td>
	<td><input type="text" class="form-control" name="REMARK_new_1"></td>
	<td class="action-buttons">
		<a href="javascript:void(0)" class="red" onclick="createShipOilSupply($(this))"><i class="icon-plus bigger-130"></i></a>
	</td>
</tr>
