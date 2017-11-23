<?php
?>
<div id="forumTypeID" style="display:none"><?php echo htmlspecialchars($page);?></div>
    <section id="forumThreadWrap">
        <section id="forumThreadHeader">
            <div id="forumThreadTitle">

            </div>
            <div id="forumBack" onclick="window.location.href='/forum.php'">Back</div>
        </section>
        <section id="forumThreadMain">
            <section id="forumThreadListWrap">
                <section id="forumThreadList">
                    List of threads
                </section>
                <section id="newThreadButton" onclick="writeNewThread()">
                    New Thread
                </section>
            </section>
            <section id="forumThreadDetails">
                <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/forum_pages/forumRules.php"); ?>
            </section>
        </section>
    </section>
<script>
    var data = $("#forumTypeID").text();
    ajax_getForum("thread",data)
</script>