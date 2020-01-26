@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
    <?php
        $alertType = [
            'info'  =>  'info',
            'success'  =>  'success',
            'error'  =>  'danger',
        ];
    ?>
    <div class="alert alert-{!! $alertType[session()->get('alert','success')] !!}">
        {{ session()->get('message') }}
    </div>
@endif