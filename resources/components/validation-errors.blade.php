@if($errors->count())
    <div class="alert alert-danger">
    <span class="pb-3">
          {{ $slot }}
    </span>
        <ul style="margin-bottom: 0; padding-bottom: 0;">
            @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>

@endif
