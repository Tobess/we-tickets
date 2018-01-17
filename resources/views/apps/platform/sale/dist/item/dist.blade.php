<div id="formAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myAddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myAddModalLabel">新增分销</h4>
            </div>
            <div class="modal-body">
                <div class="wrapper">
                    <div class="panel bg-white">
                        <form>
                            <div class="form-group">
                                <label>分销商户：</label>
                                <select class="form-control" id="dist" data-placeholder="请选择分销商">
                                    @foreach($dists as $dist)
                                        <option value="{{ $dist->id }}">{{ $dist->name }}({{ $dist->mobile }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>分销商品：</label>
                                <select class="form-control" id="item" data-placeholder="请选择分销商品">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} {{ $item->quantity }}件</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label>商品库存：</label>
                                <select class="form-control" id="sku" data-placeholder="请选择分销商库存"></select>
                            </div>
                            <div class="form-group ">
                                <label>分销数量：</label>
                                <input type="text" class="form-control" id="number" required="required"/>
                            </div>
                            <div class="form-group ">
                                <label>分销价格：</label>
                                <input type="text" class="form-control" id="price" required="required"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="submitBtn" type="button"  class="btn btn-primary">提交</button>
            </div>
        </div>
    </div>
</div>