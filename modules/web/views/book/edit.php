<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">图书设置</h2>
        <div class="form-horizontal m-t">
            <div class="form-group">
                <label class="col-lg-2 control-label">图书分类:</label>
                <div class="col-lg-10">
                    <select name="cat_id" class="form-control">
                        <option value="0">请选择分类</option>
                        <option value="2"  >互联网</option>
                        <option value="1"  >政治类</option>
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书名" name="name" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书价格:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书售价" name="price" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">封面图:</label>
                <div class="col-lg-10">
                    <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST" action="/web/upload/pic">
                        <div class="upload_wrap pull-left">
                            <i class="fa fa-upload fa-2x"></i>
                            <input type="hidden" name="bucket" value="book" />
                            <input type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                        </div>
                    </form>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书描述:</label>
                <div class="col-lg-8">
                    <textarea   id="editor"  name="summary" style="height: 300px;"></textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">库存:</label>
                <div class="col-lg-2">
                    <div class="input-group">
                        <div class="input-group-addon hidden">
                            <a class="disabled" href="javascript:void(0);">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                        <input type="text" name="stock" class="form-control" value="1">
                        <div class="input-group-addon hidden">
                            <a href="javascript:void(0);">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="tags" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="0">
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
