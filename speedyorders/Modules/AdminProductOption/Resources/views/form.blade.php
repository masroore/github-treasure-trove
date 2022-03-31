<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ 'Option Name' }}</label>
    <input class="form-control" type="text" name="name" id="name"
        value="{{ isset($option->name) ? $option->name : '' }}"> </input>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="type" class="control-label">{{ 'Type' }}</label>

    <select class="form-control js-dropdown-select2" id="option_selection" required name="type">
        <option value="">Select Option Type</option>
        <option value="select" {{ isset($option) && $option->type == 'select' ? 'selected' : '' }}>Select
        </option>
        <option value="input" {{ isset($option) && $option->type == 'input' ? 'selected' : '' }}>Textbox
        </option>
        <option value="checkbox" {{ isset($option) && $option->type == 'checkbox' ? 'selected' : '' }}>
            Checkbox</option>
        <option value="radio" {{ isset($option) && $option->type == 'radio' ? 'selected' : '' }}>Radio
        </option>
        <option value="date" {{ isset($option) && $option->type == 'date' ? 'selected' : '' }}>Date</option>
        <option value="date_time" {{ isset($option) && $option->type == 'date_time' ? 'selected' : '' }}>
            Date Time</option>
    </select>
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="control-label">{{ 'Sort Order' }}</label>
    <input class="form-control" type="number" name="sort_order" id="sort_order"
        value="{{ isset($option->sort_order) ? $option->sort_order : '' }}">

    {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group" id="option_values_div" style="display:{{ (isset($option) && ($option->type == 'input' || $option->type == 'date' || $option->type == 'date_time')) ? 'none' : 'block'}}" >
    <h4>Option Values</h4>
    <table id="option-values-table"
        class="footable table table-stripped table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
        data-page-size="8" data-filter="#filter">
        <thead>
            <tr>
                <th class="footable-visible">Name</span></th>
                <th class="footable-visible footable-sortable">Image</span></th>
                <th class="footable-visible footable-sortable">Sort order</span></th>
                <th class="footable-sortable">Operation</span></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($option->optionValues ??[] as $key=>$item)
            <tr id style='display: table-row;' class='footable-even'>
                <td class='footable-visible footable-first-column'>
                    <input type='input' class='form-control' name='option_value[name][{{$key}}]' placeholder='name' id='option_value[name]["{{$key}}"]' value="{{$item->name}}" required/>
                </td>
                <td class='footable-visible'>
                    <input class='form-control' type='file' name='option_value[file]["{{$key}}"]' placeholder='sort order' id='option_value[file]["{{$key}}"]' value="{{$item->file}}">
                </td>
                <td class='footable-visible'><input class='form-control' type='number' class='' name='option_value[sort_order][{{$key}}]' placeholder='name' id='option_value[sort_order][{{$key}}]' value="{{$item->sort_order}}" required>
                </td>
                <td class='footable-visible footable-last-column'><button type='button' class='btn btn-danger delete-option-value'><i class='fa fa-trash'></i></button>
                </td>
            </tr>
            @empty

            @endforelse
        </tbody>
        <tfoot>
            <tr style="display: table-row;" class="footable-even">
                <td class="footable-visible footable-first-column"></td>
                <td class="footable-visible"></td>
                <td class="footable-visible"></td>
                <td class="footable-visible footable-last-column"><button type="button" id="add-option-value" class="btn btn-primary"><i class="fa fa-plus"></i></button></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
