@extends('layouts.app')
@section('absence','active')

@section('content')
    <div class="container">

        <div class="py-5 row justify-content-center">
            <div class="col-md-8 col-lg-6 card my-card shadow">
                <div class="card-body">
                    <h2 class="mb-4">حاسبة ساعات الغياب المسموح</h2>
                    <div class="row">
                        <div class="col-12 row py-2">
                            <label for="weeks" class="col-8 col-md-6 pt-2">عدد الاسابيع:</label>
                            <input id="weeks" type="number" class="col form-control">
                            <span id="weeks-error" class="col-12 text-danger"> </span>
                        </div>
                        <div class="col-12 row py-2">
                            <label for="hours" class="col-8 col-md-6 pt-2">ساعات المادة:</label>
                            <input id="hours" type="number" class="col form-control">
                            <span id="hours-error" class="col-12 text-danger"> </span>
                        </div>
                        <div class="col-12 row py-2">
                            <label for="absence-hours" class="col-8 col-md-6 pt-2">ساعات غيابك (اختياري):</label>
                            <input id="absence-hours" type="number" class="col form-control">
                            <span id="absence-hours-error" class="col-12 text-danger"> </span>
                        </div>
                        <div class="col-12 row py-2">
                            <label for="percentage" class="col-8 col-md-6 pt-2">الحد الاقصى للغياب:</label>
                            <select id="percentage" class="col form-control">
                                <option value="15">15%</option>
                                <option selected value="20">20%</option>
                                <option value="25">25%</option>
                            </select>
                            <span id="percentage-error" class="col-12 text-danger"> </span>
                        </div>
                        <div class="col-12 pt-3">
                            <button id="btn-calculate" class="btn btn-primary w-100">احسب</button>
                        </div>
                        <div class="col-12 pt-3" id="alert">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {

            let weeksElem = $('#weeks')
            let hoursElem = $('#hours')
            let absenceHoursElem = $('#absence-hours')

            $("#btn-calculate").on("click",function () {

                $('#weeks-error').html('');
                $('#hours-error').html('');
                $('#percentage-error').html('');

                let weeks = weeksElem.val();
                let hours = hoursElem.val();
                let percentage = $('#percentage').val();

                const all_hours = (hours * weeks)

                const allowed_absence_hours = Math.round(all_hours * (percentage / 100))
                let absence_percentage_message = ''

                if (absenceHoursElem.val() > 0) {

                    const absenceHours = absenceHoursElem.val()
                    const absencePercentage = Math.round((absenceHours / all_hours) * 100)
                    absence_percentage_message = `<br>نسبة غيابك هي: ${absencePercentage}٪`

                }

                if (allowed_absence_hours > 0) {
                    $('#alert').html(`
                        <div class="alert alert-info">
                        عدد الساعات المسموحة هي: ${allowed_absence_hours}
                         ${absence_percentage_message}
                        </div>
                    `)
                }else {
                    $('#alert').html(`
                        <div class="alert alert-danger">
                        يرجى تعبئة كل الحقول
                        </div>
                    `)
                }
            });

        });


    </script>

@endsection
