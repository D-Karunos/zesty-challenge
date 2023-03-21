<?php
interface openingHours
{

    function isOpen(DateTime $now);

    function nextOpening(DateTime $now);

}