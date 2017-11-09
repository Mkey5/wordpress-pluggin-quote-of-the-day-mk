<?php

/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 3.11.2017 г.
 * Time: 10:44
 */

class Paginator {

    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct( $conn, $query ) {
        $this->_conn = $conn;
        $this->_query = $query;

        $rs = $this->_conn->get_results( $this->_query );
        $this->_total =  $this->_conn->num_rows;
    }

    public function getData( $limit = 10, $page = 1 ) {

        $this->_limit   = $limit;
        $this->_page    = $page;

        if ( $this->_limit == 'all' ) {
            $query      = $this->_query;
        } else {
            $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
        $rs             = $this->_conn->get_results($query);

        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $rs;

        return $result;
    }

    public function createLinks( $links, $list_class ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }

        $last       = ceil( $this->_total / $this->_limit );

        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        $html       = '<ul class="' . $list_class . '">';

        $class      = ( $this->_page == 1 ) ? "disabled" : "";
        $html       .= '<li class="' . $class . '"><a href="?page=q_mk_list&page_limit=' . $this->_limit . '&page_number=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

        if ( $start > 1 ) {
            $html   .= '<li><a href="?page=q_mk_list&page_limit=' . $this->_limit . '&page_number=1">1</a></li>';
            $html   .= '<li class="disabled"><span>...</span></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? "active" : "";
            $html   .= '<li class="' . $class . '"><a href="?page=q_mk_list&page_limit=' . $this->_limit . '&page_number=' . $i . '">' . $i . '</a></li>';
        }

        if ( $end < $last ) {
            $html   .= '<li class="disabled"><span>...</span></li>';
            $html   .= '<li><a href="?page=q_mk_list&page_limit=' . $this->_limit . '&page_number=' . $last . '">' . $last . '</a></li>';
        }

        $class      = ( $this->_page == $last ) ? "disabled" : "";
        $html       .= '<li class="' . $class . '"><a href="?page=q_mk_list&page_limit=' . $this->_limit . '&page_number=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

        $html       .= '</ul>';

        return $html;
    }
}