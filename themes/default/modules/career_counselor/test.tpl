<!-- BEGIN: main -->
<div class="career-test">
    <h1 class="text-center">{LANG.holland_test_title}</h1>
    <p class="text-center">{LANG.holland_test_desc}</p>

    <form action="{ACTION_URL}" method="post">
        <!-- BEGIN: loop -->
        <div class="question-item panel panel-default">
            <div class="panel-body">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="answers[{ROW.id}]" value="1">
                        {ROW.content}
                    </label>
                </div>
            </div>
        </div>
        <!-- END: loop -->

        <div class="text-center">
            <input type="submit" name="submit_test" class="btn btn-primary btn-lg" value="{LANG.submit_test}" />
        </div>
    </form>
</div>
<!-- END: main -->
