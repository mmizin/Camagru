<?php
Class Model_logout extends Model {

    public function __construct() {
        session_unset();
    }

}