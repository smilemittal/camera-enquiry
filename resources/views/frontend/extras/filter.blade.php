@foreach($products->product_attributes as $product_attribute)
    @foreach($product_attribute->attribute as $attribute)
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
    @endforeach
@endforeach