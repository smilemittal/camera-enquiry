@extends('frontend.layouts.app')
@section('content')
        <div class="form-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-radius-box">
                            <div class="heading-btns">
                                <h3>Wybierz rodzaj systemu</h3>
                                <div class="col-kemey col-kemey-two">
                                    <div class="row d-flex align-items-center">
                                        <input type="hidden" id="selected_system_type" name="selected_system_type" value="">
                                        @foreach($system_types as $system_type) 
                                            <div class="col-xl-3 col-md-6">
                                                <button class="system_type" data-id="{{ $system_type->id }}">{{ $system_type->name }}</button>
                                            </div>
                                        @endforeach
                                     
                                        <div class="col-xl-6 col-md-12 pl-xl-3">
                                            <p class="ml-xl-5 pl-xl-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="heading-btns three-btn-under">
                            <h3>LOREM IPSUM</h3>
                            <div class="col-kemey col-kemey-two">
                                <div class="row d-flex align-items-center">
                                    <input type="hidden" id="selected_standard" name="selected_standard" value="">
                                    @foreach($standards as $standard)
                                        <div class="col-xl-3 col-md-4">
                                        <button class="standard" data-id="{{ $standard->id }}">{{ $standard->name }}</button>
                                        </div>
                                    @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="kemey-cameras-sec">
            <div class="container">
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                            <a class="btn" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">kamery / Cameras</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="" />
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                            <a class="btn" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">kamery / Cameras</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="" />
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Number of channels</label>
                                        <select name="cars" id="cars" form="carform">
                                            <option value="volvo">Volvo</option>
                                            <option value="saab">Saab</option>
                                            <option value="opel">Opel</option>
                                            <option value="audi">Audi</option>
                                        </select>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="three-btn-sec">
            <div class="container">
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    $('.system_type').on('click', function(){
        var system_type = $(this).data('id');
        $('#selected_system_type').val(system_type);
    });  

    $('.standard').on('click', function(){
        var standard = $(this).data('id');
         var system_type = $('#selected_system_type').val();
        $('#selected_standard').val(standard);


        $.ajax({
            method:'post',
            url: '{{ route('get_enquiry_product_attributes') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'system_type': system_type,
                'standard': standard,
            },
            success: function(data){

            },
            
        });



    });   





</script>
@endsection