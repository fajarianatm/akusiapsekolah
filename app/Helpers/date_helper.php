<?php

function dateFormat($format = 'd-m-Y', $givenDate = null)
{
    return date($format, strtotime($givenDate));
}
