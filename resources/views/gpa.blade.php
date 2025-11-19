@extends('layouts.app')
@section('gpa','active')

@section('content')
    <div class="container">
        <div class="py-5 px-3 row justify-content-center">
            <div class="col-md-8 col-lg-6 card my-card shadow">
                <div class="card-body p-2 p-md-4">
                    <h2 class="my-4">حساب المعدل</h2>
                    <div class="row" id="courses">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col p-1">
                                    <p class="px-1">المادة</p>
                                </div>
                                <div class="col p-1">
                                    <p class="px-1">الساعات</p>
                                </div>
                                <div class="col-2 p-1">
                                    <p class="px-1">الدرجة</p>
                                </div>
                                <div class="col-2 p-1">
                                    <p class="px-1">التقدير</p>
                                </div>
                                <div class="col p-1">
                                    <p class="px-1">النقاط</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row g-md-3">
                                <div class="col p-1">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col p-1">
                                    <input type="number" id="hours-1" oninput="calculatePoints(1)" class="form-control">
                                </div>
                                <div class="col-2 p-1">
                                    <input type="number" id="grade-1" min="0" max="100" oninput="calculateGrade(1)" class="form-control">
                                </div>
                                <div class="col-2 p-1">
                                    <select class="form-control" id="grade-select-1" oninput="setNumericGrade(1)">
                                        <option value=""></option>
                                        <option value="5">A+</option>
                                        <option value="4.75">A</option>
                                        <option value="4.5">B+</option>
                                        <option value="4">B</option>
                                        <option value="3.5">C+</option>
                                        <option value="3">C</option>
                                        <option value="2.5">D+</option>
                                        <option value="2">D</option>
                                        <option value="1">F</option>
                                    </select>
                                </div>
                                <div class="col p-1">
                                    <input type="text" id="points-1" class="form-control" disabled>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-primary mt-3" id="add-new-course">إضافة مادة جديدة</button>
                        </div>
                    </div>

                    <div class="row pt-4">

                        <div class="col">
                            <input type="number" min="0" max="5" class="form-control" id="previous-gpa" oninput="calculateCGPA()" placeholder="المعدل السابق">
                        </div>
                        <div class="col">
                            <input type="number" min="0" class="form-control" id="previous-hours" oninput="calculateCGPA()" placeholder="الساعات السابقة">
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <div class="row">
                            <div class="col-6">
                                <h4>الفصل الحالي:</h4>
                                <p>مجموع النقاط: <span id="total-points">0</span></p>
                                <p>مجموع الساعات: <span id="total-hours">0</span></p>
                                <p>المعدل الفصلي: <span id="GPA">0</span></p>
                            </div>
                            <div class="col-6">
                                <h4>التراكمي:</h4>
                                <p>مجموع النقاط: <span id="total-points-all">0</span></p>
                                <p>مجموع الساعات: <span id="total-hours-all">0</span></p>
                                <p>المعدل التراكمي: <span id="CGPA">0</span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        let coursesCount = 0
        let id_counter = 1
        let allPoints = {}
        let allHours = {}
        let allCourses = {}

        function setNumericGrade(id) {

            const gradeSelectElement = $('#grade-select-' + id);
            const gradeInputElement = $('#grade-' + id)

            switch (gradeSelectElement.val()) {
                case '5':
                    gradeInputElement.val('95');
                    break;
                case '4.75':
                    gradeInputElement.val('90');
                    break;
                case '4.5':
                    gradeInputElement.val('85');
                    break;
                case '4':
                    gradeInputElement.val('80');
                    break;
                case '3.5':
                    gradeInputElement.val('75');
                    break;
                case '3':
                    gradeInputElement.val('70');
                    break;
                case '2.5':
                    gradeInputElement.val('65');
                    break;
                case '2':
                    gradeInputElement.val('60');
                    break;
                default:
                    gradeSelectElement.val('');
            }
            calculatePoints(id);
            //   calculateGPA();
        }


        function calculateGrade(id) {

            const gradeInputElement = $('#grade-' + id);
            const gradeSelectElement = $('#grade-select-' + id);
            // const coursePointsElement = $('#points-'+id);
            const gradeValue = parseFloat(gradeInputElement.val());

            if (isNaN(gradeValue)) {
                gradeSelectElement.val('');
                // coursePointsElement.val('0');
            } else if (gradeValue >= 95) {
                gradeSelectElement.val('5');
            } else if (gradeValue >= 90) {
                gradeSelectElement.val('4.75');
            } else if (gradeValue >= 85) {
                gradeSelectElement.val('4.5');
            } else if (gradeValue >= 80) {
                gradeSelectElement.val('4');
            } else if (gradeValue >= 75) {
                gradeSelectElement.val('3.5');
            } else if (gradeValue >= 70) {
                gradeSelectElement.val('3');
            } else if (gradeValue >= 65) {
                gradeSelectElement.val('2.5');
            } else if (gradeValue >= 60) {
                gradeSelectElement.val('2');
            } else {
                gradeSelectElement.val('1');
            }

            calculatePoints(id);
            //   calculateGPA();

        }

        function calculatePoints(id) {

            const hoursElem = $('#hours-'+id)
            const hoursValue = parseFloat(hoursElem.val());

            const gradeSelectElement = $('#grade-select-' + id);
            const gradeSelectValue = parseFloat(gradeSelectElement.val());

            const coursePointsElement = $('#points-'+id);
            const points = gradeSelectValue * hoursValue || 0;
            coursePointsElement.val(points.toFixed(2));

            const course_id = 'course-'+id

            if (!(course_id in allCourses)) {
                coursesCount++
            }

            allCourses[course_id] = {'hours':hoursValue,'grade':gradeSelectValue,'points':points}

            calculateGPA();

        }

        function calculateGPA() {

            const totals = getTotals()

            const gpaResultElement = $('#GPA');
            const totalHoursElement = $('#total-hours');
            const totalPointsElement = $('#total-points');

            const gpa = (totals.totalPoints / totals.totalHours).toFixed(2);
            const averageGrade = (totals.totalGrades / coursesCount).toFixed(2);

            gpaResultElement.html(isNaN(gpa) ? '0' : gpa);
            totalHoursElement.html(totals.totalHours);
            totalPointsElement.html(totals.totalPoints);

            calculateCGPA();

        }

        function getTotals() {

            let totalPoints = 0;
            let totalHours = 0;

            for (key in allCourses) {

                const course = allCourses[key];

                if (!isNaN(course.hours) &&
                    !isNaN(course.points)) {

                    totalHours += course.hours;
                    totalPoints += course.points;

                }

            }

            return {'totalPoints':totalPoints,'totalHours':totalHours}

        }

        function calculateCGPA() {

            const previousGpaElement = $('#previous-gpa');
            const previousHoursElement = $('#previous-hours');

            const previousGpa = parseFloat(previousGpaElement.val());
            const previousHours = parseFloat(previousHoursElement.val());

            if (previousGpa > 0 && previousHours > 0) {

                const cgpaElement = $('#CGPA');
                const totalHoursAllElement = $('#total-hours-all');
                const totalPointsAllElement = $('#total-points-all');

                const totals = getTotals()

                const totalHoursAll = totals.totalHours + (isNaN(previousHours) ? 0 : previousHours);
                const totalPointsAll = totals.totalPoints + (isNaN(previousGpa) ? 0 : previousGpa * previousHours);

                const cgpa = (totalPointsAll / totalHoursAll).toFixed(2);

                totalHoursAllElement.html(totalHoursAll);
                totalPointsAllElement.html(totalPointsAll);
                cgpaElement.html(isNaN(cgpa) ? '0' : cgpa);

            }
        }

        $('#add-new-course').on('click',function() {

            id_counter++;

            $('#courses').append(`
                <div class="col-12">
                    <div class="row g-md-3">
                        <div class="col p-1">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col p-1">
                            <input type="number" id="hours-${id_counter}" oninput="calculatePoints(${id_counter})" class="form-control">
                        </div>
                        <div class="col-2 p-1">
                            <input type="number" id="grade-${id_counter}" min="0" max="100" oninput="calculateGrade(${id_counter})" class="form-control">
                        </div>
                        <div class="col-2 p-1">
                            <select class="form-control" id="grade-select-${id_counter}" oninput="setNumericGrade(${id_counter})">
                                <option value=""></option>
                                <option value="5">A+</option>
                                <option value="4.75">A</option>
                                <option value="4.5">B+</option>
                                <option value="4">B</option>
                                <option value="3.5">C+</option>
                                <option value="3">C</option>
                                <option value="2.5">D+</option>
                                <option value="2">D</option>
                                <option value="1">F</option>
                                </select>
                        </div>
                        <div class="col p-1">
                            <input type="text" id="points-${id_counter}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            `);

        })

    </script>
@endsection
