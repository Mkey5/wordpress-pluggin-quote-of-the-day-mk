<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2.11.2017 г.
 * Time: 15:29
 */

function q_mk_update() {
    $id = isset($_GET["id"]) ? trim($_GET["id"]) : null;
    $author = isset($_POST["author"]) ? trim($_POST["author"]) : null;
    $profession = isset($_POST['profession']) ? trim($_POST['profession']) : null;
    $quote = isset($_POST["quote"]) ? trim($_POST["quote"]) : null;
    $delete = isset($_POST['delete']) ? $_POST['delete'] : null;
    $update = isset($_POST['update']) ? $_POST['update'] : null;
    $message = "";
    $errors = "";

    //    simple validation
    if (empty($author)){
        $errors.=" Enter Author!";
    }else if(strlen($author) < 3){
        $errors.=" Author name was too short!";
    }

    if (empty($profession)){
        $errors.=" Enter Author Profession!";
    }else if(strlen($profession) < 3){
        $errors.=" Author Profession was too short!";
    }

    if (empty($quote)){
        $errors.=" Enter Quote!";
    }else if(strlen($quote) < 5){
        $errors.=" Quote was too short!";
    }else if (strlen($quote) > 140){
        $errors.=" Quote was too long!";
    }


    try{
        global $wpdb;
        $table_name = $wpdb->prefix . "quote_mk";
//update
        if (isset($update) && empty($errors)) {
            $wpdb->update(
                $table_name, //table
                array('author' => $author, 'profession' => $profession, 'quote' => $quote, 'update_at' => date('Y-m-d H:i:s')), //data
                array('ID' => $id), //where
                array('%s'), //data format
                array('%s') //where format
            );
            $message = "Quote Updated successfully!";
        } //delete
        else if (isset($delete)) {
            $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
            $message = "Quote Deleted successfully!";
        } else {//selecting value to update
            $quotes = $wpdb->get_results($wpdb->prepare("SELECT id, author, profession, quote from $table_name where id=%s", $id));
            $author = $quotes[0]->author;
            $quote = $quotes[0]->quote;
            $profession = $quotes[0]->profession;
        }
    }catch (Exception $e){
        $errors.= " ".$e->getMessage();
    }

    ?>
    <div class="container-fluid">

        <?php if (!empty($message) && empty($errors)) { ?>
            <div class="updated">
                <p><?php echo $message; ?></p>
                <a href="<?php echo admin_url('admin.php?page=q_mk_list') ?>">&laquo; Back to Quotes list</a>
            </div>
        <?php } else { ?>
            <div class="col-md-4">
                <h2>Update Quote</h2>
                <form method="post" action="<?php echo $_SERVER['QUOTE_MK_PLUGIN_DIR']; ?>">
                    <div class="panel panel-primary" id="panel1">
                        <div class="panel-heading">
                            <p class="author-title" >Author</p>
                            <input type="text" name="author" placeholder="Add Author:" value="<?php echo $author; ?>"
                                   class="ss-field-width"/>
                            <p class="author-title">Profession</p>
                            <input type="text" name="profession"  placeholder="Add Profession:" value="<?php echo $profession; ?>"
                                   class="ss-field-width"/>
                        </div>
                        <div class="panel-body">
                            <p class="quote-title">Quote text</p>
                            <textarea type="text" maxlength="140" name="quote" placeholder="Add Quote:"
                                      class="ss-field-width quote-mk-text"><?php echo $quote; ?></textarea>
                            <p class="quote-mk-length-of-text"></p>
                            <br>
                            <a href="<?php echo admin_url('admin.php?page=q_mk_list') ?>" class="btn btn btn-primary">Back
                                to Quotes List</a>
                            <input type='submit' name="delete" value='Delete' class="btn btn btn-danger btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this quote?')">
                            <input type='submit' name="update" value='Save' class="btn btn-success btn-add">
                        </div>
                    </div>
                    <?php
                    if(!empty($errors) && isset($update)){
                        echo "<p class='alert alert-danger'>Error: " . $errors . "</p>";
                    }
                    ?>
                </form>
            </div>
        <?php } ?>

    </div>
    <?php
}