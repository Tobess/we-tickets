@extends('layouts.content', ['_title' => '账户管理'])

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li class="active"><span class="text-muted">类目管理</span></li>
    </ul>
    <div class="padder">
        <div class="panel panel-default">
            <div class="row wrapper">
                <div class="col-sm-6">
                    <a class="btn btn-sm btn-primary" type="button" href="/platform/system/users/edit/0">
                        <i class="fa fa-plus"></i>
                        新增
                    </a>

                    <div class="btn-group">
                        <button type="button" id="showNormal" class="btn btn-sm {{ !isset($deleted) || $deleted != 1 ? 'btn-success' : 'btn-default' }}">正式</button>
                        <button type="button" id="showDeleted" class="btn btn-sm {{ isset($deleted) && $deleted == 1 ? 'btn-danger' : 'btn-default' }}">删除</button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group input-group-sm">
                        <input id="searchQueryBox" type="text" class="input-sm form-control" placeholder="请输入手机号查询" {{ isset($query) ? 'value='.$query : ''}}>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button" onclick="window.location.href='?deleted={{ $deleted }}&query='+$('#searchQueryBox').val();">搜!</button>
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
                        <th>Email</th>
                        <th>最后登录</th>
                        <th style="width:112px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                @if(!($deleted ?? false))
                                    <a class="btn btn-xs btn-info m-b-none" type="button" href="/platform/system/users/edit/{{ $user->id }}">编辑</a>
                                    @if($user->id != 1)
                                        <button class="btn btn-xs btn-danger m-b-none" type="button" onClick="stop('{{ $user->id }}')">禁用</button>
                                    @endif
                                @endif
                                @if(isset($deleted) && $deleted == 1 && Auth::id() == 1)
                                    <button class="btn btn-xs btn-primary m-b-none" type="button" onClick="recovery('{{ $user->id }}')">恢复</button>
                                    <button class="btn btn-xs btn-danger m-b-none" type="button" onClick="destroy('{{ $user->id }}')">删除</button>
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
                        <small class="text-muted inline m-t-sm m-b-sm">当前正显示第{{$users->firstItem()}}-{{$users->lastItem()}}条数据，本页{{$users->count()}}条，共{{$users->total()}}条</small>
                    </div>
                    <div class="col-sm-6 text-right text-center-xs">
                        {{ $users->appends(array('query' => isset($query) ? $query : '','deleted' => isset($deleted) ? $deleted : ''))->links('layouts.blocks.pager') }}
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
            $("#showDeleted").click(function () {
                window.location.href='?query='+$('#searchQueryBox').val()+'&deleted=1';
            });
            $("#showNormal").click(function () {
                window.location.href='?query='+$('#searchQueryBox').val();
            });
        });

        @if(!($deleted ?? false))

        /**
         * 删除用户
         * @param id
         */
        function stop(id)
        {
            if (confirm('您确定要禁用吗？')) {
                window.location.href='/platform/system/users/stop/'+id;
            }
        }

        @endif

        @if(isset($deleted) && $deleted == 1 && Auth::id() == 1)
        /**
         * 恢复用户
         * @param id
         */
        function recovery(id)
        {
            if (confirm('您确定要恢复此账号吗?')) {
                window.location.href='/platform/system/users/recovery/'+id;
            }
        }
        /**
         * 恢复用户
         * @param id
         */
        function destroy(id)
        {
            if (confirm('您确定要删除此账号吗?')) {
                window.location.href='/platform/system/users/destroy/'+id;
            }
        }
        @endif
    </script>
@stop