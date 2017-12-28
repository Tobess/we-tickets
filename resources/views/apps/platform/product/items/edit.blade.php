@extends('layouts.content')

@section('head')
    <style>
        .hoe-input,
        .hoe-input[type=color],
        .hoe-input[type=date],
        .hoe-input[type=datetime],
        .hoe-input[type=email],
        .hoe-input[type=month],
        .hoe-input[type=number],
        .hoe-input[type=password],
        .hoe-input[type=search],
        .hoe-input[type=tel],
        .hoe-input[type=text],
        .hoe-input[type=time],
        .hoe-input[type=url],
        .hoe-input[type=week],
        .zent-textarea {
            display: inline-block;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            -webkit-flex: 1;
            -moz-box-flex: 1;
            flex: 1;
            min-width: 80px;
            height: 100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0 10px;
            margin: 0;
            border: 1px solid #bbb;
            color: #333;
            font-size: 12px;
            border-radius: 2px;
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-transition: border .2s ease-in-out,-webkit-box-shadow .2s ease-in-out;
            transition: border .2s ease-in-out,-webkit-box-shadow .2s ease-in-out;
            -moz-transition: border .2s ease-in-out,box-shadow .2s ease-in-out;
            transition: border .2s ease-in-out,box-shadow .2s ease-in-out;
            transition: border .2s ease-in-out,box-shadow .2s ease-in-out,-webkit-box-shadow .2s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .hoe-input-addon-after,
        .hoe-input-addon-before {
            display: inline-block;
            height: 100%;
            padding: 0 5px;
            border: 1px solid #bbb;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            vertical-align: middle;
            background-color: #e5e5e5;
            font-size: 12px;
        }
        .hoe-input-addon-before {
            border-top-left-radius: 2px;
            border-bottom-left-radius: 2px;
            border-right: none;
        }
        .hoe-input-addon-after {
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            border-left: none;
        }
        .hoe-input-addons>.hoe-input {
            border-radius: 0;
        }
        .hoe-input-addons>.hoe-input:last-child {
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
        }

        /*商品编辑块头部*/
        .goods-block-head {
            background-color: #f8f8f8;
            font-size: 14px;
            font-weight: 700;
        }
        /*商品编辑块头部标题*/
        .goods-block-cont-title {
            padding: 10px;
        }
        /*商品编辑块内容容器*/
        .goods-block-cont-inner {
            padding: 10px 0px;
        }
        /*商品编辑控件分组*/
        .form-control-group {
            margin-bottom: 20px;
            font-size: 12px;
        }
        .form-control-label {
            width: 100px;
        }
        .form-control-group.no-label .form-control-label{
            display: none!important;
        }
        .form-control-controls {
            margin-left: 10px;
        }
        .form-control-group.no-label .form-control-controls {
            margin-left: 0!important;
        }
        .input-xxlarge {
            width: 460px;
        }
        .input-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: -moz-box;
            display: flex;
            position: relative;
            height: 30px;
            max-height: 36px;
            line-height: 28px;
        }
        .form-required {
            margin-right: 6px;
            font-size: 16px;
            color: #e33;
            vertical-align: middle;
        }
        .help-block {
            line-height: 14px;
            font-size: 12px;
            margin-top: 6px;
            margin-bottom: 0;
            color: #999;
        }
        .form-info-error-desc,
        .form-info-help-block,
        .form-info-help-desc,
        .form-info-notice-desc {
            line-height: 14px;
            font-size: 12px;
            margin-top: 10px;
            margin-bottom: 0;
            color: #999;
        }


        .form-horizontal .form-control-label {
            display: inline-block;
            width: 120px;
            font-size: 12px;
            line-height: 30px;
            text-align: right;
            vertical-align: top;
        }
        .form-horizontal .form-control-controls {
            display: inline-block;
            word-break: break-all;
            vertical-align: top;
        }

        /*可折叠*/
        .fold-field {
            font-size: 12px;
            cursor: pointer;
        }
        .fold-field-icon {
            display: inline-block;
            speak: none;
            font-style: normal;
            vertical-align: baseline;
            text-align: center;
            text-transform: none;
            font-variant: normal;
            text-rendering: auto;
            text-decoration: inherit;
            line-height: 1;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-transform: scale(.6);
            -moz-transform: scale(.6);
            -ms-transform: scale(.6);
            transform: scale(.6);
            margin-left: -2px;
        }
        .fold-field-icon:before {
            content: "\f04b";
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            display: block;
            font: normal normal normal 14px/1 FontAwesome;
            margin-bottom: 4px;
            font-size: 15px;
            font-weight: 500;
        }
        .fold-field-icon.is-close {
            -webkit-transform: scale(.6) rotate(90deg);
            -moz-transform: scale(.6) rotate(90deg);
            -ms-transform: scale(.6) rotate(90deg);
            transform: scale(.6) rotate(90deg);
        }
        .fold-field-icon.is-close:before {
            margin-bottom: 3px;
        }
        .fold-field-txt {
            color: #38f;
            margin-left: 3px;
        }

        /*checkbox控件*/
        .hoe-checkbox-wrap {
            display: inline-block;
            cursor: pointer;
            font-weight: 400;
            font-size: 12px;
            margin: 0;
            padding: 0;
            margin-right: 15px;
            vertical-align: middle;
            line-height: 28px;
            color: #333;
        }
        .hoe-checkbox-wrap:last-child {
            margin-right: 0;
        }
        .hoe-checkbox {
            position: relative;
            display: inline-block;
            width: 14px;
            height: 14px;
            white-space: nowrap;
            outline: none;
            vertical-align: middle;
            line-height: 1;
            margin: 0;
            padding: 0;
        }
        .hoe-checkbox input {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0;
            cursor: pointer;
        }
        .hoe-checkbox+span {
            margin-left: 5px;
            margin-right: 5px;
            vertical-align: middle;
            line-height: 16px;
        }
        .hoe-checkbox-inner {
            position: relative;
            top: 0;
            left: 0;
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 2px;
            border: 1px solid #bbb;
            background: #fff;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            transition: all .3s;
        }
        .hoe-checkbox-inner:after {
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            position: absolute;
            display: block;
            content: " ";
            font-size: 0;
            top: 3px;
            left: 2px;
            width: 6px;
            height: 3px;
            border: 2px solid #fff;
            background: transparent;
            border-top: none;
            border-right: none;
            -webkit-transform: rotate(-45deg) scale(0);
            -moz-transform: rotate(-45deg) scale(0);
            -ms-transform: rotate(-45deg) scale(0);
            transform: rotate(-45deg) scale(0);
            -webkit-transition: all .12s ease-in-out;
            -moz-transition: all .12s ease-in-out;
            transition: all .12s ease-in-out;
        }
        .hoe-checkbox-wrap.checked .hoe-checkbox-inner {
            border-color: #27f;
            background: #38f;
        }
        .hoe-checkbox-wrap.checked .hoe-checkbox-inner:after {
            -webkit-transform: rotate(-45deg) scale(1);
            -moz-transform: rotate(-45deg) scale(1);
            -ms-transform: rotate(-45deg) scale(1);
            transform: rotate(-45deg) scale(1);
        }

        /*datetime*/
        .hoe-datetime-picker {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            display: inline-block;
            line-height: normal;
            position: relative;
        }
        .sold-time-field .hoe-datetime-picker {
            margin-left: 10px;
        }
        .hoe-datetime-picker .picker-input {
            color: #999;
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            width: 183px;
            height: 30px;
            line-height: 30px;
            font-size: 12px;
            background: #fff;
            border-radius: 2px;
            padding: 0 10px;
        }
        .hoe-datetime-picker .picker-input-filled {
            color: #333;
        }
        .hoe-input-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: -moz-box;
            display: flex;
            position: relative;
            height: 30px;
            max-height: 36px;
            line-height: 28px;
            width: 173px;
        }
        .hoe-datetime-picker .picker-input .hoe-input {
            background: inherit;
            color: inherit;
        }
        
        /*pick icon*/
        .hoeicon {
            display: inline-block;
            speak: none;
            font-style: normal;
            vertical-align: baseline;
            text-align: center;
            text-transform: none;
            font-variant: normal;
            text-rendering: auto;
            text-decoration: inherit;
            line-height: 1;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .hoeicon:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            display: block;
            font-family: 'Simple-Line-Icons';
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            -webkit-font-smoothing: antialiased;
        }
        .hoeicon-calendar-o:before {
            content: "\e075";
        }
        .hoe-datetime-picker .picker-input .hoeicon {
            line-height: 30px;
            position: absolute;
            right: 10px;
            top: 0;
            color: #bbb;
        }
        .hoe-datetime-picker .picker-input .hoeicon-calendar-o {
            display: block;
        }

        /*pick clear icon*/
        .hoeicon-close-circle:before {
            content: "\e082";
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            display: block;
            font-family: 'Simple-Line-Icons';
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            -webkit-font-smoothing: antialiased;
        }
        .hoe-datetime-picker .picker-input .hoeicon {
            line-height: 30px;
            position: absolute;
            right: 10px;
            top: 0;
            color: #bbb;
        }
        .hoe-datetime-picker .picker-input .hoeicon-close-circle {
            display: none;
        }
        .hoe-datetime-picker .picker-input-filled:hover .hoeicon-close-circle{
            display:block
        }
        .hoe-datetime-picker .picker-input-filled:hover .hoeicon-calendar-o{
            display:none;
        }

        /*footer*/
        .app-design {
            min-width: 880px;
            width: 880px;
            margin: 0 auto;
            position: relative;
        }

        .app-design .app-actions {
            position: fixed;
            bottom: 0;
            z-index: 10;
            left: 210px;
            right: 210px!important;
            width: auto;
            min-width: 880px;
            -webkit-transition: right .5s;
            -moz-transition: right .5s;
            transition: right .5s;
        }

        .app-actions .form-actions {
            text-align: center;
            margin: 0;
            background: #ffc;
            padding: 10px;
            border-top: none;
        }
        .app-footer {
            display: none;
        }
    </style>
