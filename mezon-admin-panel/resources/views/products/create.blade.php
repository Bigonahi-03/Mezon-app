@extends('layouts.master')
@section('title', 'Products Create')

@section('link')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

@endsection



@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ایجاد محصولات</h4>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>لطفاً خطاهای زیر را برطرف کنید:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form class="row gy-4 mb-5" action="{{ route('products.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        {{-- Primary Image --}}
        <div class="d-flex justify-content-center align-items-center text-center" style="min-height: auto;" x-data="imageViewer()">
            <div class="col-md-4" x-data="imageViewer()">
                <label class="form-label">تصویر اصلی</label>
                <div>
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="rounded" width="300" alt="primary-image">
                    </template>
                </div>
                <input name="primary_image" @change="fileChosen" type="file" class="form-control mt-3" />
                <div class="form-text text-danger">@error('primary_image'){{ $message }}@enderror</div>
            </div>
        </div>
        
        {{-- Product Imags  --}}
        <div class="col-md-3">
            <label for="formFileMultiple" class="form-label">تصاویر دیگر </label>
            <input class="form-control" name="images[]" value="{{ old('images[]') }}" type="file" id="formFileMultiple" multiple>
            <div class="text-danger">@error('imags'){{ $message }}@enderror</div>
        </div>

        {{-- Product Name  --}}
        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input name="name" type="text" value="{{ old('name') }}" class="form-control" />
            <div class="text-danger">@error('name'){{ $message }}@enderror</div>
        </div>

        {{-- Product Category  --}}
        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
            <x-category-options :categories="$categories" :level="0" />
            <div class="text-danger">@error('category_id'){{ $message }}@enderror</div>
        </div>
        
        {{-- Product Status  --}}
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select class="form-select" name="status" aria-label="Default select example">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>فعال</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>غیر فعال</option>
              </select>
            <div class="text-danger">@error('status'){{ $message }}@enderror</div>
        </div>

        {{-- Product Price  --}}
        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input name="price" type="text" value="{{ old('price') }}" class="form-control" />
            <div class="text-danger">@error('price'){{ $message }}@enderror</div>
        </div>

        {{-- Product Quantity  --}}
        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input name="quantity" type="number" value="{{ old('quantity') }}" class="form-control" />
            <div class="text-danger">@error('quantity'){{ $message }}@enderror</div>
        </div>

        {{-- Product Sale Price  --}}
        <div class="col-md-3">
            <label class="form-label">قیمت حراج شده</label>
            <input name="sale_price" type="text" value="{{ old('sale_price') }}" class="form-control" />
            <div class="text-danger">@error('sale_price'){{ $message }}@enderror</div>
        </div>

        {{-- Product Auction start date  --}}
        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input data-jdp name="date_on_sale_from" type="text" value="{{ old('date_on_sale_from') }}" class="form-control" />
            <div class="text-danger">@error('date_on_sale_from'){{ $message }}@enderror</div>
        </div>

        {{-- Product Auction end date  --}}
        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input data-jdp name="date_on_sale_to" type="text" value="{{ old('date_on_sale_to') }}" class="form-control" />
            <div class="text-danger">@error('date_on_sale_to'){{ $message }}@enderror</div>
        </div>

        {{-- Product Featured  --}}
        <div class="col-md-3">
            <label class="form-label">حالت</label>
            <select class="form-select" name="is_featured" aria-label="Default select example">
                <option value="0" {{ old('is_featured') == 0 ? 'selected' : '' }}>عادی</option>
                <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>ویژه</option>
              </select>
            <div class="text-danger">@error('is_featured'){{ $message }}@enderror</div>
        </div>

        {{-- Product Description  --}}
        <div class="col-md-12">
            <label class="form-label">توضیحات</label>
            <textarea name="description" type="text"class="form-control" rows="5"> {{ old('description') }} </textarea>
            <div class="text-danger">@error('description'){{ $message }}@enderror</div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ایجاد محصول
            </button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', () => ({
                imageUrl: '',

                fileChosen(event) {
                    if (event.target.files.length == 0) return;

                    let file = event.target.files[0];
                    let reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => this.imageUrl = e.target.result
                }
            }))
        });

        jalaliDatepicker.startWatch({time:true});
    </script>

    </script>
@endsection
