@extends('layouts.content')

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">销售</span></li>
        <li class="active"><span class="text-muted">分销商品</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="box-header">
                <div class="row wrapper">
                    <div class="col-sm-6">
                        <button class="btn btn-sm btn-primary m-r-sm" type="button" onclick="dist()">
                            <i class="fa fa-plus"></i>
                            分销
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group input-group-sm">
                            <input id="searchQueryBox" type="text" class="input-sm form-control" placeholder="请输入产品名称查询" {{ isset($query) ? 'value='.$query : ''}}>
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
                        <th>产品</th>
                        <td>分销数量</td>
                        <td>剩余库存</td>
                        <th>分销商</th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $idx => $row)
                        <tr>
                            <td class="text-center">{{ $idx + 1  }}</td>
                            <td>{{ $row->p_name }} {{ $row->sku_note }}</td>
                            <td>{{ $row->dist_total }}</td>
                            <td>{{ $row->sku_num }}</td>
                            <td>{{ $row->d_name }}</td>
                            <td>
                                <button class="btn btn-xs btn-danger m-b-none" type="button" onClick="back('{{ $row->id }}')">退回</button>
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

    @include('apps.platform.sale.dist.item.dist')
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $("#searchQueryBox").keypress(function(e) {
                if (e.which == 13) {
                    window.location.href='?query='+$('#searchQueryBox').val();
                }
            });

            $("#item").change(function () {
                var gid = $(this).val();
                $('#sku').empty();
                $.APIAjaxByGet('/platform/product/items/stocks/' + gid, {}, function (result) {
                    if (result && result.data && typeof result.data === "object") {
                        var $options = [];
                        $(result.data).each(function (k, v) {
                            $options.push('<option value="' + v.id + '">' + v.title + ' ' + v.num + '件 ' + v.price + ' 元' +  '</option>')
                        });
                        $('#sku').html($options.join('')).chosen().trigger("chosen:updated");
                    }
                });
            });

            $("#submitBtn").click(function () {
                var data = {
                    'dist_id':$("#dist").val(),
                    'product_id':$("#item").val(),
                    'stock_id':$("#sku").val(),
                    'sku_num':$("#number").val(),
                    'sku_price':$("#price").val()
                };
                if (data.dist_id > 0 && data.product_id > 0 && data.sku_num > 0 && data.sku_price >= 0) {
                    $.APIAjaxByPost('/platform/sale/dist-items/store', data, function (result) {
                        if (result && result.state && typeof result.state) {
                            $("#formAddModal").find('form').get(0).reset();
                        } else {
                            alert(result && result.msg ? result.msg : '添加分销失败！');
                        }
                    });
                } else {
                    alert('分销商户、分销商品、分销数量、分销单价必须填写！');
                }
            });
        });

        /**
         * 显示明细详情
         */
        function dist() {
            var $modal = $("#formAddModal");
            if ($modal != null) {
                $modal.modal({
                    keyboard: false,
                    backdrop: 'static'
                }).show();

                setTimeout(function () {
                    $modal.find('select').trigger('ui-jq', ['chosen']);
                    $('#item').trigger('change');
                }, 10);
            }
        }

        /**
         * 取消分销
         * @param id
         */
        function back(id)
        {
            if (confirm('您确定要退吗?')) {
                window.location.href='{{ app_route('sale/dist-items/destroy/') }}' + id;
            }
        }
    </script>
@stop