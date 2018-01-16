@extends('layouts.content', ['_title' => '供应商家'])

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li class="active"><span class="text-muted">供应商家</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="row wrapper">
                <div class="col-sm-6">
                    <a class="btn btn-sm btn-primary" type="button" href="{{ app_route('product/supplier/edit/0') }}">
                        <i class="fa fa-plus"></i>
                        新增
                    </a>
                </div>
                <div class="col-sm-6">
                    <div class="input-group input-group-sm">
                        <input id="searchQueryBox" type="text" class="input-sm form-control" placeholder="请输入手机号查询" {{ isset($query) ? 'value='.$query : ''}}>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button" onclick="window.location.href='?query='+$('#searchQueryBox').val();">搜!</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light m-b-none">
                    <thead>
                    <tr>
                        <th>手机</th>
                        <th>姓名</th>
                        <th>场馆</th>
                        <th>创建</th>
                        <th></th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $row->mobile }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->venue_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>
                                @if($row->deleted_at)
                                    <span class="label bg-danger">已删除</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info m-b-none" type="button" href="{{ app_route('product/supplier/edit/' . $row->id) }}">编辑</a>
                                @if(!$row->deleted_at)
                                    <button class="btn btn-xs btn-danger m-b-none" type="button" onClick="stop('{{ $row->id }}')">禁用</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 hidden-xs">
                        <small class="text-muted inline m-t-sm m-b-sm">当前正显示第{{$rows->firstItem()}}-{{$rows->lastItem()}}条数据，本页{{$rows->count()}}条，共{{$rows->total()}}条</small>
                    </div>
                    <div class="col-sm-6 text-right text-center-xs">
                        {{ $rows->appends(array('query' => isset($query) ? $query : '','deleted' => isset($deleted) ? $deleted : ''))->links('layouts.blocks.pager') }}
                    </div>
                </div>
            </footer>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $("#searchQueryBox").keypress(function(e) {
                if (e.which == 13) {
                    window.location.href='?query='+$('#searchQueryBox').val();
                }
            });
        });

        /**
         * 禁用
         * @param id
         */
        function stop(id)
        {
            if (confirm('您确定要删吗?')) {
                window.location.href='{{ app_route('product/supplier/stop/') }}' + id;
            }
        }
    </script>
@stop