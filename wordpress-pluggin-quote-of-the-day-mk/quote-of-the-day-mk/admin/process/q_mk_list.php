<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2.11.2017 г.
 * Time: 15:28
 */

include_once (QUOTE_MK_PLUGIN_DIR."/admin/process/classes/Paginator.class.php");
function q_mk_list() {
    global $wpdb;
    $page = isset($_GET['page_number']) ?  $_GET['page_number'] : 1;
    $limit = isset($_GET['page_limit']) ? $_GET['page_limit'] : 10;
    $links = isset( $_GET['page_links']) ? $_GET['page_links'] : 7;

    $tableName = $wpdb->prefix . "quote_mk";
    $query = "SELECT id, author, profession, quote from $tableName ORDER BY id DESC ";
//        $rows = $wpdb->get_results("SELECT id, author , quote from $tableName ORDER BY id DESC ");

    $paginator  = new Paginator( $wpdb, $query );
    $results    = $paginator->getData($limit , $page );

    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Quotes List</h2>
            <div class="tablenav top">
                <div class="alignleft actions add-new">
                    <a href="<?php echo admin_url('admin.php?page=q_mk_create'); ?>" class="btn btn-success">Add New</a>
                </div>
                <br class="clear">
            </div>
            <table class='table table-striped table-condensed table-bordered table-rounded'>
                <tr>
                    <th class="manage-column ss-list-sm table-center">IDs</th>
                    <th class="manage-column ss-list-md">Authors</th>
                    <th class="manage-column ss-list-md">Profession</th>
                    <th class="manage-column ss-list-lg">Quotes</th>
                    <th class="manage-column ss-list-sm">Edit</th>
                </tr>
                <?php foreach ($results->data as $row) { ?>
                    <tr>
                        <td class="manage-column ss-list-sm table-center"><?php echo $row->id; ?></td>
                        <td class="manage-column ss-list-md table-authors"><?php echo $row->author; ?></td>
                        <td class="manage-column ss-list-md"><?php echo $row->profession; ?></td>
                        <td class="manage-column ss-list-lg table-quotes"><?php echo $row->quote; ?></td>
                        <td class="manage-column ss-list-sm">
                            <a href="<?php echo admin_url('admin.php?page=q_mk_update&id=' . $row->id); ?>" class="btn btn-info btn-list-update">Update</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php echo $paginator->createLinks( $links, 'pagination pagination-sm' ); ?>
        </div>
    </div>

    <?php
}