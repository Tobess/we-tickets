<?php

if (! function_exists('app_name')) {
    /**
     * 获得当前应用名称.
     *
     * @return string
     */
    function app_name()
    {
        $prefix = Route::current()->getPrefix();
        if ($prefix) {
            $delimiter = strpos($prefix, '/');
            $prefix = substr($prefix, 0, $delimiter === false ? strlen($prefix) : $delimiter);
            $apps = array_keys(config('auth.guards'));
            if (in_array($prefix, $apps)) {
                $app = $prefix;
            }
        }

        return $app ?? null;
    }
}

if (! function_exists('app_route')) {
    /**
     * 获得应用相对路由URL.
     *
     * @param  string  $path
     * @return string
     */
    function app_route(string $path)
    {
        $app = app_name();

        return ($app ? "/{$app}" : '') . "/{$path}";
    }
}

if (! function_exists('app_menus')) {
    /**
     * 获得当前登陆应用的功能列表.
     *
     * @param  string  $app
     * @return string
     */
    function app_menus(string $app = null)
    {
        $menus = [];
        if (!$app) {
            $app = app_name();
        }

        if ($app && auth($app)->check()) {
            if (true||!is_array($menus = session('menus'))) {
                try {
                    $mList = DB::table('pms_' . substr($app, 0, 4) . '_menus')->get();
                    $mTmp = [];
                    foreach ($mList as $item) {
                        $mTmp[$item->parent_id][] = $item;
                    }
                    $fn = function ($parent = 0) use ($mTmp, &$fn) {
                        $nodes = [];
                        $_tmpNodes = $mTmp[$parent];
                        $_tmpLen = count($_tmpNodes);
                        foreach ($_tmpNodes as $idx => $item) {
                            if (isset($mTmp[$item->id])) {
                                $item->children = $fn($item->id);
                            }
                            if ($parent == 0 && $_tmpLen > 1) {
                                if ($idx == 0) {
                                    $item->isFirst = true;
                                }
                                if ($idx == ($_tmpLen - 1)) {
                                    $item->isLast = true;
                                }
                            }
                            if ($item->name || isset($item->children)) {
                                $nodes[] = $item;
                            }
                        }

                        return $nodes;
                    };
                    if (count($menus = $fn()) > 0) {
                        session(['menus' => $menus]);
                    }
                } catch (Exception $ex) {
                    Log::info($ex->getMessage());
                }
            }
        }

        return $menus;
    }
}



if (! function_exists('app_view')) {
    /**
     * 获得应用试图PATH.
     *
     * @param  string  $path
     * @return string
     */
    function app_view(string $path)
    {
        $app = app_name();

        return ($app ? "apps.{$app}." : '') . "{$path}";
    }
}