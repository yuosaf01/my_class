@extends('layouts.app')

@section('content')
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">يرجى تأكيد بريدك الالكتروني</div>--}}

{{--                <div class="card-body">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="container">
    <div class="py-5 px-3 row justify-content-center">
        <div class="col-md-8 col-lg-6 card shadow">
            <div class="card-body p-2 p-md-4">

                <h2 class="my-3">يرجى تأكيد بريدك الالكتروني</h2>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        لقد تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني
                    </div>
                @endif

                قبل المتابعة، يرجى التحقق من بريدك الإلكتروني للحصول على رابط التحقق
                إذا لم تستلم البريد الإلكتروني,
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">انقر هنا لطلب رابط آخر</button>.
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
