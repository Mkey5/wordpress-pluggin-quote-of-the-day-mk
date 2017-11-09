<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 6.11.2017 г.
 * Time: 14:25
 */

/**
 * Adds Foo_Widget widget.
 */
class Quote_MK_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'quote_mk_widget', // Base ID
            esc_html__( 'Quote of the day', 'text_domain' ), // Name
            array( 'description' => esc_html__( 'Widget for display Quote of the day', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        global $wpdb;
        $tableName = $wpdb->prefix . "quote_mk";

//          taking the number of all quotes
        $totalQuotes = $wpdb->get_var("SELECT COUNT(q.`id`) FROM ". $tableName ." AS q");
//          taking random id number
        $randID = rand(1 , $totalQuotes);
//          do while the quotes until we find a quote (because quotes can be deleted)
        do{
            $row = $wpdb->get_results($wpdb->prepare("SELECT q.`author`, q.`profession` , q.`quote` FROM ". $tableName ." AS q WHERE q.`id` = %d" , $randID));
            $randID = rand(1 , $totalQuotes);
        }while(empty($row));

        $result = $row[0];
        $outPut = '
<div class="quote-mk-wrapper hidden">
    <div class="navigation-container">
        <div class="continue-button-quote-mk">Close [X]</div>
    </div>
    <div class="content-container-box-outter">
        <div class="content-container-box-inner">
            <div class="content-inner">
                <h1 class="title">
                    <span class="top ">Quote of</span>
                    <span class="bottom ">the Day</span>
                </h1>
                <div class="body">
                    <div class="body-content">
                    '. $result->quote .'
                    </div>
                    <p class="body-byline">- ' . $result->author . ', <br>' . $result->profession . ' </p>
                 </div>
            </div>
        </div>
    </div>
    
</div>';
        echo $outPut;

    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Quote of the day', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

}