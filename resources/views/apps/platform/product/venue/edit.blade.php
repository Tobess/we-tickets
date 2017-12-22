@extends('layouts.content')

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">系统</span></li>
        <li><span class="text-muted">场馆管理</span></li>
        <li class="active"><span class="text-muted">{{ $venue->name ?? '新增场馆' }}</span></li>
    </ul>
    <div class="padder">
        <div class="tab-container" ui-tab>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#">基本信息</a>
                </li>
                <li disabled="disabled" class="disabled">
                    <a href="#">交通线路</a>
                </li>
                <li disabled="disabled" class="disabled">
                    <a href="#">详细介绍</a>
                </li>
            </ul>
            <form name="step2" class="form-validation ng-pristine ng-scope ng-invalid ng-invalid-required">
                <div class="tab-content">
                    <div class="tab-pane active" tab-content-transclude="tab">
                        <div class="form-group">
                            <label>场馆名称</label>
                            <input type="name" class="form-control" placeholder="请输入场馆名称">
                        </div>
                        <div class="form-group">
                            <label>场馆电话</label>
                            <input type="phone" class="form-control" placeholder="请输入场馆电话">
                        </div>
                        <div class="form-group">
                            <label>场馆手机</label>
                            <input type="mobile" class="form-control" placeholder="请输入场馆手机">
                        </div>

                        <div class="m-t m-b">
                            <button type="button" class="btn btn-default btn-rounded">下一步</button>
                        </div>
                    </div>
                    <div class="tab-pane" tab-content-transclude="tab">
                        <p class="m-b">Continue the next step</p>
                        <div class="progress-xs progress ng-isolate-scope" value="steps.percent" type="success">
                            <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="10%" ng-transclude="" style="width: 10%;"></div>
                        </div>
                        <p>Your age:</p>
                        <input type="number" name="age" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" ng-model="age" required="" aria-invalid="true">
                        <div class="m-t m-b">
                            <button type="button" class="btn btn-default btn-rounded" ng-click="steps.step1=true">Prev</button>
                            <button type="submit" ng-disabled="step2.$invalid" class="btn btn-default btn-rounded" ng-click="steps.step3=true" disabled="disabled">Next</button>
                        </div>
                    </div>
                    <div class="tab-pane" tab-content-transclude="tab">

                        <p class="m-b ng-scope">Congraduations! You got the last step.</p>
                        <div class="progress-xs progress ng-scope ng-isolate-scope" value="steps.percent" type="success">
                            <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="10%" ng-transclude="" style="width: 10%;"></div>
                        </div>
                        <p class="ng-scope">Just one click to finish it.</p>
                        <div class="m-t m-b ng-scope">
                            <button type="button" class="btn btn-default btn-rounded" ng-click="steps.step2=true">Prev</button>
                            <button type="button" class="btn btn-default btn-rounded" ng-click="steps.percent=100">Click me to Finish</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--<div class="padder">--}}
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-body">--}}


                {{--<form role="form" class="ng-pristine ng-valid">--}}
                    {{--<div class="form-group">--}}
                        {{--<label>场馆名称</label>--}}
                        {{--<input type="name" class="form-control" placeholder="Enter email">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label>场馆电话</label>--}}
                        {{--<input type="phone" class="form-control" placeholder="Password">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label>场馆手机</label>--}}
                        {{--<input type="mobile" class="form-control" placeholder="Password">--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            //
        });
    </script>
@stop