<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">اسم المادة:</label>
        <input type="text" name="class_name" class="form-control @error('class_name') is-invalid @enderror" value="{{ (old('class_name') == null) ? isset($group) ? $group['class_name'] : '' : old('class_name') }}">
        @error('class_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">رقم الشعبة:</label>
        <input type="number" name="class_number" class="form-control @error('class_number') is-invalid @enderror" value="{{ (old('class_number') == null) ? isset($group) ? $group['class_number'] : '' : old('class_number') }}">
        @error('class_number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-12">
        <input class="form-check-input" type="checkbox" name="practical_checkbox" id="practical_checkbox">
        <label class="form-check-label" for="practical_checkbox">
            هل يوجد شعبة عملي ؟
        </label>
    </div>
    <div class="col-12" id="class_number_practical_div">
        <label class="form-label">رقم الشعبة العملي:</label>
        <input type="number" name="class_number_practical" class="form-control @error('class_number_practical') is-invalid @enderror" value="{{ (old('class_number_practical') == null) ? isset($group) ? $group['class_number_practical'] : '' : old('class_number_practical') }}">
        @error('class_number_practical')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-12">
        <label class="form-label">رابط المجموعة:</label>
        <input type="url" name="group_url"  class="form-control @error('group_url') is-invalid @enderror" value="{{ (old('group_url') == null) ? isset($group) ? $group['group_url'] : '' : old('group_url') }}">
        @error('group_url')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-12">
        <label class="form-label">ملاحظات إضافية:</label>
        <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="3">{{ (old('note') == null) ? isset($group) ? $group['note'] : '' : old('note') }}</textarea>
        @error('note')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-12">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">{{$btn_title}}</button>
        </div>
    </div>
</div>

<script>

    const class_number_practical_div = $('#class_number_practical_div')
    const practical_checkbox = $('#practical_checkbox')
    if ('{{ isset($group) ?  ($group['class_number_practical'] != null) ? '1' : '0' : (old('practical_checkbox') != null ? '1' : '0') }}' == 0) {
        class_number_practical_div.toggleClass('d-none')
    }  else {
        practical_checkbox.attr('checked','checked')
    }

    practical_checkbox.on('change',() => class_number_practical_div.toggleClass('d-none'))

</script>
