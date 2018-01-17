<!-- nav -->
<nav ui-nav class="navi clearfix">
    <ul class="nav" ui-nav>
        @foreach(app_menus() as $idx => $top)
            @if($top->parent_id > 0 || count(app_menus()) > 1)
                @if(isset($top->children) && count($top->children) > 0)
                    @if(!isset($top->isFirst) || !$top->isFirst)
                        <li class="line dk"></li>
                    @endif
                    @if($top->name)
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>{{ $top->name }}</span>
                        </li>
                    @endif
                    @foreach($top->children as $item)
                        <li>
                            <a href="{{ $item->url or '#' }}">
                                @if(isset($item->children) && count($item->children) > 0)
                                    <span class="pull-right text-muted">
                                        <i class="fa fa-fw fa-angle-right text"></i>
                                        <i class="fa fa-fw fa-angle-down text-active"></i>
                                    </span>
                                    <b class="badge bg-info pull-right">{{ count($item->children) }}</b>
                                @endif

                                @if($item->icon)
                                    <i class="{{ $item->icon }}" ui-color></i>
                                @endif
                                <span>{{ $item->name }}</span>
                            </a>

                            @if(isset($item->children) && count($item->children) > 0)
                                <ul class="nav nav-sub dk">
                                    @foreach($item->children as $sub)
                                        <li class="nav-sub-header">
                                            <a href="{{ $sub->url or '#' }}">
                                                <span>{{ $sub->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @else
                    @if($top->name)
                        <li>
                            <a href="{{ $top->url }}">
                                @if($top->icon)
                                    <i class="{{ $top->icon }}" ui-color></i>
                                @endif
                                <span title="{{ $top->name }}">{{ $top->name }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if($top->name)
                    <li>
                        <a href="{{ $top->url }}">
                            @if($top->icon)
                                <i class="{{ $top->icon }}" ui-color></i>
                            @endif
                            <span title="{{ $top->name }}">{{ $top->name }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</nav>
<!-- nav -->
<!-- / list -->