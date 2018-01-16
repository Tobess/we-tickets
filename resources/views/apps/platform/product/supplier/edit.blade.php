@extends('layouts.content', ['_title' => '供应商家'])

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li class="active"><a href="{{ app_route('product/supplier') }}"><span class="text-muted">供应商家</span></a></li>
        <li class="active"><span class="text-muted">编辑{{ $row->name or '' }}</span></li>
    </ul>
    <div class="padder padder-v m-l-sm m-b-sm m-r-sm center-block bg-white" style="max-width: 880px;">
        <form role="form" class="ng-pristine ng-valid" action="{{ app_route('product/supplier/store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $row->id or 0 }}">
            <div class="form-group">
                <label>姓名</label>
                <input type="text" class="form-control" placeholder="请输入姓名" name="name" value="{{ $row->name or '' }}">
            </div>
            <div class="form-group">
                <label>电话</label>
                <input type="tel" class="form-control" placeholder="请输入手机号码" name="mobile" value="{{ $row->mobile or '' }}">
            </div>
            <div class="form-group">
                <label>密码</label>
                <input type="password" class="form-control" placeholder="请输入密码" name="password">
            </div>
            <div class="form-group">
                <label>场馆</label>
                <select class="form-control" placeholder="请选择归属场馆" ui-jq="chosen" name="venue_id">
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}" {{ $row->venue_id == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="block text-right">
                <button type="submit" class="btn btn-sm btn-primary">提交</button>
            </div>
        </form>
    </div>
@endsection