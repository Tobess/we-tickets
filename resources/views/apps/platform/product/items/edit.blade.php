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

        /*图片样式*/
        .app-image-list {
            margin: 0px;
            padding: 0px;
            list-style: none;
        }
        .app-image-list li {
            float: left;
            margin: 0 10px 10px 0;
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            background-color: #fff;
            position: relative;
        }
        .app-image-list li img {
            height: 100%;
            width: 100%;
            max-width: 100%;
            vertical-align: middle;
            border: 0;
            -ms-interpolation-mode: bicubic;
            position: relative;
        }
        .app-image-list li a {
            display: block;
            height: 100%;
        }
        .app-image-list li a.close-modal {
            display: none;
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
            background: hsla(0,0%,60%,.6);
            border-radius: 10px;
        }
        .app-image-list li a.close-modal:hover{
            color:#fff;
            background:#000
        }
        .app-image-list li .add-goods {
            display: inline-block;
            width: 100%;
            height: 100%;
            line-height: 80px;
            text-align: center;
            cursor: pointer;
            color: #38f;
        }
        .app-image-list li:hover .close-modal{
            display:block
        }
        .rc-upload-tips {
            line-height: 14px;
            font-size: 12px;
            margin-top: 6px;
            margin-bottom: 0;
            color: #666;
            position: absolute;
        }
        /*视频*/
        .video-edit-wrap .add-video,
        .video-edit-wrap .video-cover {
            display: inline-block;
            width: 80px;
            height: 80px;
            line-height: 80px;
            position: relative;
            text-align: center;
        }
        .video-edit-wrap .add-video {
            border: 1px solid #ddd;
            background: #fff;
        }
        .video-edit-wrap a, .video-edit-wrap a:hover {
            cursor: pointer;
            color: #38f;
        }

        /*SKU*/
        .sku-field:not(.hide) .form-control-controls {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -moz-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }
        .rc-sku {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #e5e5e5;
        }
        .rc-sku-group {
            position: relative;
        }
        .rc-sku-group .group-title {
            position: relative;
            padding: 7px 10px;
            margin: 0;
            background-color: #f8f8f8;
            font-size: 12px;
            line-height: 16px;
            font-weight: 400;
        }
        .hoe-btn {
            display: inline-block;
            height: 30px;
            line-height: 30px;
            padding: 0 10px;
            border-radius: 2px;
            font-size: 12px;
            font-family: inherit;
            color: #333;
            background: #fff;
            border: 1px solid #bbb;
            text-align: center;
            vertical-align: middle;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            cursor: pointer;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            transition: all .3s;
        }
        .hoe-btn:hover {
            border-color: #38f;
            color: #39f;
        }
        /*chosen*/
        .chosen-container-single .chosen-single {
            height: 30px;
            border-color: #bbb;
            font-size: 12px;
        }

        /*--SKU--*/
        .rc-sku-group {
            position: relative
        }

        .rc-sku-group:hover .group-remove {
            display: block
        }

        .rc-sku-group .group-title {
            position: relative;
            padding: 7px 10px;
            margin: 0;
            background-color: #f8f8f8;
            font-size: 12px;
            line-height: 16px;
            font-weight: 400
        }

        .rc-sku-group .group-title .zent-select {
            width: auto
        }

        .rc-sku-group .group-title .zent-select input {
            width: 94px
        }

        .rc-sku-group .group-title__label {
            display: inline-block;
            width: 50px
        }

        .rc-sku-group .group-remove {
            display: none;
            position: absolute;
            top: 12px;
            right: 10px;
            color: #fff;
            text-align: center;
            cursor: pointer;
            width: 18px;
            height: 18px;
            font-size: 14px;
            line-height: 16px;
            background: hsla(0, 0%, 60%, .6);
            border-radius: 10px;
            text-indent: 0
        }

        .rc-sku-group .sku-group-cont {
            padding: 0 10px 0 70px;
            margin-bottom: 15px;
            margin-top: 2px
        }

        .rc-sku-group .sku-group-cont .help-block {
            line-height: 14px;
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 0
        }

        .rc-sku-group .sku-group-cont .help-block ul li {
            font-size: 12px;
            line-height: 12px
        }

        .rc-sku-group .sku-group-cont .help-block:empty {
            margin-top: 0 !important
        }

        .rc-sku-group h4 {
            font-size: 12px;
            font-weight: 700;
            margin: 0
        }

        .rc-sku-group .addImg-radio {
            display: inline-block;
            margin: 3px 0 0 30px
        }

        .rc-sku-group .addImg-radio input {
            vertical-align: 0;
            margin-right: 6px
        }

        .rc-sku-group .group-container {
            padding: 10px 10px 0;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex
        }

        .rc-sku-group .group-container .rc-sku-pop {
            margin: 0
        }

        .rc-sku-group .sku-list {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -moz-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin-left: 5px
        }

        .rc-sku-group .sku-list__label {
            width: 50px;
            padding-top: 10px
        }

        .rc-sku-group .sku-list ul > li {
            float: left;
            width: 20%;
            text-align: left
        }

        .rc-sku-group .sku-list .zent-pop-wrapper {
            margin: 9px 0 0;
            vertical-align: top
        }

        .rc-sku-group .sku-list .zent-pop-wrapper .sku-add {
            margin: 0
        }

        .rc-sku-group .sku-add {
            margin: 9px 0 0 5px;
            color: #38f;
            text-decoration: none
        }

        .rc-sku-group .rc-sku-pop, .rc-sku-group .sku-add {
            display: inline-block;
            vertical-align: top;
            font-size: 12px;
            cursor: pointer
        }

        .rc-sku-group .rc-sku-pop {
            padding: 0 5px;
            margin: 9px 5px 0
        }

        .rc-sku-group .c-color-0 {
            color: #333
        }

        .rc-sku-group .c-color-1 {
            color: #999
        }

        .rc-sku-group .c-color-2 {
            color: #656565
        }

        .rc-sku-group .c-color-3 {
            color: #ac6100
        }

        .rc-sku-group .c-color-4 {
            color: #da0000
        }

        .rc-sku-group .c-color-5 {
            color: #fe6b00
        }

        .rc-sku-group .c-color-6 {
            color: #cdcb00
        }

        .rc-sku-group .c-color-7 {
            color: #bf00cc
        }

        .rc-sku-group .c-color-8 {
            color: #0036d2
        }

        .rc-sku-group .c-color-9 {
            color: #1ea100
        }

        .rc-sku .rc-sku-item {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            margin: 5px 0;
            text-align: center
        }

        .rc-sku .rc-sku-item span {
            display: block;
            width: 74px;
            margin: 0 auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .rc-sku .rc-sku-item .zent-select {
            width: auto
        }

        .rc-sku .rc-sku-item .zent-select input {
            /*width: 152px*/
        }

        .rc-sku .rc-sku-item .item-leaf {
            border: 1px solid #aaa;
            padding: 4px;
            border-radius: 4px;
            width: 100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box
        }

        .rc-sku .rc-sku-item .item-remove {
            display: none;
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
            background: hsla(0, 0%, 60%, .6);
            border-radius: 10px
        }

        .rc-sku .rc-sku-item .item-remove:hover {
            color: #fff;
            background: #000
        }

        .rc-sku .rc-sku-item .item-remove.small {
            top: -6px;
            right: -4px;
            width: 18px;
            height: 18px;
            font-size: 14px;
            line-height: 16px;
            border-radius: 9px
        }

        .rc-sku .rc-sku-item:hover .item-remove {
            display: block
        }

        .rc-sku .rc-sku-item.active {
            margin-bottom: 100px
        }

        .rc-sku .rc-sku-item .upload-img-wrap {
            position: absolute;
            top: 36px;
            left: 0;
            padding: 2px;
            width: 84px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #dcdcdc
        }

        .rc-sku .rc-sku-item .upload-img-wrap img {
            width: 100%;
            height: 100%;
            cursor: pointer
        }

        .rc-sku .rc-sku-item .upload-img-wrap .rc-upload {
            height: 84px
        }

        .rc-sku .rc-sku-item .upload-img-wrap .add-image,
        .rc-sku .rc-sku-item .upload-img-wrap .rc-upload-trigger {
            width: 84px;
            height: 84px;
            line-height: 84px;
            text-align: center;
            background: #fff;
            font-size: 30px;
            color: #e5e5e5;
            cursor: pointer;
            border: 0
        }

        .rc-sku .rc-sku-item .upload-img-wrap .upload-img {
            position: relative;
            width: 84px;
            height: 84px
        }

        .rc-sku .rc-sku-item .upload-img-wrap .upload-img:hover .item-remove {
            display: inline
        }

        .rc-sku .rc-sku-item .upload-img-wrap .upload-img:hover .img-edit {
            display: block
        }

        .rc-sku .rc-sku-item .upload-img-wrap .upload-img .rc-upload {
            position: absolute;
            width: 84px;
            bottom: 0;
            height: 20px
        }

        .rc-sku .rc-sku-item .upload-img-wrap .item-remove {
            top: -8px;
            right: -8px
        }

        .rc-sku .rc-sku-item .upload-img-wrap .arrow {
            position: absolute;
            width: 0;
            height: 0;
            top: -5px;
            left: 44%;
            border-style: solid;
            border-color: transparent;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #000
        }

        .rc-sku .rc-sku-item .upload-img-wrap .arrow:after {
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            top: 0;
            margin-left: -10px;
            border-bottom-color: #fff;
            border-top-width: 0;
            content: ""
        }

        .rc-sku .rc-sku-item .upload-img-wrap .img-edit {
            cursor: pointer;
            display: none;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            color: #fff;
            opacity: .5;
            background: #000
        }

        .zent-select-input {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: 1px solid #bbb;
            border-radius: 2px;
            display: inline-block;
            min-height: 30px;
            max-height: 76px;
            outline: none;
            padding: 5px 10px;
            -webkit-transition: border-color .25s;
            -moz-transition: border-color .25s;
            transition: border-color .25s;
            background-color: #fff;
            position: relative;
            width: 94px;
            font-size: 12px;
        }

        /*---SKU TABLE---*/
        .table-sku-wrap {
            padding: 10px 10px 5px;
            border: 1px solid #e5e5e5
        }

        .table-sku-stock {
            width: 100%;
            background-color: #fff;
            text-align: left;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table-sku-stock th {
            padding: 10px 8px;
            font-weight: 400;
            vertical-align: middle;
        }

        .table-sku-stock th.th-price {
            width: 100px
        }

        .table-sku-stock th.th-stock {
            width: 75px
        }

        .table-sku-stock th.th-code {
            width: 90px
        }

        .table-sku-stock td {
            border: 1px solid #e5e5e5;
            padding: 8px
        }

        .table-sku-stock td:first-of-type {
            border-left: none
        }

        .table-sku-stock td:last-of-type {
            border-right: none
        }

        .table-sku-stock .error-message {
            display: none;
            color: #b94a48
        }
        .zent-form__required {
            margin-right: 6px;
            font-size: 16px;
            color: #e33;
            vertical-align: middle;
        }

        .widget-form__group-row {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -moz-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }
        .zent-input-wrapper {
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
        .input-mini2 {
            width: 120px;
            display: inline-block;
        }
        .input-mini {
            width: 80px;
            display: inline-block;
        }
        .input-mini .hoe-input {
            width: 80px;
        }
        .input-mini2 .hoe-input {
            width: 120px;
        }
    </style>
@endsection

@section('content')
    <ul class="breadcrumb m-b-none">
        <li><span class="text-muted">产品</span></li>
        <li><span class="text-muted">产品管理</span></li>
        <li class="active"><span class="text-muted">{{ $goods->name ?? '新增产品' }}</span></li>
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
        <div class="step-content">
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
                                        <div class="hoe-radio-group grid-radio" hoe-radio="{{ $goods->item_type or 0 }}">
                                            <label class="hoe-radio-wrap checked">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="0" name="item_type">
                                                </span>
                                                <span>
                                                    <span class="radio-name">实物商品</span>
                                                    <span class="radio-desc">（物流发货）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="60" name="item_type">
                                                </span>
                                                <span>
                                                    <span class="radio-name">虚拟商品</span>
                                                    <span class="radio-desc">（无需物流）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="61" name="item_type">
                                                </span>
                                                <span>
                                                    <span class="radio-name">电子卡券</span>
                                                    <span class="radio-desc">（无需物流）</span>
                                                </span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input type="radio" value="35" name="item_type">
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
                                                <input id="gTitle" name="title" type="text" class="hoe-input" value="{{ $goods->name or '' }}">
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
                                                <input id="gDesc" name="desc" type="text" class="hoe-input" value="{{ $goods->desc or '' }}">
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
                                                <li class="image-item" draggable="true" style="opacity: 1;"><img src="https://img.yzcdn.cn/upload_files/2015/05/14/FlWbchx5Djd0WJcQhWS95tvSBNGJ.png?imageView2/2/w/100/h/100/q/75/format/webp" role="presentation" alt=""><a class="close-modal small">×</a></li>
                                                <li class="image-item" draggable="true" style="opacity: 1;"><img src="https://img.yzcdn.cn/upload_files/2015/05/14/FrfWhZ2NUN7oFwXoQCpujjjmiRBF.png?imageView2/2/w/100/h/100/q/75/format/webp" role="presentation" alt=""><a class="close-modal small">×</a></li>
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
                                                <select id="gCategory" name="category_id" class="zent-select-text" ui-jq="chosen"
                                                        data-placeholder="选择所属行业类目">
                                                    @foreach($categories as $group)
                                                        @if(isset($group['children']))
                                                            <optgroup label="{{ $group['name'] }}">
                                                            @foreach($group['children'] as $cate)
                                                                <option value="{{ $cate->id }}" {{ isset($cate->selected) ? 'selected=true' : '' }}>{{ $cate->name }}</option>
                                                            @endforeach
                                                            </optgroup>
                                                        @else
                                                            <option value="{{ $group->id }}" {{ isset($group->selected) ? 'selected=true' : '' }}>{{ $group->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <p class="help-block">商品类目及类目细项，<a href="http://kdt.im/RL72Svr1m" target="_blank" rel="noopener noreferrer" class="new-window">点此查看</a></p>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="form-control-group">--}}
                                    {{--<label class="form-control-label">商品分组：</label>--}}
                                    {{--<div class="form-control-controls">--}}
                                        {{--<div>--}}
                                            {{--<div class="zent-popover-wrapper zent-select select-large" style="display: inline-block;">--}}
                                                {{--<select id="gVenue" id="venue_id" class="zent-select-tags" ui-jq="chosen" data-placeholder="选择商品分组">--}}

                                                {{--</select>--}}
                                            {{--</div>--}}
                                            {{--<p class="help-inline">--}}
                                                {{--<a href="javascript:;">刷新</a>--}}
                                                {{--<span> | </span>--}}
                                                {{--<a class="new-window" target="_blank" rel="noopener noreferrer" href="//www.youzan.com/v2/showcase/tag#create">新建分组</a>--}}
                                                {{--<span> | </span>--}}
                                                {{--<a class="new-window" target="_blank" rel="noopener noreferrer" href="https://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=15">如何创建商品分组？</a>--}}
                                            {{--</p>--}}
                                            {{--<p class="help-block hide">使用“列表中隐藏”分组，商品将不出现在商品列表中</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
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
                                <div class="form-control-group sku-field" id="skuFieldBox">
                                    <label class="form-control-label">商品规格：</label>
                                    <div class="form-control-controls">
                                        <div style="width: 710px;">
                                            <div class="rc-sku">
                                                <div>
                                                    @foreach($skus as $sType => $sItems)
                                                    <div class="rc-sku-group">
                                                        <h3 class="group-title">
                                                            <span class="group-title__label">规格名：</span>
                                                            <div class="zent-popover-wrapper zent-select" style="display: inline-block;">
                                                                <input name="sku_type" type="text" class="zent-select-input" placeholder="请选择" value="{{ $sType }}" maxlength="4">
                                                            </div>
                                                            <label class="zent-checkbox-wrap">
                                                                <span class="zent-checkbox">
                                                                    <span class="zent-checkbox-inner"></span>
                                                                    <input type="checkbox" value="on">
                                                                </span>
                                                                <span>添加规格图片</span>
                                                            </label>
                                                            <span class="group-remove">×</span>
                                                        </h3>
                                                        <div class="group-container">
                                                            <span class="sku-list__label">规格值：</span>
                                                            <div class="sku-list">
                                                                @foreach($sItems as $sVal)
                                                                <div class="rc-sku-item">
                                                                    <div class="zent-popover-wrapper zent-select" style="display: inline-block;">
                                                                        <input type="text" class="zent-select-input" placeholder="请选择" maxlength="20" value="{{ $sVal }}">
                                                                    </div>
                                                                    <span class="item-remove small">×</span>
                                                                </div>
                                                                @endforeach
                                                                <span class="sku-add">添加规格值</span>
                                                            </div>
                                                        </div>
                                                        <div class="sku-group-cont"></div>
                                                    </div>
                                                    @endforeach
                                                    <div class="rc-sku-group">
                                                        <h3 class="group-title">
                                                            <button id="skuAddBtn" type="button" class="hoe-btn">添加规格项目</button>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="help-block">如有颜色、尺码等多种规格，请添加商品规格</p></div>
                                        </div>
                                </div>
                                <div class="form-control-group stock-field {{ count($stocks) ? '' : 'hide' }}" id="stockBox">
                                    <label class="form-control-label">规格明细：</label>
                                    <div class="form-control-controls">
                                        <div class="table-sku-wrap" style="width: 710px;">
                                            <table class="table-sku-stock">
                                                <thead>
                                                <tr>
                                                    @foreach(array_keys($skus) as $sType)
                                                        <th>{{ $sType }}</th>
                                                    @endforeach
                                                    <th class="th-price"><em class="zent-form__required">*</em>价格（元）</th>
                                                    <th class="th-stock"><em class="zent-form__required">*</em>库存</th>
                                                    <th class="th-code">规格编码<div class="zent-popover-wrapper zent-pop-wrapper" style="display: inline-block;"><span class="help-circle"><i class="zenticon zenticon-help-circle"></i></span></div></th>
                                                    <th class="text-cost-price">成本价<div class="zent-popover-wrapper zent-pop-wrapper" style="display: inline-block;"><span class="help-circle"><i class="zenticon zenticon-help-circle"></i></span></div></th>
                                                    <th class="text-right">销量</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($stocks as $stock)
                                                <tr key="{{ $stock->k }}">
                                                    @foreach($stock->cols as $col)
                                                    <td {!! isset($col->s) ? 'rowspan="'.$col->s.'"' : '' !!}>{{ $col->v }}</td>
                                                    @endforeach
                                                    <td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="price" autocomplete="off" value="{{ $stock->price or '' }}"></div></div></div></td>
                                                    <td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="stock_num" autocomplete="off" value="{{ $stock->stock_num or '' }}"></div></div></div></td>
                                                    <td><div class="widget-form__group-row"><div class="zent-input-wrapper input-mini2"><input type="text" class="hoe-input" name="code" autocomplete="off" value="{{ $stock->code or '' }}"></div></div></td>
                                                    <td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="cost_price" autocomplete="off" value="{{ $stock->cost_price }}"></div></div></div></td>
                                                    <td>0</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td class="batch-opts" colspan="6">
                                                        <span>批量设置：</span>
                                                        <span>
                                                            <a href="javascript:;" id="skuPriceBtn" style="margin-right: 10px;">价格</a>
                                                            <a href="javascript:;" id="skuStockBtn">库存</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group ">
                                    <label class="form-control-label"><em class="form-required">*</em>价格：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <span class="input-small">
                                                <div class="zent-number-input-wrapper">
                                                    <div class="input-wrapper hoe-input-addons">
                                                        <span class="hoe-input-addon-before">¥</span>
                                                        <input id="gPrice" name="price" type="text" class="hoe-input" placeholder="1.00" value="{{ $goods->price or 0 }}">
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group ">
                                    <label class="form-control-label">划线价：</label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small" style="margin-left: 0px;">
                                                <div class="input-wrapper">
                                                    <input id="gOriginPrice" name="origin_price" type="text" class="hoe-input" value="{{ $goods->origin_price or 0 }}">
                                                </div>
                                            </span>
                                            <div class="help-block">商品没有优惠的情况下，划线价在商品详情会以划线形式显示。
                                                <div class="zent-popover-wrapper zent-pop-wrapper" style="display: inline-block;">
                                                    <a href="javascript:;">示例</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group total-stock-field">
                                    <label class="form-control-label"><em class="form-required">*</em>库存：</label>
                                    <div class="form-control-controls">
                                        <div><span class="input-small">
                                                <div class="zent-number-input-wrapper">
                                                    <div class="input-wrapper">
                                                        <input id="gStock" type="text" class="hoe-input" name="quantity" placeholder="999999" value="{{ $goods->quantity or 0 }}">
                                                    </div>
                                                </div>
                                            </span>
                                            <div>
                                                <label class="show-stock-checkbox zent-checkbox-wrap">
                                                    <span class="zent-checkbox">
                                                        <span class="zent-checkbox-inner"></span>
                                                        <input type="checkbox" name="hide_stock" value=""></span>
                                                    <span>商品详情不显示剩余件数</span>
                                                </label>
                                            </div>
                                            <p class="help-block">库存为 0 时，会放到『已售罄』的商品列表里，保存后买家看到的商品可售库存同步更新</p></div>
                                        </div>
                                </div>
                                <div class="form-control-group no-label">
                                    <label class="form-control-label"></label>
                                    <div class="form-control-controls">
                                        <div class="fold-field">
                                            <i class="hoeicon hoeicon-caret-down is-close"></i>
                                            <span class="fold-field-txt">更多设置</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group small-field">
                                    <label class="form-control-label">商品编码：</label>
                                    <div class="form-control-controls">
                                        <div class="input-wrapper">
                                            <input id="gItemNo" type="text" class="hoe-input" name="item_no" value="{{ $goods->item_no or '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-control-group ">
                                    <label class="form-control-label">成本价：</label>
                                    <div class="form-control-controls">
                                        <div>
                                            <span class="input-small" style="margin-left: 0px;">
                                                <div class="zent-number-input-wrapper">
                                                    <div class="input-wrapper hoe-input-addons">
                                                        <span class="hoe-input-addon-before">¥</span>
                                                        <input id="gCost" name="item_cost" type="text" class="hoe-input" value="{{ $goods->item_cost or 0 }}">
                                                    </div>
                                                </div>
                                            </span>
                                            <p class="help-block">成本价未来会用于营销建议，利润分析等</p>
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
                                                                <input type="text" class="hoe-input" name="item_weight" value="">
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
                                        <div class="hoe-radio-group single-radio" hoe-radio="{{ $goods->star or 0 }}">
                                            <label class="hoe-radio-wrap checked">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input name="star" type="radio" value="0" checked>
                                                </span>
                                                <span><span>立即上架售卖</span></span>
                                            </label>
                                            <label class="hoe-radio-wrap">
                                                <span class="hoe-radio">
                                                    <span class="hoe-radio-inner"></span>
                                                    <input name="star" type="radio" value="1">
                                                </span>
                                                <span>
                                                    <div class="inline">
                                                        <span>自定义上架时间</span>
                                                        <div class="hoe-datetime-picker">
                                                            <div class="hoe-popover-wrapper" style="display: block;">
                                                                <div class="picker-input">
                                                                    <div class="hoe-input-wrapper">
                                                                        <input id="gStarTime" name="start_sold_time" type="text" class="hoe-input" placeholder="请选择上架售卖时间">
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
                                                    <input name="star" type="radio" value="2">
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
                            <button type="button" class="btn btn-default btn-sm save-btn">保存并查看</button>
                            <button type="button" class="btn btn-info btn-sm next-btn">下一步</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="step-content hide">
            <div>
                <textarea id="item_richtext" ui-editor class="form-control">{!! $goods->richtext or '' !!}</textarea>
            </div>
            <div class="app-design">
                <div class="app-actions">
                    <div class="form-actions text-center">
                        <button type="button" class="btn btn-default btn-sm prev-btn">上一步</button>
                        <button type="button" class="btn btn-info btn-sm save-btn" data-step="2">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $("#skuAddBtn").click(function () {
                var gCount = $(this).closest('div.rc-sku-group').prevAll('.rc-sku-group').length;
                if (gCount < 3) {
                    var $tpl = $('<div class="rc-sku-group">\n' +
                        '<h3 class="group-title">\n' +
                        '    <span class="group-title__label">规格名：</span>\n' +
                        '    <div class="zent-popover-wrapper zent-select" style="display: inline-block;">\n' +
                        '        <input name="sku_type" type="text" class="zent-select-input" placeholder="请选择" value="" maxlength="4">\n' +
                        '    </div>\n' +
                        '    <label class="zent-checkbox-wrap">\n' +
                        '        <span class="zent-checkbox">\n' +
                        '            <span class="zent-checkbox-inner"></span>\n' +
                        '            <input type="checkbox" value="on">\n' +
                        '        </span>\n' +
                        '        <span>添加规格图片</span>\n' +
                        '    </label>\n' +
                        '    <span class="group-remove">×</span>\n' +
                        '</h3>\n' +
                        '<div class="group-container">\n' +
                        '    <span class="sku-list__label">规格值：</span>\n' +
                        '    <div class="sku-list">\n' +
                        '        <span class="sku-add">添加规格值</span>\n' +
                        '    </div>\n' +
                        '</div>\n' +
                        '<div class="sku-group-cont"></div>\n' +
                        '</div>');
                    $(this).closest('div.rc-sku-group').before($tpl);
                    $tpl.find('[name=sku_type]:text').focus();
                    if (gCount == 2) {
                        $(this).closest('div.rc-sku-group').addClass('hide');
                    }
                }
                //$("#gPrice").attr('readonly', true);
                $("#gStock").attr('readonly', true);
                //$("#gCost").attr('readonly', true);
            });

            $(document)
                // 规格名变化
                .on('change', '#skuFieldBox .rc-sku-group .group-title [name=sku_type]', function () {
                    Stocker.update();
                })
                // 规格值添加
                .on('click', '#skuFieldBox .rc-sku-group .sku-list .sku-add', function () {
                    if (!$(this).closest('.rc-sku-group').find('input[name=sku_type]').val()) {
                        alert('请先填写规格名！');
                    } else {
                        var $tpl = $('<div class="rc-sku-item">\n' +
                            '            <div class="zent-popover-wrapper zent-select  " style="display: inline-block;">\n' +
                            '                <input type="text" class="zent-select-input" placeholder="请选择" maxlength="20">\n' +
                            '            </div>\n' +
                            '            <span class="item-remove small">×</span>\n' +
                            '        </div>');
                        $(this).before($tpl);
                        $tpl.find(':text').focus();
                    }
                })
                .on('change', '#skuFieldBox .rc-sku-group .sku-list .rc-sku-item input:text', function () {
                    var skuArr = [];
                    var isOk = true;
                    $(this).closest('.sku-list').find('input:text').each(function () {
                        var sku = $(this).val();
                        if (sku) {
                            if (skuArr.indexOf(sku) == -1) {
                                skuArr.push($(this).val());
                            } else {
                                isOk = false;
                                alert('规格值不能相同！');
                                $(this).focus().select();
                                return false;
                            }
                        }
                    });
                    isOk && Stocker.update();
                })
                // 规格移除
                .on('click', '#skuFieldBox .rc-sku-group .group-remove', function () {
                    $(this).closest('.rc-sku-group').remove();
                    var gCount = $("#skuAddBtn").closest('div.rc-sku-group').prevAll('.rc-sku-group').length;
                    if (gCount < 3) {
                        $("#skuAddBtn").closest('div.rc-sku-group').removeClass('hide');
                    }
                    Stocker.update();

                    if (gCount <= 0) {
                        $("#gPrice").removeAttr('readonly');
                        $("#gStock").removeAttr('readonly');
                        $("#gCost").removeAttr('readonly');
                    }
                })
                // 规格值移除
                .on('click', '#skuFieldBox .rc-sku-group .sku-list .rc-sku-item .item-remove', function () {
                    $(this).closest('.rc-sku-item').remove();
                    Stocker.update();
                });

            // 批量添加库存价格
            $("#skuPriceBtn").click(function () {
                var price = prompt('请输入价格');
                $("#stockBox table.table-sku-stock tbody tr td input[name=price]")
                    .val(parseFloat(price) || 0)
                    .trigger('change');
            });

            // 批量添加库存价格
            $("#skuStockBtn").click(function () {
                var stock = prompt('请输入库存');
                $("#stockBox table.table-sku-stock tbody tr td input[name=stock_num]")
                    .val(parseFloat(stock) || 0)
                    .trigger('change');
            });

            // 更多设置button
            $(".form-control-group .fold-field").click(function () {
                $(this).closest('.form-control-group').nextAll().toggle();
                $(this).find('i').toggleClass('is-close');
            });

            // 下一步按钮
            $(".step-content .form-actions button.next-btn").click(function () {
                var $content = $(this).closest('.step-content');
                $content.addClass('hide');
                $content.next().removeClass('hide');
                $content.prevAll('.bc-steps').find('.step-item.active').next().addClass('active');
            });

            // 上一步按钮
            $(".step-content .form-actions button.prev-btn").click(function () {
                var $content = $(this).closest('.step-content');
                $content.addClass('hide');
                $content.prev().removeClass('hide');
                $content.prevAll('.bc-steps').find('.step-item.active').last().removeClass('active');
            });

            // 保存按钮
            $(".step-content .form-actions button.save-btn").click(function () {
                var data = {
                    'id':'{{ $goods->id or 0 }}',
                    'name':$('#gTitle').val(),
                    'category_id':$("#gCategory").val(),
                    'venue_id':$("#gVenue").val(),
                    'desc':$("#gDesc").val(),
                    'price':$("#gPrice").val(),
                    'origin_price':$("#gOriginPrice").val(),
                    'quantity':$("#gStock").val(),
                    'item_no':$("#gItemNo").val(),
                    'item_cost':$("#gCost").val(),
                    'star':$('input[name=star]:checked').val(),
                    'item_type':$('input[name=item_type]:checked').val(),
                    'star_time':$("#gStarTime").val()
                };
                var stocks = Stocker.stock();
                if (stocks.length > 0) {
                    if (!Stocker.verify()) {
                        alert('商品规格填写有误！');
                        return;
                    }
                    data.stocks = stocks;
                }
                if ($(this).attr('data-step') == '2') {
                    data.richtext = CKEDITOR.instances.item_richtext.getData();;
                }

                $.APIAjaxByPost('/platform/product/items/store', data, function (result) {
                    if (result && result.state) {
                        alert('保存成功！');
                        if (data.id > 0) {
                            window.location.reload();
                        } else {
                            if (result.data && result.data > 0) {
                                window.href = '/platform/product/items/edit/' + result.data;
                            } else {
                                window.href = '/platform/product/items';
                            }
                        }
                    } else {
                        alert(result && result.msg ? result.msg : '保存失败！');
                    }
                });
            });

            Stocker.init({!! json_encode($stocks) !!});
        });

        var Stocker = (function ($) {
            var curr_stock = {};
            var curr_sku = [];

            function getSku() {
                var sku = [];
                $("#skuFieldBox .rc-sku-group").not(':last-child').each(function () {
                    var skuType = $(this).find('.group-title [name=sku_type]').val();
                    if (skuType && skuType.length > 0) {
                        var skuItems = [];
                        $(this).find('.sku-list .rc-sku-item :text').each(function () {
                            var skuItem = $(this).val();
                            if (skuItem && skuItem.length > 0) {
                                skuItems.push(skuItem);
                            }
                        });
                        if (skuItems.length > 0) {
                            sku.push({'type':skuType, 'items':skuItems});
                        }
                    }
                });
                return sku;
            }

            function update() {
                var sku = getSku();
                if (sku.length != curr_sku.length) {
                    curr_stock = {};
                }

                var skuLen = sku.length;
                var stock = {};
                if (skuLen > 0) {
                    var $tdPrice = $("#stockBox table.table-sku-stock thead th.th-price");
                    $tdPrice.prevAll().remove();
                    $tdPrice.before('<th>' + sku[0].type + '</th>');
                    if (skuLen > 1) {
                        $tdPrice.before('<th>' + sku[1].type + '</th>');
                    }
                    if (skuLen > 2) {
                        $tdPrice.before('<th>' + sku[2].type + '</th>');
                    }

                    var $tbody = $("#stockBox table.table-sku-stock tbody");
                    $tbody.empty();

                    var cols,cols1,cols2,cols3,l,t;

                    $(sku[0].items).each(function (k0, item0) {
                        l = k0.toString();
                        t = item0;
                        cols1 = {'t':sku[0].type, 'v':item0};
                        if (skuLen > 1) {
                            $(sku[1].items).each(function (k1, item1) {
                                l = k0.toString() + k1.toString();
                                t = item0 + item1;
                                cols2 = {'t': sku[1].type, 'v': item1};
                                if (skuLen > 2) {
                                    $(sku[2].items).each(function (k2, item2) {
                                        l = k0.toString() + k1.toString() + k2.toString();
                                        t = item0 + item1 + item2;
                                        cols3 = {'t': sku[2].type, 'v': item2};

                                        cols = curr_stock.hasOwnProperty(l) ? curr_stock[l] : {};
                                        cols['cols'] = [];
                                        cols['k'] = l;
                                        cols['title'] = t;
                                        if (!cols1.hasOwnProperty('s')) {
                                            cols1['s'] = sku[1].items.length * sku[2].items.length;
                                            cols['cols'].push(cols1);
                                        }
                                        if (!cols2.hasOwnProperty('s')) {
                                            cols2['s'] = sku[2].items.length;
                                            cols['cols'].push(cols2);
                                        }
                                        cols['cols'].push(cols3);
                                        cols['$html'] = getSkuUIItem(cols);
                                        stock[l] = cols;
                                        cols.$html.appendTo($tbody);
                                    });
                                } else {
                                    cols = curr_stock.hasOwnProperty(l) ? curr_stock[l] : {};
                                    cols['cols'] = [];
                                    cols['k'] = l;
                                    cols['title'] = t;
                                    if (!cols1.hasOwnProperty('s')) {
                                        cols1['s'] = sku[1].items.length;
                                        cols['cols'].push(cols1);
                                    }
                                    cols['cols'].push(cols2);
                                    cols['$html'] = getSkuUIItem(cols);
                                    stock[l] = cols;
                                    cols.$html.appendTo($tbody);
                                }
                            });
                        } else {
                            cols = curr_stock.hasOwnProperty(l) ? curr_stock[l] : {};
                            cols['cols'] = [];
                            cols['k'] = l;
                            cols['title'] = t;
                            cols['cols'].push(cols1);
                            cols['$html'] = getSkuUIItem(cols);
                            stock[l] = cols;
                            cols.$html.appendTo($tbody);
                        }
                    });
                }

                curr_stock = $.extend({}, stock);
                curr_sku = $.extend([], sku);

                if (Object.keys(curr_stock).length > 0) {
                    $("#stockBox").removeClass('hide');
                } else {
                    $("#stockBox").addClass('hide');
                }
            }

            function getSkuUIItem(config) {
                var $html;
                if (config.hasOwnProperty('$html') && config.$html.length > 0) {
                    $html = config.$html;
                    $(config.cols).each(function (k, col) {
                        $html.find('td').eq(k).text(col.v);
                        if (col.hasOwnProperty('s')) {
                            $html.find('td').eq(k).attr('rowspan', col.s);
                        } else {
                            $html.find('td').eq(k).removeAttr('rowspan');
                        }
                    });
                    if (config.hasOwnProperty('price')) {
                        $html.find('input:text[name=price]').val(config.price);
                    }
                    if (config.hasOwnProperty('stock_num')) {
                        $html.find('input:text[name=stock_num]').val(config.stock_num);
                    }
                    if (config.hasOwnProperty('code')) {
                        $html.find('input:text[name=code]').val(config.code);
                    }
                    if (config.hasOwnProperty('cost_price')) {
                        $html.find('input:text[name=cost_price]').val(config.cost_price);
                    }
                } else {
                    var tds = [];
                    $(config.cols).each(function (k, col) {
                        tds.push('<td' + (col.hasOwnProperty('s') ? ' rowspan="' + col.s + '"' : '') + '>' + col.v + '</td>');
                    });
                    tds.push('<td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="price" autocomplete="off" value="' + (config.hasOwnProperty('price') ? config.price : '') + '"></div></div></div></td>');
                    tds.push('<td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="stock_num" autocomplete="off" value="' + (config.hasOwnProperty('stock_num') ? config.stock_num : '') + '"></div></div></div></td>');
                    tds.push('<td><div class="widget-form__group-row"><div class="zent-input-wrapper input-mini2"><input type="text" class="hoe-input" name="code" autocomplete="off" value="' + (config.hasOwnProperty('code') ? config.code : '') + '"></div></div></td>');
                    tds.push('<td><div class="widget-form__group-row"><div class="zent-number-input-wrapper input-mini"><div class="zent-input-wrapper input-mini"><input type="text" class="hoe-input" name="cost_price" autocomplete="off" value="' + (config.hasOwnProperty('cost_price') ? config.cost_price : '') + '"></div></div></div></td>');
                    tds.push('<td>0</td>');
                    $html = $('<tr key="' + config.k + '">' + (tds.join("\n")) + '</tr>');
                }

                return $html;
            }

            function setSum() {
                var stock = 0;
                $("#stockBox table.table-sku-stock tbody tr input[name=stock_num]").each(function () {
                    var stock_num = $(this).val();
                    stock += parseInt(stock_num, 10);
                });
                $("#gStock").val(stock);
            }

            function getStock() {
                var stockValues = Object.values(curr_stock);
                var stocks = [];
                $(stockValues).each(function (k, v) {
                    stocks.push({
                        'cols':v.cols,
                        'title':v.title,
                        'k':v.k,
                        'price':v.price,
                        'code':v.code,
                        'cost_price':v.cost_price,
                        'stock_num':v.stock_num
                    });
                });
                return stocks;
            }

            function verifyStock() {
                var state = true;
                $("#stockBox table.table-sku-stock tbody tr").each(function () {
                    var key = $(this).attr('key');
                    var price = $(this).find('input[name=price]').val();
                    if (!(price > 0 && curr_stock[key]['price'] > 0)) {
                        $(this).find('input[name=price]').focus();
                        return (state = false);
                    }

                    var stock_num = $(this).find('input[name=stock_num]').val();
                    if (!(stock_num > 0 && curr_stock[key]['stock_num'] > 0)) {
                        $(this).find('input[name=stock_num]').focus();
                        return (state = false);
                    }
                });

                return state;
            }

            function init(stocks) {
                curr_sku = getSku();
                curr_stock = {};
                if (typeof stocks === "object" && stocks && stocks.length > 0) {
                    $(stocks).each(function (k, v) {
                        v['$html'] = $('#stockBox table.table-sku-stock tbody tr[key=' + v.k + ']');
                        curr_stock[v.k] = v;
                    });
                    curr_stock = stocks;
                }

                $(document).on('change', '#stockBox table.table-sku-stock tbody input:text', function () {
                    var key = $(this).closest('tr').attr('key');
                    if (curr_stock.hasOwnProperty(key)) {
                        var name = $(this).attr('name');
                        if (name) {
                            var value = $(this).val();
                            curr_stock[key][name] = value || '';
                        }
                        if (name == 'stock_num') {
                            setSum();
                        }
                    }
                })
            }

            return {
                'update' : update,
                'stock' : getStock,
                'verify' : verifyStock,
                'init' : init
            };
        })(jQuery);
    </script>
@stop