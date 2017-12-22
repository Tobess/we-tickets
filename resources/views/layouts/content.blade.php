@extends('layouts.app')

@section('container')
    <div class="app app-header-fixed app-aside-fixed">
        @include('layouts.blocks.header')

        @include('layouts.blocks.aside')

        @if (count($errors) > 0)
            <div class="app-content">
                <div class="alert alert-danger ">
                    <strong>对不起!</strong> 出错啦!<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    <!-- content -->
        <div id="content" class="app-content" role="main">
            <div class="app-content-body ">
                @yield('content')
            </div>
        </div>

        @include('layouts.blocks.footer')
    </div>
@stop