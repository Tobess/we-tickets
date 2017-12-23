@extends('layouts.content')

@section('head')
    <style>
        .nav.nav-tabs li.active {
            margin-bottom: -2px;
        }
        .nav.nav-tabs li.active a {
            margin: 0px;
            background-color: #ddd;
            border: 1px solid #ddd;
            padding-bottom: 11px;
            color: #5cb85c;
        }

        .category {
            border: 2px solid #f6f8f8;
        }
        .category.active, .category:active, .category:hover {
            border: 2px solid #f63;
            color: #f63;
            background-color: #fff;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li><span class="text-muted">产品管理</span></li>
        <li class="active"><span class="text-muted">{{ $item->name ?? '新增产品' }}</span></li>
    </ul>
    <div class="wrapper center-block" style="background-color: white;">
        <form class="form-validation" action="{{ route('venue-store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $item->id or 0 }}">
            <div class="tab-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="" class="ng-binding">1. 选择商品品类</a>
                    </li>
                    <li disabled="disabled" active="steps.step2" select="steps.percent=30" class="ng-scope ng-isolate-scope disabled">
                        <a href="" class="ng-binding">2. 编辑基本信息</a>
                    </li>
                    <li disabled="disabled" active="steps.step3" select="steps.percent=60" class="ng-scope ng-isolate-scope disabled">
                        <a href="" class="ng-binding">3. 编辑商品详情</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="wrapper-md text-center" style="padding-bottom: 0px;">
                            <div class="row">
                            @foreach($tops as $row)
                                <div class="col-sm-3">
                                    <div class="panel wrapper-md bg-light lter category">
                                        {{ $row->name }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel wrapper-md bg-light lter category">
                                        {{ $row->name }}
                                    </div>
                                </div>

                            @endforeach
                            </div>
                            <div class="m-t m-b">
                                <button type="submit" class="btn btn-success btn-sm" disabled="disabled">下一步</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active">
                        <div class="hbox bg-light lter">
                            <div class="col text-center" style="width: 106px;border-right: 2px solid white;">基本信息</div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <div class="tab-pane active">
                        <textarea id="descBox" name="description" ui-editor class="form-control" rows="12">{{ $item->description or '' }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $('.panel.category').click(function () {
                console.log($(this).text());
            })
        });
    </script>
@stop