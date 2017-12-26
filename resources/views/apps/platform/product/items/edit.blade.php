@extends('layouts.content')

@section('head')
    <link href="{{ asset('css/goods-edit.css') }}" rel="stylesheet">
    <style>
        .nav.nav-tabs li.active {
            margin-bottom: -2px;
        }
        .nav.nav-tabs li.active a {
            margin: 0px;
            background-color: #ddd;
            border: 1px solid #ddd;
            padding-bottom: 11px;
            color: #5cb85c;
        }

        .category {
            border: 2px solid #f6f8f8;
        }
        .category.active, .category:active, .category:hover {
            border: 2px solid #f63;
            color: #f63;
            background-color: #fff;
            cursor: pointer;
        }

        /*商品字段控件样式*/
        .form-horizontal .static-value {
            padding-top: 5px;
            font-size: 14px;
            line-height: 18px;
            padding-bottom: 5px;
            word-break: break-all;
        }
        .form-horizontal .goods-info-group .static-value {
            font-size: 12px;
            vertical-align: middle;

        }
        .checkbox, .radio {
            min-height: 20px;
            padding-left: 20px;
        }

        .checkbox.inline, .radio.inline {
            display: inline-block !important;
            padding-top: 5px;
            margin-bottom: 0;
            vertical-align: middle;
        }
        .radio input[type="radio"], .checkbox input[type="checkbox"] {
            margin-left: -16px;
            margin-top: 1px;
        }
        .controls>.checkbox:first-child, .controls>.radio:first-child {
            padding-top: 5px;
        }
        .checkbox.inline+.checkbox.inline, .radio.inline+.radio.inline {
            margin-left: 10px;
        }

        .goods-info-group .info-group-title .group-inner {
            padding: 28px 10px 23px;
        }
        .goods-info-group .info-group-cont .group-inner {
            padding: 23px 20px 10px;
        }
        .control-group {
            margin-bottom: 20px;
        }
        .control-group .control-label {
            width: 100px;
            cursor: default;
            float: left;
            font-size: 12px !important;
            text-align: right;
            padding-top:5px;
        }
        .control-group .controls {
            margin-left: 116px;
            font-size: 12px !important;
        }

        /*重写chosen*/
        .chosen-container-single .chosen-single {
            height: 28px;
            line-height: 28px;
        }
        .chosen-container-single .chosen-single div b {
            background-position-y: 4px;
        }
        .chosen-container-multi .chosen-choices {
            padding: 1px 2px;
            min-height: 28px;
            font-size: 12px;
            vertical-align: middle;
        }

        /*必要字段符号*/
        .form-horizontal em.required {
            font-size: 16px;
            color: #f00;
            vertical-align: middle;
        }

        /*图片管理*/
        .module-goods-list,
        .app-image-list {
            list-style: none;
            padding: 0px;
        }
        .module-goods-list li .add-goods,
        .module-goods-list li .add,
        .app-image-list li .add-goods,
        .app-image-list li .add {
            display: inline-block;
            width: 100%;
            height: 100%;
            line-height: 50px;
            text-align: center;
            cursor: pointer;
        }
        .module-goods-list li,
        .app-image-list li {
            float: left;
            margin: 0 10px 10px 0;
            display: block;
            width: 50px;
            height: 50px;
            border: 1px solid #ddd;
            background-color: #fff;
            position: relative;
        }
        .module-goods-list li img,
        .app-image-list li img {
            height: 100%;
            width: 100%;
        }
        /*视频*/
        .video-edit-wrap .add-video {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            border: 1px solid #ddd;
            background: #fff;
            position: relative;
            text-align: center;
        }
        .video-edit-wrap a {
            cursor: pointer;
        }

        .form-horizontal .help-block,
        .form-horizontal .help-desc {
            opacity: 0.6;
            line-height: 14px;
            font-size: 12px;
            margin-top: 6px;
            margin-bottom: 0;
        }
        .goods-info-group p {
            margin-bottom: 10px;
        }

        .form-horizontal.fm-goods-info label,
        .form-horizontal.fm-goods-info input,
        .form-horizontal.fm-goods-info button,
        .form-horizontal.fm-goods-info select,
        .form-horizontal.fm-goods-info textarea {
            font-size: 12px !important;
        }

        .close-modal.small {
            top: -8px;
            right: -8px;
            width: 18px;
            height: 18px;
            font-size: 14px;
            line-height: 16px;
            border-radius: 9px;
        }
        .close-modal {
            position: absolute;
            z-index: 2;
            top: -9px;
            right: -9px;
            width: 20px;
            height: 20px;
            font-size: 16px;
            line-height: 18px;
            color: #fff;
            text-align: center;
            cursor: pointer;
            background: rgba(153,153,153,0.6);
            border-radius: 10px;
        }
        .sku-atom, .sku-atom .upload-img-wrap {
            width: 90px;
        }
    </style>
