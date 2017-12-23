@extends('layouts.content', ['_title' => '类目管理'])

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li class="active"><span class="text-muted">类目管理</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="row wrapper">
                <div class="col-sm-6">
                    <button class="btn btn-sm btn-primary" type="button" onClick="update(0)">
                        <i class="fa fa-plus"></i>
                        新增
                    </button>
                    <select id="pid" name="pid" class="form-control input-sm inline"
                            style="width: 82px;">
                        <option value="0">一级类目</option>
                        @foreach($tops as $row)
                            <option value="{{ $row->id }}" {{ (is_numeric($pid) && $pid == $row->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    <div class="input-group input-group-sm">
                        <input id="searchQueryBox" type="text" class="input-sm form-control" placeholder="请输入类目名称查询" {{ isset($query) ? 'value='.$query : ''}}>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button" id="searchBtn">搜!</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light m-b-none">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 64px;">序号</th>
                        <th>名称</th>
                        <th>父级</th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rows as $idx => $row)
                        <tr>
                            <td class="text-center">{{ $idx + 1  }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->pName }}</td>
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
                        {{ $rows->appends(array('query' => isset($query) ? $query : '', 'pid' => $pid ?? 0))->links('layouts.blocks.pager') }}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('apps.platform.product.category.form')
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $("#searchQueryBox").keypress(function(e) {
                if (e.which == 13) {
                    window.location.href = getReloadUrl();
                }
            });

            $("#pid,#searchBtn").change(function () {
                window.location.href = getReloadUrl();
            });

            $("#categoryModal").find('button[name=submit]').click(submit);
        });

        function getReloadUrl() {
            return '?pid=' + $("#pid").val() + '&query='+$('#searchQueryBox').val()
        }

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