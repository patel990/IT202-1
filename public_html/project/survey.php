<?php
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
}
if(isset($_GET["s"])){
    $questionnaire_id = $_GET["s"];
}
else{
    Common::flash("Not a valid survey", "warning");
    die(header("Location: surveys.php"));
}
//TODO: Note, internally calling them questionnaires (and for admin), user facing they're called surveys.
$response = DBH::get_questionnaire_by_id($questionnaire_id);
$available = [];
if(Common::get($response, "status", 400) == 200){
    $available = Common::get($response, "data", []);
}
?>
<div class="container-fluid">
    <!-- see https://www.w3schools.com/php/func_array_reset.asp for use of current() function -->
    <h3><?php echo Common::get(current($available)[0], "questionnaire_name","");?></h3>
    <div class="list-group">
        <?php foreach($available as $s): ?>
            <div class="list-group-item">
                <h4><?php echo Common::get($s[0], "question"); ?></h4>
                <div class="list-group">
                <?php foreach($s as $question):?>
                <div class="list-group-item btn-group-toggle bg-light" data-toggle="buttons">

                    <?php if(Common::get($question, "open_ended", false)):?>
                        <label><?php echo Common::get($question, "answer");?></label>
                        <input class="form-control" type="text"
                               name="answer-<?php echo Common::get($question,"id", -1);?>"/>
                    <?php else:?>
                        <label class="btn btn-secondary btn-lg btn-block">
                            <?php echo Common::get($question, "answer");?>
                        <input autocomplete="off" type="radio"
                               name="answer-<?php echo Common::get($question,"id", -1);?>"/>
                        </label>
                    <?php endif; ?>
                </div>
                <?php endforeach;?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