@endsection

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li><span class="text-muted">产品管理</span></li>
        <li class="active"><span class="text-muted">{{ $item->name ?? '新增产品' }}</span></li>
    </ul>
    <div class="wrapper center-block" style="background-color: white;">
        <form class="form-validation form-horizontal form-sm fm-goods-info" action="{{ route('venue-store') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $item->id or 0 }}">
            <div class="tab-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="" class="ng-binding">1. 选择商品品类</a>
                    </li>
                    <li disabled="disabled" active="steps.step2" select="steps.percent=30" class="ng-scope ng-isolate-scope disabled">
                        <a href="" class="ng-binding">2. 编辑基本信息</a>
                    </li>
                    <li disabled="disabled" active="steps.step3" select="steps.percent=60" class="ng-scope ng-isolate-scope disabled">
                        <a href="" class="ng-binding">3. 编辑商品详情</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="wrapper-md text-center" style="padding-bottom: 0px;">
                            <div class="row">
                            @foreach($tops as $row)
                                <div class="col-sm-3">
                                    <div class="panel wrapper-md bg-light lter category">
                                        {{ $row->name }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="panel wrapper-md bg-light lter category">
                                        {{ $row->name }}
                                    </div>
                                </div>

                            @endforeach
                            </div>
                            <div class="m-t m-b">
                                <button type="submit" class="btn btn-info btn-sm" disabled="disabled">下一步</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active">
                        <div class="hbox bg-light lter goods-info-group">
                            <div class="col text-center b-r b-white info-group-title" style="width: 106px;">
                                <div class="group-inner">基本信息</div>
                            </div>
                            <div class="col b-l b-l b-white info-group-cont">
                                <div class="group-inner">
                                    <div class="control-group">
                                        <label class="control-label">商品类目：</label>
                                        <div class="controls">
                                            <div class="static-value">食品</div>
                                            <input type="hidden" name="class_1">
                                            <input type="hidden" name="goods_class">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">购买方式：</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                                <input type="radio" name="shop_method" value="1" checked="">在有赞购买
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="shop_method" value="0">链接到外部购买
                                                <span class="js-outbuy-tip hide">(每家店铺仅支持50个外部购买商品)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">商品分组：</label>
                                        <div class="controls">
                                            <select ui-jq="chosen" multiple name="tag" data-placeholder="选择商品分组" style="width: 220px;    height: 30px;">
                                                <option value="74060531">列表中隐藏</option>
                                            </select>
                                            <p class="inline m-t-xxs m-b-n">
                                                <a class="text-info">刷新</a>
                                                <span>|</span>
                                                <a class="text-info">新建分组</a>
                                                <span>|</span>
                                                <a class="text-info">帮助</a>
                                            </p>
                                            <p class="help-desc js-tag-desc hide">
                                                使用“列表中隐藏”分组，商品将不出现在商品列表中
                                            </p>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">商品类型：</label>
                                        <div class="controls">


                                            <label class="radio inline">
                                                <input type="radio" name="shipment" value="0" checked="">实物商品
                                                <span class="gray">（物流发货）</span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="shipment" value="2">虚拟商品
                                                <span class="gray">（无需物流）</span>
                                            </label>
                                            <label class="radio inline">
                                                <input type="radio" name="shipment" value="3">电子卡券
                                                <span class="gray">（无需物流）</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="js-electric-card" style="display: none;">
                                        <div class="control-group">
                                            <label class="control-label">商品有效期：<br><span class="gray">(发布后不能修改) </span></label>
                                            <div class="controls">
                                                <label class="radio inline has-input">
                                                    <input type="radio" name="valid_period" value="0" checked="">长期有效
                                                </label>
                                                <label class="radio inline has-input">
                                                    <input type="radio" name="valid_period" value="1">自定义有效期
                                                </label>
                                                <div class="js-valid-period valid-period" style="display: none;">
                                                    <div class="input-append">
                                                        <input type="text" class="input-small hasDatepicker" id="item_validity_start" name="item_validity_start" value="" readonly="">
                                                        <label for="item_validity_start" class="add-on">
                                                            <i class="icon-calendar"></i>
                                                        </label>
                                                    </div>
                                                    至
                                                    <div class="input-append">
                                                        <input type="text" class="input-small hasDatepicker" id="item_validity_end" name="item_validity_end" value="" readonly="">
                                                        <label for="item_validity_end" class="add-on">
                                                            <i class="icon-calendar"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">预售设置：</label>
                                        <div class="controls">
                                            <label class="checkbox inline ">
                                                <input type="checkbox" name="pre_sale" value="1">预售商品
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group js-pre-sale-item" style="margin-left: 86px; display: none;">
                                        <label class="control-label"><em class="required">*</em>发货时间：</label>
                                        <div class="controls">
                                            <label class="radio inline">
                                            <span class="input-append">
                                                <input class="etd-type" type="radio" name="etd_type" value="0" checked="">
                                                <input type="text" class="input-small hasDatepicker" id="etd_start" name="etd_start" value="" placeholder="请选择时间"><label for="etd_start" class="add-on">
                                                    <i class="icon-calendar"></i>
                                                </label>
                                            </span>
                                                开始发货
                                            </label>

                                            <label class="radio inline">
                                                <input class="etd-type" type="radio" name="etd_type" value="1">
                                                付款成功
                                                <input name="etd_days" class="input-tiny" type="number" min="1" max="90" value="">
                                                天后发货
                                            </label>
                                        </div>
                                    </div>
                                    <div class="c-gray ui-box js-pre-sale-item" style="margin-left: 114px; display: none;">
                                        注意：只允许设置90天内的发货时间 ，请务必按照约定时间发货以免引起客户投诉。
                                        <a href="https://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=593751" target="_blank" class="new-window">帮助</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hbox bg-light lter m-t-xs goods-info-group">
                            <div class="col text-center b-r b-white info-group-title" style="width: 106px;">
                                <div class="group-inner">库存/规格</div>
                            </div>
                            <div class="col b-l b-l b-white info-group-cont">
                                <div class="group-inner">

                                    <div class="js-goods-sku control-group">
                                        <label class="js-goods-sku-control-label control-label">商品规格：</label>
                                        <div id="sku-region" class="controls">
                                            <div class="sku-group">
                                                <div class="js-sku-list-container">
                                                    <div class="sku-sub-group">
                                                        <h3 class="sku-group-title">
                                                            <div class="select2-container js-sku-name"
                                                                 id="s2id_autogen5" style="width: 100px;">
                                                                <a href="javascript:void(0)" onclick="return false;" class="select2-choice"
                                                                        tabindex="-1">
                                                                    <span class="select2-chosen">尺寸</span>
                                                                    <abbr class="select2-search-choice-close"></abbr>
                                                                    <span class="select2-arrow">
                                                                        <b></b>
                                                                    </span>
                                                                </a>
                                                                <input class="select2-focusser select2-offscreen"
                                                                        type="text" id="s2id_autogen6">
                                                            </div>
                                                            <input type="hidden" name="sku_name" value="2"
                                                                   class="js-sku-name select2-offscreen" tabindex="-1">
                                                            <label for="js-addImg-function" class="addImg-radio">
                                                                <input type="checkbox" id="js-addImg-function">
                                                                添加规格图片
                                                            </label>
                                                            <a class="js-remove-sku-group remove-sku-group">×</a>
                                                        </h3>
                                                        <div class="js-sku-atom-container sku-group-cont">
                                                            <div>
                                                                <div class="js-sku-atom-list sku-atom-list">
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="432">1</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="433">2</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="434">3</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="1265">4</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="783">5</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="189">6</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="1205">7</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom active"><span
                                                                                data-atom-id="1207">8</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap ">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <a href="javascript:;" class="js-add-sku-atom add-sku"
                                                                   style="display: inline-block;">+添加</a>


                                                            </div>
                                                        </div>

                                                        <div class="sku-group-cont" id="js-tip-instruction"
                                                             style="padding: 0px 10px; display: block;">
                                                            <p class="help-desc">目前只支持为第一个规格设置不同的规格图片</p>
                                                            <p class="help-desc">设置后，用户选择不同规格会显示不同图片</p>
                                                            <p class="help-desc">建议尺寸：640 x 640像素</p>
                                                        </div>

                                                    </div>
                                                    <div class="sku-sub-group">
                                                        <h3 class="sku-group-title">
                                                            <div class="select2-container js-sku-name"
                                                                 id="s2id_autogen7" style="width: 100px;"><a
                                                                        href="javascript:void(0)"
                                                                        onclick="return false;" class="select2-choice"
                                                                        tabindex="-1"> <span
                                                                            class="select2-chosen">颜色</span><abbr
                                                                            class="select2-search-choice-close"></abbr>
                                                                    <span class="select2-arrow"><b></b></span></a><input
                                                                        class="select2-focusser select2-offscreen"
                                                                        type="text" id="s2id_autogen8"></div>
                                                            <input type="hidden" name="sku_name" value="1"
                                                                   class="js-sku-name select2-offscreen" tabindex="-1">


                                                            <a class="js-remove-sku-group remove-sku-group">×</a>

                                                        </h3>
                                                        <div class="js-sku-atom-container sku-group-cont">
                                                            <div>
                                                                <div class="js-sku-atom-list sku-atom-list">
                                                                    <div class="sku-atom"><span
                                                                                data-atom-id="2466">B</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap hide">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom"><span
                                                                                data-atom-id="3014">C</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap hide">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="sku-atom"><span
                                                                                data-atom-id="7161">D</span>

                                                                        <div class="atom-close close-modal small js-remove-sku-atom">
                                                                            ×
                                                                        </div>


                                                                        <div class="upload-img-wrap hide">
                                                                            <div class="arrow"></div>
                                                                            <div class="js-upload-container"
                                                                                 style="position:relative;">

                                                                                <div class="add-image js-btn-add">+
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <a href="javascript:;" class="js-add-sku-atom add-sku"
                                                                   style="display: inline-block;">+添加</a>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="js-sku-group-opts sku-sub-group" style="display: block;">
                                                    <h3 class="sku-group-title">
                                                        <button type="button" class="js-add-sku-group btn">添加规格项目
                                                        </button>

                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="help-desc hotel-sku-help" style="margin-left: 116px;display: none;">
                                            酒店类商品暂只支持1种规格项</p>
                                    </div>


                                    <div class="js-goods-stock control-group" style="display: block;">
                                        <label class="js-goods-stock-control-label control-label">商品库存：</label>
                                        <div id="stock-region" class="controls sku-stock">
                                            <table class="table-sku-stock">
                                                <thead>
                                                <tr>

                                                    <th class="text-center">尺寸</th>

                                                    <th class="text-center">颜色</th>

                                                    <th class="th-price">价格（元）</th>

                                                    <th class="th-stock">库存</th>
                                                    <th class="th-code">商家编码</th>
                                                    <th class="text-cost-price">成本价</th>

                                                    <th class="text-right">销量</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td data-atom-id="432" rowspan="3">1</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="433" rowspan="3">2</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="434" rowspan="3">3</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="1265" rowspan="3">4</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="783" rowspan="3">5</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="189" rowspan="3">6</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="1205" rowspan="3">7</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="1207" rowspan="3">8</td>
                                                    <td data-atom-id="2466" rowspan="1">B</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="3014" rowspan="1">C</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>

                                                    <td class="text-right">0</td>
                                                </tr>
                                                <tr>
                                                    <td data-atom-id="7161" rowspan="1">D</td>
                                                    <td>
                                                        <input data-stock-id="0" type="text" name="sku_price"
                                                               class="js-price input-mini" value="" maxlength="10">
                                                    </td>

                                                    <td>
                                                        <div class="popover-hover">
                                                            <input type="text" name="stock_num"
                                                                   class="js-stock-num input-mini" value=""
                                                                   maxlength="9">

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="code" class="js-code input-small"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cost_price"
                                                               class="js-cost-price input-small" value="">
                                                    </td>
                                                    <td class="text-right">0</td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="batch-opts">
                                                            批量设置：
                                                            <span class="js-batch-type">
                                                                <a class="js-batch-price" href="javascript:;">价格</a>
                                                                &nbsp;&nbsp;
                                                                <a class="js-batch-stock" href="javascript:;">库存</a>
                                                            </span>
                                                            <span class="js-batch-form" style="display: none;">
                                                                <input type="text" class="js-batch-txt input-mini" placeholder="">
                                                                <a class="js-batch-save" href="javascript:;">保存</a>
                                                                <a class="js-batch-cancel" href="javascript:;">取消</a>
                                                                <p class="help-desc"></p>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label"><em class="required">*</em>总库存：</label>
                                        <div class="controls">
                                            <div class="popover-hover">
                                                <input type="text" maxlength="9" class="form-control input-sm"
                                                       name="total_stock" value="0" readonly="">
                                            </div>
                                            <label class="checkbox inline">
                                                <input type="checkbox" name="hide_stock" value="0">页面不显示商品库存
                                            </label>

                                            <p class="help-desc help-desc-0">总库存为 0 时，会上架到『已售罄的商品』列表里</p>
                                            <p class="help-desc help-desc-1">发布后商品同步更新，以库存数字为准</p>

                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">商家编码：</label>
                                        <div class="controls">
                                            <input type="text" class="form-control input-sm inline" name="goods_no"
                                                   value="" style="width: 130px;">
                                            <a href="javascript:;" class="js-help-notes circle-help">?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hbox bg-light lter m-t-xs goods-info-group">
                            <div class="col text-center b-r b-white info-group-title" style="width: 106px;">
                                <div class="group-inner">商品信息</div>
                            </div>
                            <div class="col b-l b-l b-white info-group-cont">
                                <div class="group-inner">
                                    <div class="control-group">
                                        <label class="control-label">
                                            <em class="required">*</em>商品名：
                                        </label>
                                        <div class="controls">
                                            <input type="text" name="title" value="" maxlength="100" class="form-control inline input-sm" style="width: 330px;">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label"><em class="required">*</em>价格：</label>
                                        <div class="controls">
                                            <div class="input-group input-group-sm form-inline" style="width: 130px;float: left;">
                                                <span class="input-group-addon">￥</span>
                                                <input type="text" maxlength="10" name="price" value="0.00" class="form-control">
                                            </div>
                                            <input type="text" placeholder="原价：¥99.99" name="origin" value="" class="form-control inline input-sm m-l-xs" style="width: 104px;">
                                            <input type="text" placeholder="成本价：￥9.9" name="cost_price" value="" class="form-control inline input-sm" style="width: 104px;">


                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label"><em class="required">*</em>商品图：</label>
                                        <div class="controls">
                                            <input type="hidden" name="picture">
                                            <div class="picture-list ui-sortable">
                                                <ul class="js-picture-list app-image-list clearfix">

                                                    <li class="sort">
                                                        <img src="https://img.yzcdn.cn/upload_files/2015/05/14/Fq9Xi4vSuS8D804oC_1CD04sb8uA.png?imageView2/2/w/100/h/100/q/75/format/webp" data-src="https://img.yzcdn.cn/upload_files/2015/05/14/Fq9Xi4vSuS8D804oC_1CD04sb8uA.png" class="js-img-preview">

                                                        <a class="js-delete-picture close-modal small hide">×</a>

                                                    </li>


                                                    <li class="sort">
                                                        <img src="https://img.yzcdn.cn/upload_files/2015/05/14/FlWbchx5Djd0WJcQhWS95tvSBNGJ.png?imageView2/2/w/100/h/100/q/75/format/webp" data-src="https://img.yzcdn.cn/upload_files/2015/05/14/FlWbchx5Djd0WJcQhWS95tvSBNGJ.png" class="js-img-preview">

                                                        <a class="js-delete-picture close-modal small hide">×</a>

                                                    </li>


                                                    <li class="sort">
                                                        <img src="https://img.yzcdn.cn/upload_files/2015/05/14/FrfWhZ2NUN7oFwXoQCpujjjmiRBF.png?imageView2/2/w/100/h/100/q/75/format/webp" data-src="https://img.yzcdn.cn/upload_files/2015/05/14/FrfWhZ2NUN7oFwXoQCpujjjmiRBF.png" class="js-img-preview">

                                                        <a class="js-delete-picture close-modal small hide">×</a>

                                                    </li>


                                                    <li>
                                                        <a href="javascript:;" class="add-goods js-add-picture">+加图</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p class="help-desc">建议尺寸：640 x 640 像素；你可以拖拽图片调整图片顺序。</p>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">主图视频：</label>
                                        <div class="controls">
                                            <div class="js-video-list">

                                                <div class="video-edit-wrap">

                                                    <a href="javascript:;" class="add-video js-add-video">+</a>
                                                    <p class="help-desc">目前仅支持在微信中播放，建议时长9-30秒，建议视频宽高比16:9</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="js-buy-url-group control-group hide">
                                        <label class="control-label"><em class="required">*</em>外部购买地址：</label>
                                        <div class="controls">
                                            <input type="text" name="buy_url" value="" class="input-xxlarge js-buy-url">
                                            <a style="display: none;" href="javascript:;" class="js-help-notes circle-help">?</a>
                                        </div>
                                    </div>

                                    <div class="js-electric-card-info" style="display: none;">
                                        <div class="control-group">
                                            <label class="control-label"><em class="required">*</em>电子凭证<br>生效时间:<br><span class="gray">(买家支付成功后) </span></label>
                                            <div class="controls">
                                                <label class="radio inline has-input">
                                                    <input type="radio" name="effective_type" value="0" checked="">
                                                    立即生效
                                                </label>
                                                <label class="radio inline has-input">
                                                    <input type="radio" name="effective_type" value="1">
                                                    <input type="number" class="input-tiny" name="effective_delay_hours" value="">
                                                    小时后生效
                                                </label>
                                                <label class="radio inline has-input">
                                                    <input type="radio" name="effective_type" value="2">
                                                    次日生效
                                                </label>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">节假日是否可用：</label>
                                            <div class="controls">
                                                <label class="radio inline">
                                                    <input type="radio" name="holidays_available" value="1" checked="">
                                                    是
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" name="holidays_available" value="0">
                                                    否
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-t m-b text-center">
                            <button type="submit" class="btn btn-info btn-sm" disabled="disabled">下一步</button>
                        </div>
                    </div>
                    <div class="tab-pane active">
                        <textarea id="descBox" name="description" ui-editor
                                  class="form-control" rows="12">{{ $item->description or '' }}</textarea>
                        <div class="m-t m-b text-center">
                            <button type="submit" class="btn btn-success btn-sm" disabled="disabled">提&nbsp;&nbsp;&nbsp;&nbsp;交</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $('.panel.category').click(function () {
                console.log($(this).text());
            })
        });
    </script>
@stop