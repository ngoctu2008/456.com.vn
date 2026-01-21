<!-- BEGIN: main -->
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">{LANG.add_question}</div>
            <div class="panel-body">
                <form action="{URL_SUBMIT}" method="post">
                    <input type="hidden" name="id" value="{FORM.id}" />
                    <div class="form-group">
                        <label>{LANG.question_content}</label>
                        <textarea class="form-control" name="content" rows="3" required>{FORM.content}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{LANG.group_code}</label>
                        <select class="form-control" name="group_code">
                            <!-- BEGIN: group_loop -->
                            <option value="{GROUP.key}" {GROUP.selected}>{GROUP.key}</option>
                            <!-- END: group_loop -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{LANG.weight}</label>
                        <input class="form-control" type="number" name="weight" value="{FORM.weight}" />
                    </div>
                    <div class="text-center">
                        <input class="btn btn-primary" name="save" type="submit" value="{LANG.save}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{LANG.question_content}</th>
                        <th>{LANG.group_code}</th>
                        <th>{LANG.weight}</th>
                        <th>{LANG.action}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td>{ROW.id}</td>
                        <td>{ROW.content}</td>
                        <td>{ROW.group_code}</td>
                        <td>{ROW.weight}</td>
                        <td>
                            <a href="{ROW.link_edit}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                            <a href="{ROW.link_delete}" class="btn btn-xs btn-danger" onclick="return confirm('{LANG.confirm_delete}');"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: main -->
