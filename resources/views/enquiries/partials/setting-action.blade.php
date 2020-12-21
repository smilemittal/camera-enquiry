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
              class="fa fa-edit"></i>Details</a>
                        <form action="{{ $destroy }}" method="post" id="{{ 'delete_form_'.$enquiry->id}}">  
                            @csrf  
                            @method('DELETE')  
                        </form> 
            <a href="#"onclick="document.getElementById('{{ 'delete_form_'.$enquiry->id }}').submit();" class="dropdown-item" >Delete</a>  
    </span>
</span>