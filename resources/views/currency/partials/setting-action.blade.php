<span class="dropdown">
    <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="ft-more-vertical"></i>
    </button>
    <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right" x-placement="bottom-end"
        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(55px, 27px, 0px);">
        <a class="dropdown-item edit" href="{{ route('currency.edit', $currency ?? ('')->id) }}">
            <i class="ft-edit-2"></i>{{ translate('Edit') }}</a>
        {{-- <a href="#" data-form_id="document.getElementById('{{ 'delete_form_'.$attribute_value->id }}').submit();" class="dropdown-item delete" >Delete
			</a> --}}
        <a href="#" data-form_id="{{ 'delete_form_' . $currency->id }}" class="delete dropdown-item"><i
                class="ft-trash-2"></i>{{ translate('Delete') }}</a>
        <form action="{{ route('currency.destroy', [$currency->id]) }}" method="post"
            id="{{ 'delete_form_' . $currency->id }}">
            @csrf
            @method('DELETE')
        </form>
    </span>
</span>