<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="-1">请选择状态</option>
                        <option value="1">正常</option>
                        <option value="0">已删除</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入姓名或者手机号码" class="form-control" value="">
                        <input type="hidden" name="p" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/account/edit">
                        <i class="fa fa-plus"></i>账号
                    </a>
                </div>
            </div>
        </form>
        <table class="table table-bordered m-t">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>13</td>
                    <td>郭威</td>
                    <td>11012345678</td>
                    <td>apanly@163.com</td>
                    <td>
                        <a href="/web/account/info?id=13">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="m-l" href="/web/account/edit?id=13">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <a class="m-l remove" href="javascript:void(0);" data="13">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>编程浪子郭大爷</td>
                    <td>11012345679</td>
                    <td>apanly@126.com</td>
                    <td>
                        <a href="/web/account/info?id=12">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="m-l" href="/web/account/edit?id=12">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <a class="m-l remove" href="javascript:void(0);" data="12">
                            <i class="fa fa-trash fa-lg"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共2条记录 | 每页50条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    <li class="active"><a href="javascript:void(0);">1</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>