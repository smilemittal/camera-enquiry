<span class="dropdown">
    <button id="btnSearchDrop12" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2"
            data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <i class="ft-more-vertical"></i>
    </button>
    <span aria-labelledby="btnSearchDrop12" class="dropdown-menu mt-1 dropdown-menu-right"
        x-placement="bottom-end"
        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(55px, 27px, 0px);">
            <a class="dropdown-item" href="{{ route('enquiries.show', $enquiry ?? ''->id)}}"><i
              class="ft-eye"></i>{{translate('Details')}}</a>
                        <form action="{{ $destroy }}" method="post" id="{{ 'delete_form_'.$enquiry->id}}">  
                            @csrf  
                            @method('DELETE')  
                        </form> 
            <a href="#"  data-form_id="{{ 'delete_form_'.$enquiry->id }}" class="dropdown-item delete" > <i class="ft-trash-2"></i>{{transalte('Delete')}}</a>  
    </span>
</span>