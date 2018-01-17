@extends('layouts.content')

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">分销</span></li>
        <li class="active"><span class="text-muted">销售订单</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="box-header">
                <div class="row wrapper">
                    <div class="col-sm-6" ui-area area-hint="Yes">
                        <a class="btn btn-sm btn-primary" type="button" href="{{ app_route('orders/create') }}">
                            <i class="fa fa-plus"></i>
                            新增
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group input-group-sm">
                            <input id="searchQueryBox" type="text" class="input-sm form-control" placeholder="请输入场馆名称查询" {{ isset($query) ? 'value='.$query : ''}}>
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="button" onclick="window.location.href='?query='+$('#searchQueryBox').val();">搜!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light m-b-none">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 64px;">序号</th>
                        <th>分销商户</th>
                        <th>编号</th>
                        <th>渠道</th>
                        <th>客户</th>
                        <th>交易时间</th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $idx => $row)
                        <tr>
                            <td class="text-center">{{ $idx + 1  }}</td>
                            <td>{{ $row->d_name }}</td>
                            <td>{{ $row->code }}</td>
                            <td>{{ $row->channel }}</td>
                            <td>{{ $row->client_name }}({{ $row->client_mobile }})</td>
                            <td>{{ $row->exchanged_at }}</td>
                            <td>
                                <button class="btn btn-xs btn-info m-b-none" type="button" >退货</button>
                                <button class="btn btn-xs btn-danger m-b-none" type="button" onClick="destroy('{{ $row->id }}')">删除</button>
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
                        {{ $rows->appends(array('query' => isset($query) ? $query : ''))->links('layouts.blocks.pager') }}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{--@include('apps.platform.product.category.form')--}}
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
         * 删除类目
         * @param id
         */
        function destroy(id)
        {
            if (confirm('您确定要删除此订单吗?')) {
                //window.location.href='/platform/product/venue/destroy/'+id;
            }
        }
    </script>
@stop