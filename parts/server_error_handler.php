<script>
    function closeReport() {
        document.getElementById("ehandler").style.display = "none";
    }
</script>

<div class="error-handler" id="ehandler"
    <?php if (!isset($CSERROR)) echo "style=\"display: none;\"";?>
>
    <a href="javascript:void(0)" class="close-button" onclick="closeReport()">&times;</a>
    <div class="error-card">
        <?php
        if (isset($CSERROR))
            echo $CSERROR;
        ?>
    </div>
</div> 