@extends('layout')

@section('title', 'Add Product')
@section('action-stylesheet')
<style>
    .card {
        border: 1px solid lightgray;
        margin-top:10px; margin-bottom: 10px;
        padding: 10px;
    }
</style>
@stop
@section('content')
    <form action="/admin/product/save" METHOD="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_title">Product Title</label>
                        <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Product Title" required>
                    </div>
                    <div class="form-group">
                        <label for="product_description">Product Description</label>
                        <textarea class="form-control" id="product_description" name="product_description" placeholder="Product Description" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Variants</h4>
                    <hr/>
                </div>
            </div>
            <div class="row variant-row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="product_color[]" placeholder="Color" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="number" class="form-control" name="product_price[]" placeholder="Price" required>
                    </div>
                </div>
                <div class="col-md-2 remove-button" style="display: none">
                    <button type="button" class="btn btn-primary" onclick="removeVariantRow(this)">Remove</button>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-primary" onclick="addVariant()">Add variant</button>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@stop
@section('action-script')
    <script>
        function removeVariantRow(e) {
            $(e).closest(".variant-row").remove();
        }
        function addVariant(e) {
            var $firstVariant = $(".variant-row:first");
            var $lastVariant = $(".variant-row:last");
            var $newE = $firstVariant.clone();
            $lastVariant.after($newE);
            $(".variant-row:last .remove-button").show();
        }
    </script>
@stop

