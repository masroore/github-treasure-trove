<div class="hpanel"> 
    <div class="panel-body">
        <table
            class="option-values-table footable table table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
            data-page-size="8" data-filter="#filter">
            <thead>
                <tr>
                    <th class="footable-visible">Attribute Name</span></th>
                    <th class="footable-visible">Value</span></th>
                    <th class="footable-visible footable-sortable">Quantity</span></th>
                    <th class="footable-visible footable-sortable">Subtract stock</span></th>
                    <th class="footable-visible footable-sortable">prefix</span></th>
                    <th class="footable-visible footable-sortable">Price</span></th>
                    <th class="footable-sortable">Operation</span></th>
                </tr>
            </thead>
            <tbody>

                @foreach($options as $option)

                    <tr style="display: table-row;" class="footable-even">

                        <input type="hidden" name="option[select][option_data][{{ $counter }}][]" value="{{$option->id}}">
                        
                        <td class="footable-visible">
                            <h5><strong>{{$option->name}}</strong> </h5>
                        </td>
                        <td class="footable-visible">
                            <select name="option[select][option_values][{{$counter}}][]" class="form-control">
                                @foreach ($option->optionValues ?? [] as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="footable-visible">
                            <input type="number" class="form-control" name="option[select][quantity][{{$counter}}][]" placeholder="Total Option Stock"
                                required>
                        </td>
                        <td class="footable-visible">
                            <select name="option[select][subtract_from_stock][{{$counter}}][]" class="form-control" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                        <?php /*
                        <td class="footable-visible">

                            <select name="option[select][price_prefix][{{$counter}}][]" class="form-control" required>
                                <option value="+">+</option>
                                <option value="-">-</option>
                            </select>

                        </td>
                        */?>
                        <td class="footable-visible">
                            <input type="number" class="form-control" name="option[select][price][{{$counter}}][]" placeholder="Price"
                                required>
                        </td>
                        <td class="footable-visible footable-last-column"><a
                                class="btn btn-danger remove-option-value"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="display: table-row;" class="footable-even">
                    <td class="footable-visible" colspan="5"></td>
                    <td class="footable-visible footable-last-column"><a
                            class="btn btn-primary add-option-value" data-option-id="{{ $option->id }}"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
