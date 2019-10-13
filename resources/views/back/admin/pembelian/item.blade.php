<tr id="item-row-{{ $item_row }}">
    @stack('actions_td_start')
    <td class="text-center" style="vertical-align: middle;">
        @stack('actions_button_start')
        <button type="button" onclick="$(this).tooltip('destroy'); $('#item-row-{{ $item_row }}').remove(); totalItem();" data-toggle="tooltip" title="{{ trans('general.delete') }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
        @stack('actions_button_end')
    </td>
    @stack('actions_td_end')
    @stack('name_td_start')
    <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : '' !!}>
        @stack('name_input_start')
        <input value="{{ empty($item) ? '' : $item->name }}" class="form-control typeahead" required="required" placeholder="Masukkan Nama Item" name="item[{{ $item_row }}][name]" type="text" id="item-name-{{ $item_row }}" autocomplete="off">
        <input value="{{ empty($item) ? '' : $item->item_id }}" name="item[{{ $item_row }}][item_id]" type="hidden" id="item-id-{{ $item_row }}">
        {!! $errors->first('item.' . $item_row . '.name', '<p class="help-block">:message</p>') !!}
        @stack('name_input_end')
    </td>
    @stack('name_td_end')
    @stack('jenis_td_start')
    <td class="text-right" style="vertical-align: middle;">
        @stack('jenis_input_start')
        <span id="item-jenis-{{ $item_row }}">0</span>
        <input value="" name="item[{{ $item_row }}][item_jenis]" type="hidden" id="item-id-jenis-{{ $item_row }}">
        @stack('jenis_input_end')
    </td>
    @stack('jenis_td_end')
    @stack('ukuran_td_start')
    <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : '' !!}>
        @stack('ukuran_input_start')
        <select name="item[{{ $item_row }}][item_ukuran]" id="item_ukuran_{{ $item_row }}" class="form-control select2" onchange="$('#test').click()">
            {!! $errors->first('item.' . $item_row . '.name', '<p class="help-block">:message</p>') !!}
            @stack('ukuran_input_end')
    </td>
    @stack('ukuran_td_end')
    @stack('satuan_td_start')
    <td {!! $errors->has('item.' . $item_row . '.name') ? 'class="has-error"' : '' !!}>
        @stack('satuan_input_start')
        <select name="item[{{ $item_row }}][item_satuan]" id="item_satuan_{{ $item_row }}" class="form-control select2">
        </select>
        {!! $errors->first('item.' . $item_row . '.name', '<p class="help-block">:message</p>') !!}
        @stack('satuan_input_end')
    </td>
    @stack('stauan_td_end')
    @stack('quantity_td_start')
    <td {{ $errors->has('item.' . $item_row . '.quantity') ? 'class="has-error"' : '' }}>
        @stack('quantity_input_start')
        <input value="{{ empty($item) ? 1 : $item->quantity }}" class="form-control text-center" required="required" name="item[{{ $item_row }}][quantity]" type="text" id="item-quantity-{{ $item_row }}">
        {!! $errors->first('item.' . $item_row . '.quantity', '<p class="help-block">:message</p>') !!}
        @stack('quantity_input_end')
    </td>
    @stack('quantity_td_end')
</tr>