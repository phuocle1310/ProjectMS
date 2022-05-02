<select class="form-control" name="userid" id="user-select">
<option selected value="0">Choose user</option>
    @foreach($users as $each)
        @if (old('userid') == $each->id)
            <option value="{{ $each->id }}" selected>{{ $each->name}}</option>
        @else
            <option value="{{ $each->id }}">{{ $each->name }}</option>
        @endif
    @endforeach
</select>