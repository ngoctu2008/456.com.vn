<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&{NV_OP_VARIABLE}={OP}" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.config}</div>
        <div class="panel-body">
            <div class="form-group">
                <label>{LANG.api_key}</label>
                <input class="form-control" type="text" name="api_key" value="{CONFIG.api_key}" />
            </div>
            <div class="form-group">
                <label>{LANG.api_model}</label>
                <select class="form-control" name="api_model">
                    <!-- BEGIN: model_loop -->
                    <option value="{MODEL.key}" {MODEL.selected}>{MODEL.key}</option>
                    <!-- END: model_loop -->
                </select>
            </div>
            <div class="form-group">
                <label>{LANG.system_prompt}</label>
                <textarea class="form-control" name="system_prompt" rows="5">{CONFIG.system_prompt}</textarea>
            </div>
            <div class="text-center">
                <input class="btn btn-primary" name="save" type="submit" value="{LANG.save}" />
            </div>
        </div>
    </div>
</form>
<!-- END: main -->
