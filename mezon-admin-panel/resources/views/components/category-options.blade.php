<select class="form-select" name="category_id" aria-label="Default select example">
    <option value="">انتخاب دسته‌بندی</option>
    @foreach ($categories as $category)
        <optgroup label="{{ $category->name }}" style="font-weight: bold;">
            @foreach ($category->children as $child)
                <option value="{{ $child->id }}">-- {{ $child->name }}</option>
            @endforeach
        </optgroup>
        <option disabled>------------------------------------------</option>
    @endforeach
</select>
