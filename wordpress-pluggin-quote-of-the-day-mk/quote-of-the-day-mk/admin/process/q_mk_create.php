<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2.11.2017 г.
 * Time: 15:28
 */

function q_mk_create() {
    $author = isset($_POST["author"]) ? trim($_POST["author"]) : null;
    $profession = isset($_POST["profession"]) ? trim($_POST["profession"]) : null;
    $quote = isset($_POST["quote"]) ? trim($_POST["quote"]) : null;
    $insert = isset($_POST['insert']) ? $_POST['insert'] : null;
    $message = "";
    $errors = "";

//    simple validation
    if (empty($author)){
        $errors.=" Enter Author!";
    }else if(strlen($author) < 3){
        $errors.=" Author name too short!";
    }

    if (empty($profession)){
        $errors.=" Enter Author Profession!";
    }else if(strlen($profession) < 3){
        $errors.=" Author Profession too short!";
    }

    if (empty($quote)){
        $errors.=" Enter Quote!";
    }else if(strlen($quote) < 5){
        $errors.=" Quote too short!";
    }else if (strlen($quote) > 140){
        $errors.=" Quote was too long!";
    }


    //insert
    if (isset($insert) && empty($errors)) {
        try{
            global $wpdb;
            $table_name = $wpdb->prefix . "quote_mk";

            $wpdb->insert(
                $table_name, //table
                array('author' => $author, 'profession' => $profession, 'quote' => $quote, 'create_at' => date('Y-m-d H:i:s'), 'update_at' => date('Y-m-d H:i:s')), //data
                array('%s', '%s') //data format
            );
            $message .= "Quote inserted!";
        }catch (Exception $e){
            $errors.= " ".$e->getMessage();
        }
    }
    ?>


    <div class="container-fluid">
        <?php if (!empty($message)) { ?>
            <div class="updated">
                <p><?php echo $message; ?></p>
                <a href="<?php echo admin_url('admin.php?page=q_mk_list') ?>">&laquo; Back to Quotes list</a>
            </div>
        <?php } else { ?>
            <div class="col-md-4">
                <h2>Add New Quote</h2>
                <form method="post" action="<?php echo $_SERVER['QUOTE_MK_PLUGIN_DIR']; ?>">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <p class="author-title">Author</p>
                            <input type="text" name="author"  placeholder="Add Author:" value="<?php echo $author; ?>"
                                   class="ss-field-width"/>
                            <p class="author-title">Profession</p>
                            <input type="text" name="profession"  placeholder="Add Profession:" value="<?php echo $profession; ?>"
                                   class="ss-field-width"/>
                        </div>
                        <div class="panel-body">
                            <p class="quote-title">Quote text</p>
                            <textarea type="text" maxlength="140" name="quote" placeholder="Add Quote:" class="ss-field-width quote-mk-text"><?php echo $quote; ?></textarea>
                            <p class="quote-mk-length-of-text"> </p>
                            <br>
                            <a href="<?php echo admin_url('admin.php?page=q_mk_list') ?>" class="btn btn btn-primary">Back to Quotes List</a>
                            <input type='submit' name="insert" value='Save' class="btn btn-success btn-add">
                        </div>
                    </div>
                    <?php
                        if(!empty($errors) && isset($insert)){
                            echo "<p class='alert alert-danger'>Error: " . $errors . "</p>";
                        }
                    ?>
                </form>
            </div>
        <?php } ?>

    </div>
    <?php
}



