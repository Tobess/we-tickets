@extends('layouts.content')

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li><span class="text-muted">场馆管理</span></li>
        <li class="active"><span class="text-muted">{{ $venue->name ?? '新增场馆' }}</span></li>
    </ul>
    <div class="padder center-block">
        <form class="form-validation" action="{{ route('venue-store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $venue->id or 0 }}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="h4">编辑场馆</span>
                </div>
                <div class="panel-body">
                    <div class="form-group pull-in clearfix">
                        <div class="col-sm-6">
                            <label>场馆名称</label>
                            <input name="name" type="text" class="form-control" placeholder="请输入场馆名称" required
                                   value="{{ $venue->name or '' }}">
                        </div>
                        <div class="col-sm-6">
                            <label>经营类目</label>
                            <select ui-jq="chosen" multiple name="categories" type="text" class="form-control"
                                    value="{{ isset($venue->categories) ? $venue->categories->implode(',') : '' }}" data-placeholder="请选择经营类目">
                                @if(isset($categories[0]))
                                    @foreach($categories[0] as $lev1)
                                        @if(isset($categories[$lev1->id]))
                                        <optgroup label="{{ $lev1->name }}">
                                            @foreach($categories[$lev1->id] as $lev2)
                                                <option value="{{ $lev2->id }}" {{ in_array($lev2->id, isset($venue->categories) ? $venue->categories->toArray() : []) ? 'selected' : '' }}>{{ $lev2->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group pull-in clearfix">
                        <div class="col-sm-6">
                            <label>场馆电话</label>
                            <input name="phone" type="text" class="form-control" placeholder="请输入场馆电话" required
                                   value="{{ $venue->phone or '' }}">
                        </div>
                        <div class="col-sm-6">
                            <label>场馆手机</label>
                            <input name="mobile" type="text" class="form-control" placeholder="请输入场馆手机" required
                                   value="{{ $venue->mobile or '' }}">
                        </div>
                    </div>
                    <div class="form-group pull-in clearfix">
                        <div class="col-sm-6" ui-area>
                            <label>归属区域</label>
                            <div class="hbox form-control no-padder" ui-area>
                                <div class="col">
                                    <select id="province" name="province" class="form-control w-full no-border" required
                                            style="height: 32px;" area-province="{{ $venue->province or '0' }}">
                                    </select>
                                </div>
                                <div class="col">
                                    <select id="city" name="city" class="form-control w-full no-border" required
                                            style="height: 32px;" area-city="{{ $venue->city or '0' }}">
                                    </select>
                                </div>
                                <div class="col">
                                    <select id="district" name="area_id" class="form-control w-full no-border" required
                                            style="height: 32px;" area-district="{{ $venue->area_id or '0' }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>详细地址</label>
                            <input name="street" type="text" class="form-control" placeholder="请输入详细地址" required
                                   value="{{ $venue->street or '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>交通信息</label>
                        <textarea id="trafficBox" name="traffic" ui-editor class="form-control" rows="6">
                            {{ $venue->traffic or '' }}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>场馆详情</label>
                        <textarea id="descBox" name="description" ui-editor class="form-control" rows="6">
                            {{ $venue->description or '' }}
                        </textarea>
                    </div>
                </div>
                <footer class="panel-footer text-right bg-light lter">
                    <button type="submit" class="btn btn-success">提交</button>
                </footer>
            </div>
        </form>
    </div>
@stop

@section('scripts')
@stop