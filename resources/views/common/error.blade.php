@if (count($errors) > 0)
    <div class="alert alert-danger">
        <h4>有错误发生：</h4>
        @foreach($errors->all() as $error)
            <li><i class="glyphicon glyphicon-remove"></i>{{ $error }}</li>
        @endforeach
    </div>
@endif