<tr id="item-row-{{ $item_row }}">
        @stack('actions_td_start')
        <td class="text-center" style="vertical-align: middle;">
            @stack('actions_button_start')
            <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-{{ $item_row }}').remove(); totalItem();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
            @stack('actions_button_end')
        </td>
        @stack('actions_td_end')
        @stack('qty_td_start')
        <td {!! $errors->has('item.' . $item_row . '.qty') ? 'class="has-error"' : '' !!}>
            @stack('qty_input_start')
            <input value="{{ empty($item) ? '' : $item->qty }}" class="form-control typeahead" required="required" placeholder="Masukkan Quantity" name="item[{{ $item_row }}][qty]" type="text" id="item-qty-{{ $item_row }}" autocomplete="off">
            <input value="{{ empty($item) ? '' : $item->item_id }}" name="item[{{ $item_row }}][item_id]" type="hidden" id="item-id-{{ $item_row }}">
            {!! $errors->first('item.' . $item_row . '.qty', '<p class="help-block">:message</p>') !!}
            @stack('qty_input_end')
        </td>
        @stack('qty_td_end')

        @stack('harga_td_start')
        <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : '' !!}>
            @stack('harga_input_start')
            <input value="{{ empty($item) ? 0 : $item->harga }}" class="form-control text-center" required="required" name="item[{{ $item_row }}][harga]" type="text" id="item-harga-{{ $item_row }}">
            {!! $errors->first('item.' . $item_row . '.harga', '<p class="help-block">:message</p>') !!}
                @stack('harga_input_end')
        </td>
        @stack('harga_td_end')
    </tr>
