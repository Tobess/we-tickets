@extends('layouts.content')

@section('content')
    <style type="text/css">
        #goodsPanel td,#goodsPanel th {
            vertical-align: middle !important;
        }
    </style>
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">分销</span></li>
        <li><a href="{{ app_route('orders') }}"><span class="text-muted">销售订单</span></a></li>
        <li class="active"><span class="text-muted">创建订单</span></li>
    </ul>
    <div class="padder padder-v m-l-sm m-b-sm m-r-sm center-block bg-white" style="max-width: 880px;">
        <form class="form-validation" action="{{ app_route('orders/create') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group pull-in clearfix">
                <div class="col-sm-6">
                    <label>订单编号</label>
                    <input type="text" class="form-control" placeholder="请输入订单编号" name="code" required>
                </div>
                <div class="col-sm-6">
                    <label>订单渠道</label>
                    <select class="form-control" data-placeholder="请选择订单渠道" name="channel" ui-jq="chosen" required>
                        <option value="youzan">有赞</option>
                    </select>
                </div>
            </div>
            <div class="form-group pull-in clearfix">
                <div class="col-sm-6">
                    <label>客户姓名</label>
                    <input type="text" class="form-control" placeholder="请输入客户姓名" name="client_name" required>
                </div>
                <div class="col-sm-6">
                    <label>客户电话</label>
                    <input type="text" class="form-control" placeholder="请输入客户电话" name="client_mobile" required>
                </div>
            </div>
            <div class="form-group pull-in clearfix">
                <div class="col-sm-6">
                    <label>客户证件</label>
                    <input type="text" class="form-control" placeholder="请输入客户证件" name="client_identify" required>
                </div>
                <div class="col-sm-6">
                    <label>交易时间</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="请选择交易时间"
                               name="exchanged_at" required ui-jq="datetimepicker" data-date-format="yyyy-mm-dd hh:ii:ss">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" onclick="$(this).parent().prev().trigger('focus');">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="panel panel-default" id="goodsPanel">
                <div class="panel-heading">
                    <button id="openAddModal" type="button" class="btn pull-right btn-xs no-bg"><span class="text-primary">新增</span></button>
                    商品
                </div>
                <div class="block" style="min-height: 300px;">
                    <table class="table m-b-none b-b m-b-sm">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th style="width: 102px;">数量</th>
                            <th style="width: 102px;">单价</th>
                            <th style="width: 64px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                成都欢乐谷 成人票
                            </td>
                            <td>
                                <input class="form-control input-sm" style="width: 100%;">
                            </td>
                            <td>
                                <input class="form-control input-sm" style="width: 100%;">
                            </td>
                            <td class="actions">
                                <button class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block text-right bg-light lter">
                <button type="submit" class="btn btn-success">提交</button>
            </div>
        </form>
    </div>

    <div id="formAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myAddModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:480px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myAddModalLabel">新增商品</h4>
                </div>
                <div class="modal-body">
                    <div class="wrapper">
                        <div class="panel bg-white">
                            <form>
                                <div class="form-group">
                                    <label>销售商品：</label>
                                    <select class="form-control" id="item" data-placeholder="请选择分销商品">
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->p_name }} {{ $item->sku_note }} {{ $item->sku_num }}件 {{ $item->sku_price }}元</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>销售数量：</label>
                                    <input type="text" class="form-control" id="number" required="required"/>
                                </div>
                                <div class="form-group ">
                                    <label>销售价格：</label>
                                    <input type="text" class="form-control" id="price" required="required"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submitBtn" type="button"  class="btn btn-primary">确定</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $(document).on('click', '#goodsPanel table tbody tr td.actions button', function () {
                $(this).closest('tr').remove();
            });

            $("#openAddModal").click(function () {
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
            })
        })
    </script>
@stop