@endsection

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li><span class="text-muted">产品管理</span></li>
        <li class="active"><span class="text-muted">{{ $item->name ?? '新增产品' }}</span></li>
    </ul>
    <div class="padder padder-v m-l-sm m-b-sm m-r-sm center-block bg-white" style="max-width: 880px;">
        <div class="bc-steps">
            <div class="step-item active">
                <div class="item-cont">1. 编辑基本信息</div>
            </div>
            <div class="step-item">
                <div class="item-cont">2. 编辑商品详情</div>
            </div>
        </div>
        <div>
            <form class="form-horizontal">
                <div class="block">
                    <div class="block">
                        <div class="goods-block-head">
                            <div class="goods-block-cont-title">商品类型</div>
                        </div>
                        <div class="block">
                            <div class="goods-block-cont-inner">
                                <div class="form-control-group no-label">
                                    <label class="form-control-label"></label>
                                    <div class="form-control-controls">
                                        <div class="hoe-radio-group grid-radio">
                                            <label class="hoe-radio-wrap checked">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span>
                                                    <span class="radio-name">实物商品</span>
                                                    <span class="radio-desc">（物流发货）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span>
                                                    <span class="radio-name">虚拟商品</span>
                                                    <span class="radio-desc">（无需物流）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span>
                                                    <span class="radio-name">电子卡券</span>
                                                    <span class="radio-desc">（无需物流）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span>
                                                    <span class="radio-name">酒店商品</span>
                                                    <span class="radio-desc">（无需物流）</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block">
                        <div class="goods-block-head">
                            <div class="goods-block-cont-title">基本信息</div>
                        </div>
                        <div class="block">
                            <div class="goods-block-cont-inner">
                                <div class="form-control-group">
                                    <label class="form-control-label"><em class="form-required">*</em>商品名：</label>
                                    <div class="form-control-controls">
                                        <span>
                                            <div class="input-wrapper input-xxlarge">
                                                <input type="text" class="hoe-input" value="">
                                            </div>
                                        </span>
                                        <p class="form-info-error-desc">商品名称必须填写，最多100个字</p>
                                    </div>
                                </div>
                                <div class="form-control-group">
                                    <label class="form-control-label">分享描述：</label>
                                    <div class="form-control-controls">
                                        <span>
                                            <div class="input-wrapper input-xxlarge">
                                                <input type="text" class="hoe-input" value="">
                                            </div>
                                            <p class="help-block">微信分享给好友时会显示，建议36个字以内</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-control-group has-error upload-field">
                                    <label class="form-control-label"><em class="form-required">*</em>商品图：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <ul class="app-image-list clearfix">
                                                <li class="">
                                                    <div class="rc-upload">
                                                        <div class="">
                                                            <a class="add-goods" href="javascript:;">+添加图片</a>
                                                        </div>
                                                        <p class="rc-upload-tips"></p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="help-block">建议尺寸：800*800像素，你可以拖拽图片调整顺序，最多上传15张</p>
                                        </div>
                                        <p class="form-info-error-desc">最少需要添加一张商品图</p>
                                    </div>
                                </div>
                                <div class="form-control-group no-label">
                                    <label class="form-control-label"></label>
                                    <div class="form-control-controls">
                                        <div class="fold-field">
                                            <i class="fold-field-icon is-close"></i>
                                            <span class="fold-field-txt">更多设置</span>
                                        </div>
                                     </div>
                                </div>
                                <div class="form-control-group">
                                    <label class="form-control-label">商品类目：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <div class="zent-popover-wrapper zent-select select-large" style="display: inline-block;">
                                                <div class="zent-select-text">选择所属行业类目</div>
                                            </div>
                                            <p class="help-block">商品类目及类目细项，<a href="http://kdt.im/RL72Svr1m" target="_blank" rel="noopener noreferrer" class="new-window">点此查看</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group">
                                    <label class="form-control-label">商品分组：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <div class="zent-popover-wrapper zent-select select-large" style="display: inline-block;">
                                                <div class="zent-select-tags">选择商品分组</div>
                                            </div>
                                            <p class="help-inline">
                                                <a href="javascript:;">刷新</a>
                                                <span> | </span>
                                                <a class="new-window" target="_blank" rel="noopener noreferrer" href="//www.youzan.com/v2/showcase/tag#create">新建分组</a>
                                                <span> | </span>
                                                <a class="new-window" target="_blank" rel="noopener noreferrer" href="https://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=15">如何创建商品分组？</a>
                                            </p>
                                            <p class="help-block hide">使用“列表中隐藏”分组，商品将不出现在商品列表中</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group upload-field">
                                    <label class="form-control-label">主图视频：</label>
                                    <div class="form-control-controls">
                                        <div class="video-edit-wrap">
                                            <div>
                                                <a href="javascript:;" class="add-video">+ 添加视频</a>
                                                <p class="help-block">目前仅支持在微信中播放，建议时长9-30秒，建议视频宽高比16:9</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block">
                        <div class="goods-block-head">
                            <div class="goods-block-cont-title">价格库存</div>
                        </div>
                        <div class="block">
                            <div class="goods-block-cont-inner">
                                <div class="form-control-group sku-field">
                                    <label class="form-control-label">商品规格：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <div class="rc-sku">
                                                <div>
                                                    <div class="rc-sku-group">
                                                        <h3 class="group-title">
                                                            <button type="button" class="zent-btn">添加规格项目</button>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="help-block">如有颜色、尺码等多种规格，请添加商品规格</p></div>
                                        </div>
                                </div>
                                <div class="form-control-group stock-field hide"><label
                                            class="form-control-label">规格明细：
                                        </label>
                                    <div class="form-control-controls">
                                        <div class="table-sku-wrap"></div>
                                        </div>
                                </div>
                                <div class="form-control-group "><label class="form-control-label"><em
                                                class="form-required">*</em>价格：
                                        </label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small"><div class="zent-number-input-wrapper"><div
                                                            class="input-wrapper hoe-input-addons"><span
                                                                class="hoe-input-addon-before">¥</span><input
                                                                type="text" class="hoe-input" value="1.00"></div></div></span>
                                        </div>
                                        </div>
                                </div>
                                <div class="form-control-group "><label class="form-control-label">
                                        划线价：</label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small" style="margin-left: 0px;"><div
                                                        class="input-wrapper"><input type="text" class="hoe-input"
                                                                                          value=""></div></span>
                                            <div class="help-block">商品没有优惠的情况下，划线价在商品详情会以划线形式显示。
                                                
                                                <div class="zent-popover-wrapper zent-pop-wrapper"
                                                     style="display: inline-block;"><a href="javascript:;">示例</a>
                                                    </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                                <div class="form-control-group total-stock-field"><label
                                            class="form-control-label"><em class="form-required">*</em>
                                        库存：</label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small"><div class="zent-number-input-wrapper"><div
                                                            class="input-wrapper"><input type="text"
                                                                                              class="hoe-input"
                                                                                              name="total_stock"
                                                                                              value="999999"></div></div></span>
                                            <div><label class="show-stock-checkbox zent-checkbox-wrap"><span
                                                            class="zent-checkbox"><span
                                                                class="zent-checkbox-inner"></span><input
                                                                type="checkbox" name="hide_stock"
                                                                value="on"></span><span>商品详情不显示剩余件数</span></label></div>
                                            <p class="help-block">库存为 0 时，会放到『已售罄』的商品列表里，保存后买家看到的商品可售库存同步更新</p></div>
                                        </div>
                                </div>
                                <div class="form-control-group no-label"><label
                                            class="form-control-label">
                                        </label>
                                    <div class="form-control-controls">
                                        <div class="fold-field"><i
                                                    class="hoeicon hoeicon-caret-down fold-field__icon"></i><span
                                                    class="fold-field__txt">折叠更多设置</span></div>
                                        </div>
                                </div>
                                <div class="form-control-group small-field"><label
                                            class="form-control-label">商品编码：
                                        </label>
                                    <div class="form-control-controls">
                                        <div class="input-wrapper"><input type="text" class="hoe-input"
                                                                               name="goods_no" value=""></div>
                                        
                                        </div>
                                </div>
                                <div class="form-control-group "><label class="form-control-label">
                                        成本价：</label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small" style="margin-left: 0px;"><div
                                                        class="zent-number-input-wrapper"><div
                                                            class="input-wrapper hoe-input-addons"><span
                                                                class="hoe-input-addon-before">¥</span><input
                                                                type="text" class="hoe-input"
                                                                value=""></div></div></span>
                                            <p class="help-block">成本价未来会用于营销建议，利润分析等</p></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block">
                        <div class="goods-block-head">
                            <div class="goods-block-cont-title">其他信息</div>
                        </div>
                        <div class="block">
                            <div class="goods-block-cont-inner">
                                <div class="form-control-group weight-field hide">
                                    <label class="form-control-label"><em class="form-required">*</em>物流重量：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <span class="input-small">
                                                <div class="form-control-group stock-item-small-field">
                                                    <label class="form-control-label"></label>
                                                    <div class="form-control-controls">
                                                        <div class="zent-number-input-wrapper">
                                                            <div class="input-wrapper hoe-input-addons">
                                                                <span class="hoe-input-addon-before">Kg</span>
                                                                <input type="text" class="hoe-input" name="_ignore_item_weight" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                            <p class="help-block">当前运费模版，按物流重量（含包装）计费，需要输入重量</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group sold-time-field">
                                    <label class="form-control-label">上架时间：</label>
                                    <div class="form-control-controls">
                                        <div class="hoe-radio-group single-radio">
                                            <label class="hoe-radio-wrap checked">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span><span>立即上架售卖</span></span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span>
                                                    <div class="inline">
                                                        <span>自定义上架时间</span>
                                                        <div class="hoe-datetime-picker">
                                                            <div class="hoe-popover-wrapper" style="display: block;">
                                                                <div class="picker-input"><!--picker-input-filled-->
                                                                    <div class="hoe-input-wrapper">
                                                                        <input type="text" class="hoe-input" value="请选择上架售卖时间">
                                                                    </div>
                                                                    <span class="hoeicon hoeicon-calendar-o"></span>
                                                                    <span class="hoeicon hoeicon-close-circle"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="on">
                                                </span>
                                                <span><span>暂不售卖，放入仓库</span></span>
                                            </label>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-design">
                    <div class="app-actions">
                        <div class="form-actions text-center">
                            <button type="button" class="btn btn-default btn-sm">保存并查看</button>
                            <button type="button" class="btn btn-info btn-sm">下一步</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div style="display: none;"></div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $('.panel.category').click(function () {
                console.log($(this).text());
            });

            // SKU处理事件
            $("#sku-region")
                .on('click', '.sku-group .sku-sub-group .sku-group-title .addImg-radio>input', function () {
                    var $atoms = $(this).closest('.sku-sub-group').find('.sku-atom-list .sku-atom');
                    $(this).is(':checked') ? $atoms.addClass('active') : $atoms.removeClass('active');
                })
        });
    </script>
@stop