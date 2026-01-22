<!-- BEGIN: main -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>{LANG.student}</th>
                <th>{LANG.test_date}</th>
                <th>{LANG.dominant_group}</th>
                <th>{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{ROW.id}</td>
                <td>{ROW.fullname}</td>
                <td>{ROW.test_date}</td>
                <td>{ROW.dominant_group}</td>
                <td>
                    <!-- <a href="#" class="btn btn-xs btn-info">{LANG.view_chat_log}</a> -->
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- END: main -->
