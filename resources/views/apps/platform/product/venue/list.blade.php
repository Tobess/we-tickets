@extends('layouts.content')

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">系统</span></li>
        <li class="active"><span class="text-muted">场馆管理</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="box-header">
                <div class="row wrapper">
                    <div class="col-sm-6">
                        <a class="btn btn-sm btn-primary m-r-sm" type="button" href="/platform/product/venue/edit/0">
                            <i class="fa fa-plus"></i>
                            新增
                        </a>
                        <label>省份</label>
                        <select id="province" name="province" class="form-control input-sm inline"
                                style="width: 82px;">
                            <option value="0">全部</option>
                        </select>
                        <label>城市</label>
                        <select id="city" name="city" class="form-control input-sm inline"
                                style="width: 82px;">
                            <option value="0">全部</option>
                        </select>
                        <label>城镇</label>
                        <select id="district" name="district" class="form-control input-sm inline"
                                style="width: 82px;">
                            <option value="0">全部</option>
                        </select>
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
                        <th>名称</th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $idx => $row)
                        <tr>
                            <td class="text-center">{{ $idx + 1  }}</td>
                            <td>{{ $row->name }}</td>
                            <td>
                                <button class="btn btn-xs btn-info m-b-none" type="button" onClick="update('{{ $row->id }}')">编辑</button>
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

            $("#categoryModal").find('button[name=submit]').click(submit);
        });

        /**
         * 编辑类目信息
         * @param id
         */
        function update(id)
        {
            var $form = $("#categoryModal");

            $form.find('form')[0].reset();
            if (id > 0) {
                $.APIAjaxByGet('/platform/product/categories/profile/'+id, {}, function(result){
                    if (!result || !result.data) {
                        alert('无法获取类目信息！');
                        return;
                    }

                    var data = result.data;
                    $form.find('[name="id"]').val(data.id);
                    $form.find('[name="name"]').val(data.name);
                    $form.find('[name="pid"]').val(data.pid);
                    $form.find('[name="pName"]').val(data.pName);

                    $form
                        .modal({
                            keyboard: false,
                            backdrop: 'static'
                        })
                        .show();
                });
            }

            $form
                .modal({
                    keyboard: false,
                    backdrop: 'static'
                })
                .show();
        }
        /**
         * 保存类目信息
         * @param param
         */
        function submit()
        {
            var $form = $("#categoryModal");
            var data = {
                'name':$form.find('[name="name"]').val(),
                'pid':$form.find('[name="pid"]').val() || 0
            };
            var id = $form.find('[name="id"]').val();
            if(id <= 0) {
                if (!data.name) {
                    alert('无效类目名称.');
                    return;
                }
            } else {
                data.id = id;
            }

            $.APIAjaxByPost('/platform/product/categories/store', data, function(result){
                if (result) {
                    if (result && result.state) {
                        alert('保存成功！');
                        $form.modal('hide');
                        window.location.reload();
                    } else {
                        alert(result && result.msg ? result.msg : '保存失败！');
                    }
                } else {
                    alert('未知错误！');
                }
            });
        }

        /**
         * 删除类目
         * @param id
         */
        function destroy(id)
        {
            if (confirm('您确定要删除此类目吗?')) {
                window.location.href='/platform/product/categories/destroy/'+id;
            }
        }
    </script>
@stop