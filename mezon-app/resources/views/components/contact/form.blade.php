<form action="{{ route('contact_us.store') }}" method="POST">
    @csrf
    <div>
        <div class="text-danger">@error('name'){{ $message }}@enderror</div>
        <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی" value="{{ old('name') }}" />
    </div>
    <div>
        <div class="text-danger">@error('email'){{ $message }}@enderror</div>
        <input type="email" name="email" class="form-control dir-rtl" style="direction:rtl" placeholder="ایمیل" value="{{ old('email') }}"/>
    </div>
    <div>
        <div class="text-danger">@error('subject'){{ $message }}@enderror</div>
        <input type="text" name="subject" class="form-control" placeholder="موضوع پیام" value="{{ old('subject') }}"/>
    </div>
    <div>
        <div class="text-danger">@error('body'){{ $message }}@enderror</div>
        <textarea rows="10" name="body" style="height: 100px" class="form-control" placeholder="متن پیام">{{ old('body') }}</textarea>
    </div>
    <div class="btn_box">
        <button>
            ارسال پیام
        </button>
    </div>
</form>
