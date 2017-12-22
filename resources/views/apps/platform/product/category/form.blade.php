<div id="categoryModal" class="modal fade" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog" style="width:280px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">编辑类目</h4>
            </div>
            <div class="modal-body">
                <div class="wrapper">
                    <div class="panel bg-white">
                        <form>
                            <input type="hidden" class="form-control" name="id" required="required"/>
                            <div class="form-group">
                                <label>父级类目：</label>
                                <select name="pid" class="form-control">
                                    <option value="0">顶级类目</option>
                                    @foreach($tops as $row)
                                        <option value="{{ $row->id }}" {{ (is_numeric($pid) && $pid == $row->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>类目名称：</label>
                                <input type="text" class="form-control" name="name" required="required"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal">取消</button>
                <button name="submit" type="button"  class="btn btn-primary">提交</button>
            </div>
        </div>
    </div>
</div>