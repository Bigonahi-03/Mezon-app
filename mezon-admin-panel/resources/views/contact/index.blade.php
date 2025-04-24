@extends('layouts.master')

@section('title', 'Contact Us')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">پیام های ارتباط با ما </h4>
    </div>

    @if ($contacts->isEmpty())
        <div class="alert alert-warning" role="alert">
            پیامی برای نمایش وجود ندارد!</div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle  table-hover">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>موضوع</th>
                        <th>متن پیام</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->body }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('contact-us.show', ['contactUs' => $contact->id]) }}"
                                        class="btn btn-sm btn-outline-info me-2">مشاهده</a>

                                    <form id="delete-form-contact-us-{{ $contact->id }}"
                                        action="{{ route('contact-us.destroy', ['contactUs' => $contact->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('delete-form-contact-us-{{ $contact->id }}')">حذف</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    @endif

@endsection
