@foreach (['success', 'message', 'danger'] as $msg)
    @if (Session::has($msg))
        <div class="alert alert-{{ $msg == 'message' ? 'info' : $msg }}">
            <button type="button" class="close" aria-hidden="true" data-dismiss="alert">x</button>
            {{ Session::get($msg) }}
        </div>
    @endif
@endforeach