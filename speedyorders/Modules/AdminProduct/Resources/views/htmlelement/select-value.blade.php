                <tr style="display: table-row;" class="footable-even">

                    <td class="footable-visible">
                      
                        <input type="hidden" name="option[select][option_data][{{ $counter }}][]" value="{{$option->id}}">

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

                    <td class="footable-visible">

                        <select name="option[select][price_prefix][{{$counter}}][]" class="form-control" required>
                            <option value="+">+</option>
                            <option value="-">-</option>
                        </select>

                    </td>
                    <td class="footable-visible">
                        <input type="number" class="form-control" name="option[select][price][{{$counter}}][]" placeholder="Price"
                            required>
                    </td>
                    <td class="footable-visible footable-last-column"><a
                            class="btn btn-danger remove-option-value"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
