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
                    <input type="text" class="form-control" placeholder="请输入订单编号" name="code" required value="{{ old('code') }}">
                </div>
                <div class="col-sm-6">
                    <label>订单渠道</label>
                    <select class="form-control" data-placeholder="请选择订单渠道" name="channel" ui-jq="chosen" required value="{{ old('channel') }}">
                        <option value="1">有赞</option>
                        <option value="0">自有</option>
                    </select>
                </div>
            </div>
            <div class="form-group pull-in clearfix">
                <div class="col-sm-6">
                    <label>客户姓名</label>
                    <input type="text" class="form-control" placeholder="请输入客户姓名" name="client_name" required value="{{ old('client_name') }}">
                </div>
                <div class="col-sm-6">
                    <label>客户电话</label>
                    <input type="text" class="form-control" placeholder="请输入客户电话" name="client_mobile" required value="{{ old('client_mobile') }}">
                </div>
            </div>
            <div class="form-group pull-in clearfix">
                <div class="col-sm-6">
                    <label>客户证件</label>
                    <input type="text" class="form-control" placeholder="请输入客户证件" name="client_identify" value="{{ old('client_identify') }}">
                </div>
                <div class="col-sm-6">
                    <label>交易时间</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="请选择交易时间" value="{{ old('exchanged_at') }}"
                               name="exchanged_at" ui-jq="datetimepicker" data-date-format="yyyy-mm-dd hh:ii:ss">
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
                    <table id="gTable" class="table m-b-none b-b m-b-sm">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th style="width: 102px;">数量</th>
                            <th style="width: 102px;">单价</th>
                            <th style="width: 64px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items ?? old('items', []) as $did => $item)
                            <tr>
                                <td>
                                    <input type="hidden" name="items[{{ $did }}][title]" value="{{ $item['title'] }}">{{ $item['title'] }}
                                </td>
                                <td>
                                    <input name="items[{{ $did }}][num]" class="form-control input-sm" style="width: 100%;" value="{{ $item['num'] }}">
                                </td>
                                <td>
                                    <input name="items[{{ $did }}][price]" class="form-control input-sm" style="width: 100%;" value="{{ $item['price'] }}">
                                </td>
                                <td class="actions">
                                    <button class="btn btn-danger btn-xs">删除</button>
                                </td>
                            </tr>
                        @endforeach
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
                                        @foreach($dists as $dist)
                                            <option value="{{ $dist->id }}">{{ $dist->p_name }} {{ $dist->sku_note }} {{ $dist->sku_num }}件 {{ $dist->sku_price }}元</option>
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
                    <button id="modalBtn" type="button" class="btn btn-primary">确定</button>
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
                    }, 10);
                }
            });

            $("#modalBtn").click(function () {
                var did = $("#item").val();
                var number = parseInt($("#number").val(), 10) || 0;
                var price = parseFloat($("#price").val()) || 0;
                if (did > 0 && number > 0 && price >= 0) {
                    if ($('input[name="did[]"][value="' + did + '"]').size() > 0) {
                        alert('该商品已经添加了！');
                    } else {
                        var gName = $("#item").find('option:selected').text();
                        var $tr = '<tr>\n' +
                            '          <td>\n' +
                            '              <input type="hidden" name="items[' + did + '][title]" value="' + gName + '">' + gName + '\n' +
                            '          </td>\n' +
                            '          <td>\n' +
                            '              <input name="items[' + did + '][num]" class="form-control input-sm" style="width: 100%;"  value="' + number + '">\n' +
                            '          </td>\n' +
                            '          <td>\n' +
                            '              <input name="items[' + did + '][price]" class="form-control input-sm" style="width: 100%;" value="' + price + '">\n' +
                            '          </td>\n' +
                            '          <td class="actions">\n' +
                            '              <button class="btn btn-danger btn-xs">删除</button>\n' +
                            '          </td>\n' +
                            '      </tr>';
                        $("#gTable tbody").append($tr);
                    }
                } else {
                    alert('商品及数量必填！');
                }
            })
        })
    </script>
@stop